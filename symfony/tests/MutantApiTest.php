<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;

/**
  * TestCase utilizados para testear la de Mutantes
  * @author Juan Manuel Lazzarini <juan.manuel.lazzarini@gmail.com>
  * 
  */
class MutantApiTest extends TestCase
{
    public function testGET(): void
    {
        $client = HttpClient::create();
        $response = $client->request(
            'GET',
            'http://192.168.99.100/api/stats'
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testPOST(): void
    {
        $client = HttpClient::create();
        $response = $client->request('POST','http://192.168.99.100/api/mutant',[
            'json' => ['dna' => '["ATGC","CACT","TCAT","CGAA"]']     
        ]);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
