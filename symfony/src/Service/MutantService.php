<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
  * Servicio principal utilizado para detectar mutantes
  * @author Juan Manuel Lazzarini <juan.manuel.lazzarini@gmail.com>
  * 
  */
class MutantService
{

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
                if($keyColumna >= 3 and $n-$keyFila > 3){
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