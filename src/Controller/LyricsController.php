<?php

namespace App\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LyricsController extends AbstractController
{
    /**
     * @Route("/lyrics/{artist}/{songName}", name="lyrics")
     */
    public function index(Request $request, $artist, $songName)
    {
      //  $artist = $request->query->get('artist');
      //  $albumName = $request->query->get('albumName');
        $data = $this->getLyrics($artist,$songName);

        $artist = urldecode($artist);
        $songName = urldecode($songName);
        dump($data);
        return $this->render('views/lyrics.html.twig', [
            'controller_name' => 'LyricsController',
            'error' => null,
            'artist' => $artist,
            'songName' => $songName,
            'lyrics' => $data
        ]);
    }

    public function getLyrics($artist, $songName){

        $client = new Client([
            'base_uri' => 'https://canarado-lyrics.p.rapidapi.com',
            'headers' => ['x-rapidapi-host' => 'canarado-lyrics.p.rapidapi.com',
                'x-rapidapi-key' => '4ce0e47f35msh40accc404393b82p10af45jsn9fb889e980d9']
        ]);

        $response = $client->request('GET', '/lyrics/'.$artist.''.$songName);


        $data = json_decode($response->getBody(), true);
        return $data;
    }
}
