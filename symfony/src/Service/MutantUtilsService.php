<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
  * Dicho servicio brinda utilidades para preparar y validar infomacion sobre mutantes
  * @author Juan Manuel Lazzarini <juan.manuel.lazzarini@gmail.com>
  * 
  */
class MutantUtilsService
{
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
}