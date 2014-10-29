<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 16:27
 */

use GuzzleHttp\Client;

class ActionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \GuzzleHttp\Exception\RequestException
     */
    public function test404()
    {
        $client = new Client();
        $client->get('http://localhost:63342/SimpleFeedback/src/index.php');
    }

    public function testShow()
    {
        $client = new Client();
        $response = $client->get('http://localhost:63342/SimpleFeedback/src/index.php?action=show');

        $this->assertEquals(200, $response->getStatusCode());

        $expected = '{"commentMessage":"Hello","ipAddress":"127.0.0.1"}';
        $data = $response->json();
        $this->assertEquals($expected, $data[0]);
    }

    public function testPost()
    {
        $client = new Client();
        $response = $client->post(
            'http://localhost:63342/SimpleFeedback/src/index.php',
            array('body' => '{"commentMessage": "Test123"}')
        );
        $body = $response->getBody()->read(1024);
        $expected = '{"commentMessage":"Test123","ipAddress":"127.0.0.1"}';
        $this->assertEquals($expected, $body);
    }

    public function testBadPost()
    {
        try {
            $client = new Client();
            $client->post(
                'http://localhost:63342/SimpleFeedback/src/index.php',
                array('body' => '{"Nope": "Test123"}')
            );
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $this->assertEquals(400, $e->getResponse()->getStatusCode());
        }

        try {
            $client = new Client();
            $client->post(
                'http://localhost:63342/SimpleFeedback/src/index.php',
                array('body' => '{"commentMessage": ""}')
            );
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $this->assertEquals(400, $e->getResponse()->getStatusCode());
        }
    }
}
