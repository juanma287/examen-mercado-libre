<?php
namespace App\Controller;

use App\Entity\Mutante;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MutantUtilsService;
use App\Service\MutantService;
use App\Repository\MutanteRepository;

/**
  * Controlador utilizado para gestionar mutantes.
  * @author Juan Manuel Lazzarini <juan.manuel.lazzarini@gmail.com>
  * 
  */
class MutantController extends AbstractController
{
    /**
     * Metodo correspondientes con el Nivel 1 del examen,  
     * Se utilizan diversos servicios inyectados, para validar datos y verificar si se corresponden con un mutante
     * 
     * @Route("/mutant", name="mutant")
     */
    public function index(MutantUtilsService $mutantUtilsService, MutantService $mutantService): Response
    {
        // Datos de prueba
        $dnaMutante1 = array("ATGCGA","CAGTGC","TTATGT","AGAAGG","CCCCTA","TCACTG");
        
        $matrizDna = $mutantUtilsService->prereData($dnaMutante1);
        if($mutantUtilsService->isValid($matrizDna)) {
            $result =  $mutantService->isMutant($matrizDna);
        }

        return $this->json([
            'controller' => 'Magneto recruiter',
            'dna' => $dnaMutante1,
            'isMutant' => $result,
        ]);
    }


    /**
     * Metodo correspondientes con el Nivel 2 del examen, 
     * Recibe la secuencia de ADN mediante un HTTP POST con un Json y detecta si un humano es mutante 
     * 
     * @Route("/api/mutant", name="is_mutant", methods={"POST"})
     */
    public function isMutant(Request $request, MutantUtilsService $mutantUtilsService, MutantService $mutantService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $result = false;
        if (empty($data)) { 
            return new JsonResponse(['status' => 'Error: no se enviaron datos, o su formato es incorrecto'],Response::HTTP_BAD_REQUEST);
        }
        else{ 
            $dna = $data['dna'];
            $matrizDna = $mutantUtilsService->prereData($dna); 
            if($mutantUtilsService->isValid($matrizDna)) {
                $result =  $mutantService->isMutant($matrizDna);
                // Guaradamos en la DB el el ADN verificado
                $dnaVerificado = new Mutante();
                $dnaVerificado->setIsmutant($result);
                $dnaVerificado->setDna($dna);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($dnaVerificado);
                $entityManager->flush();           
            }
            else {
                return new JsonResponse(['status' => 'Error: datos incorrectos'],Response::HTTP_BAD_REQUEST);
            }
        }

        if($result) // Si es mutante Retornamos HTTP 200-OK, caso contrario retornamos 403-Forbidden
        return new JsonResponse(Response::HTTP_OK);
        return new JsonResponse(Response::HTTP_FORBIDDEN);
    }


    /**
     * Metodo correspondientes con el Nivel 3 del examen, 
     * Devuelve un Json con las estadísticas de las verificaciones de ADN
     * 
     * @Route("/api/stats", name="mutant_stats", methods={"GET"})
     */
    public function mutantStats(MutanteRepository $mutanteRepository): JsonResponse
    {
        $estadisticas = $mutanteRepository->countMutantAndHuman();
        $count_mutant_dna = $estadisticas[0]['isMutant'];
        $count_human_dna = $estadisticas[0]['isHuman'];
        $ratio = 0;
       
        if($count_human_dna != 0) {
         $ratio = $count_mutant_dna / $count_human_dna;
        }

        return new JsonResponse([
            'count_mutant_dna:' => $count_mutant_dna,
            'count_human_dna:' =>  $count_human_dna,
            'ratio:'=> $ratio
            ]);
        
    }
}
