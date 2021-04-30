<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Service\MutantUtilsService;
use App\Service\MutantService;

/**
  * TestCase utilizados para testear los servicios relacionados con Mutantes
  * @author Juan Manuel Lazzarini <juan.manuel.lazzarini@gmail.com>
  * 
  */
class MutantServicesTest extends TestCase
{
    public function testMutantUtilsService(): void
    {
        $mutantUtilsService = new MutantUtilsService();
        $mutantService = new MutantService();

        // Matrices de prueba 
        $dnaMutante1 = array("ATGCGA","CAGTGC","TTATGT","AGAAGG","CCCCTA","TCACTG");
        $dnaMutante2 = array("TTAAAA","CAGTGC","TTATTT","AGACGT","GCGTCT","TCACTT");
        $dnaMutanteInvalidData = array("5TfAAA","CAGTGC","TTATTT","AGACGT","GCGTCT","TCACTT");
        $dnaMutante4X4 = array("ATGC","CACT","TCAT","CGAA");
        $dnaMutante10X10 = array("TTGCATGCGA","CACTATGCGA","TCATATGCGA","CGAAATGCGA","CACTATGCGA","CACTATGCGA","CACTATGCGA","CACTATGCGA","CACTATGCGA","CACTATGCGA");
        $dnaNoMutante =  array("TTGAAA","CAGTGC","TTATTT","AGACGT","GCGTCT","TCACTT");

        // Se preparan los datos para ser testeados
        $matrizDna = $mutantUtilsService->prereData($dnaMutante1);
        $matrizDna2 = $mutantUtilsService->prereData($dnaMutante2);
        $matrizDna3 = $mutantUtilsService->prereData($dnaMutanteInvalidData);
        $matrizDna4X4 = $mutantUtilsService->prereData($dnaMutante4X4);
        $matrizDna10X10 = $mutantUtilsService->prereData($dnaMutante10X10);
        $matrizDnaNoMutante = $mutantUtilsService->prereData($dnaNoMutante);

        // Se testea el metodo isValid del servicio MutantUtilsService
        $this->assertEquals(true, $mutantUtilsService->isValid($matrizDna));
        $this->assertEquals(true, $mutantUtilsService->isValid($matrizDna2));
        $this->assertEquals(false, $mutantUtilsService->isValid($matrizDna3));

        // Se testea el metodo isMutant del servicio MutantService
        $this->assertEquals(true, $mutantService->isMutant($matrizDna));
        $this->assertEquals(true, $mutantService->isMutant($matrizDna2));
        $this->assertEquals(true, $mutantService->isMutant($matrizDna4X4));
        $this->assertEquals(true, $mutantService->isMutant($matrizDna10X10));
        $this->assertEquals(false, $mutantService->isMutant($matrizDnaNoMutante));


    }

}
