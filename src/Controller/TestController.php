<?php

namespace App\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://httpbin.org',
            // You can set any number of default request options.
            'timeout'  => 2.0,
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        $response = $client->request('GET', 'ip');

        $data = json_decode($response->getBody(),true);

        // debug information
        dump($response->getStatusCode(), $response, $data);

        $ip = $data['origin'];

        return new Response(
            '<html><body>Your IP Address: ' . $ip .'</body></html>'
        );

    }
}
