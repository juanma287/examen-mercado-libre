<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MutantUtilsService;
use App\Service\MutantService;
/**
  * Controlador utilizado para gestionar mutantes
  * @author Juan Manuel Lazzarini <juan.manuel.lazzarini@gmail.com>
  * 
  */
class MutantController extends AbstractController
{
    /**
     * Metodo que utiliza diversos servicios inyectados, para validar datos ingresados
     * y verificar si dichos datos se corresponden con un mutante
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
    

}
