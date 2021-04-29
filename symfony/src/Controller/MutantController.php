<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MutantController extends AbstractController
{
    /**
     * Controlador utilizado para gestionar mutantes
     * @author Juan Manuel Lazzarini <juan.manuel.lazzarini@gmail.com>
     * 
     * @Route("/mutant", name="mutant")
     */
    public function index(): Response
    {
        $dnaMutante1 = array("ATGCGA","CAGTGC","TTATGT","AGAAGG","CCCCTA","TCACTG");
        $dnaMutante2 = array("TTAAAA","CAGTGC","TTATTT","AGACGT","GCGTCT","TCACTT");
        $dnaNoMutante = array("ATGCGA","CAGTGC","TTATTT","AGACGG","GCGTCA","TCACTG");
        $matrizDna = $this->prereData($dnaMutante1);
        if($this->isValid($matrizDna)) {
            $result =  $this->isMutant($matrizDna);
        }
    
        return $this->json([
            'controller' => 'Magneto recruiter',
            'dna' => $matrizDna,
            'isMutant' => $result,
        ]);
    }
       
    /**
     * Se crea una matariz de NxN y se hace un split de los datos
     */ 
    public function prereData($dna)
    {
        $matriz = array_map(function($dna) {
            return str_split($dna);
        }, $dna);

        return $matriz;        
    }

    /**
     *  Se valida que los valores de los Strings solo sean: (A,T,C,G) 
     *  Obs: faltan validaciones (tipo de datos, NxN, etc), pero por cuestiones de tiempo, para el presente examen, no se realizan
     */ 
    public function isValid($matrizDna): bool
    {
        $stringsPermitios= array("A","T","C","G");
        $stringValido = true;
        foreach ($matrizDna as $fila) {
            foreach ($fila as $valor) {
               if (!in_array($valor, $stringsPermitios)) {
                 $stringValido = false;
                 break;
               } 
            }
        }
        return $stringValido;
    }

    /**
     * Retora si un humano es mutante (ture) o no (false)
     * 
     * Un humano es mutante, si se encuentra más de una secuencia de cuatro letras
     * iguales, de forma oblicua, horizontal o vertical.
     */ 
    public function isMutant($matrizDna): bool
    {
        $n = count($matrizDna);
        $countSecuencias = 0;
        foreach ($matrizDna as $keyFila=>$fila) {
            foreach ($fila as $keyColumna=>$letra) { // Analizo los extremos, si las letras NO son iguales, no gasto tiempo analizando el medio xq ya se que se trata de una secuencia NO mutante  
                // CASO 1: Igualdad orizontal
                if($keyColumna+3 < $n){
                    if ($letra == $fila[$keyColumna+3]) { // POSIBLE secuencia mutante: Exploro el medio
                        if($letra == $fila[$keyColumna+2] and $letra == $fila[$keyColumna+1]) {                
                        if (++$countSecuencias == 2) // ES MUTANTE: Hay más de una secuencia de cuatro letras iguales
                        break 2;  //Salimos de los 2 ciclos anidados
                        }
                    } 
                } 
                // CASO 2: Igualdad vertical
                if($keyFila+3 < $n){
                    if ($letra ==  $matrizDna[$keyFila+3][$keyColumna]) {  
                        if($letra == $matrizDna[$keyFila+2][$keyColumna] and $letra == $matrizDna[$keyFila+1][$keyColumna]) {                
                        if (++$countSecuencias == 2) 
                        break 2;  
                        }
                    } 
                } 
                // CASO 3.1: Igualdad oblicua: Barrido de izquierda a derecha 
                if($n-$keyColumna > 3 and $n-$keyFila > 3){
                    if ($letra ==  $matrizDna[$keyFila+3][$keyColumna+3]) {  
                        if($letra == $matrizDna[$keyFila+2][$keyColumna+2] and $letra == $matrizDna[$keyFila+1][$keyColumna+1]) {                
                        if (++$countSecuencias == 2) 
                        break 2;  
                        }
                    } 
                } 
                // CASO 3.2: Igualdad oblicua: Barrido de derecha a izquierda
                if($n-$keyColumna <= 3 and $n-$keyFila > 3){
                    if ($letra ==  $matrizDna[$keyFila+3][$keyColumna-3]) {  
                        if($letra == $matrizDna[$keyFila+2][$keyColumna-2] and $letra == $matrizDna[$keyFila+1][$keyColumna-1]) {                
                        if (++$countSecuencias == 2) 
                        break 2;  
                        }
                    } 
                } 
            }
        }
        return $countSecuencias == 2;
    }

}
