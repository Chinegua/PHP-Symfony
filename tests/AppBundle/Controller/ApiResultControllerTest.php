<?php
/**
 * Created by PhpStorm.
 * User: chinegua
 * Date: 18/11/17
 * Time: 19:46
 */

namespace AppBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;


class ApiResultControllerTest extends WebTestCase
{

    const RUTA_API = '/api/v1/results/';
    const RUTA_API_ = '/api/v1/results';

    private static $client;

    public static function setUpBeforeClass()
    {
        self::$client = static::createClient();
    }


    public function testIndexAction200(){

        self::$client->request('GET',self::RUTA_API);
        $response = self::$client->getResponse();
        self::assertJson($response->getContent());
        self::assertTrue($response->isSuccessful());


    }

    public function testGetResultAction(){
        self::$client->request('GET',self::RUTA_API.'2');
        $response = self::$client->getResponse();
        self::assertJson($response->getContent());
        self::assertTrue($response->isSuccessful());
    }

    public function testPostUserAction201(){




        $data = [
            "user" => 81,
            "best_score" => 220,
            "last_score" => 150,
        ];

        self::$client->request(
            Request::METHOD_POST, self::RUTA_API_,
            [], [], [], json_encode($data)
        );
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertTrue($response->isSuccessful());
        self::assertJson($response->getContent());

    }

    public function testPostUserAction422(){
        $data = [
            "user" => 81,
            "last_score" => 150
        ];

        self::$client->request(
            Request::METHOD_POST, self::RUTA_API_,
            [], [], [], json_encode($data)
        );
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        self::assertJson($response->getContent());
    }

    public function testPostUserAction400(){
        $data = [
            "user" => 1,
            "best_score" => 220,
            "last_score" => 150
        ];

        self::$client->request(
            Request::METHOD_POST, self::RUTA_API_,
            [], [], [], json_encode($data)
        );
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertJson($response->getContent());
    }

    public function testDeleteResultAction204(){
        self::$client->request(
            Request::METHOD_DELETE,
            self::RUTA_API_ . '/15' //Poner ID concreto del elemento que queremos borrar
        );
        $response = self::$client->getResponse();

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        self::assertEmpty((string) $response->getContent());
    }




}
