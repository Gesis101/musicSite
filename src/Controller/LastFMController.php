<?php

namespace App\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LastFMController extends AbstractController
{
    protected $apiKey = "721387d341e38ff55acd17483c224ede";
    /**
     * @Route("/lastFM", name="lastFM")
     */
    public function index()
    {

        $albumData = $this->getTopAlbums();
        return $this->render('views/lastFm.html.twig',[
            'controller_name' => 'lastFM',
            'lastFMData' => $albumData,
            'error' => null
        ]);
    }
    /**
     * @Route("/lastFM/search", name="lastFM_search")
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $search = $request->query->get('query1');
        if (!$search){
            $search = 'drake';
            $err = 'Please type in correct artist';
        }

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://ws.audioscrobbler.com',
            'defaults' => [
                'exceptions' => false
            ]
        ]);
        dump($search);

        $response = $client->request('GET', '/2.0/?method=artist.getTopAlbums&limit=10&artist='.$search.'&api_key='.$this->apiKey.'&format=json');
        $x = 0;
        $trackData = array();
        $albumData = json_decode($response->getBody()->getContents(), true);
        foreach ($albumData['topalbums']['album'] as $value){
            $response1 = $client->request(
                'GET',
                '/2.0/?method=album.getinfo&artist='.$search.'&api_key=721387d341e38ff55acd17483c224ede&format=json&album='.$value['name']
             );
            $trackData = json_decode($response1->getBody()->getContents(), true);
            array_push($albumData['topalbums']['album'][$x], $trackData['album']['tracks']);
            $x++;
        }



        dump($albumData);
        return $this->render('views/lastFm_search.html.twig', [
            'controller_name' => 'lastFM',
            'lastFMData' => $albumData,
            'error' => null
        ]);
    }
    //Grabs the top 30 artists from lastFM charts then uses the artist names to grab their top albums.
    private function getLastFMTop15Artists(){
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://ws.audioscrobbler.com',
            'defaults' => [
                'exceptions' => false
            ]
        ]);
        $response = $client->request('GET', '/2.0/?method=chart.getTopArtists&limit=30&api_key='.$this->apiKey.'&format=json');

        $data = json_decode($response->getBody(), true);
        $artists = [];
        foreach ($data['artists']['artist'] as $names) {
            array_push($artists, $names['name']);
        }

        return $artists;
    }
    //Gets top albums of the top 15 artists
    private function getTopAlbums(){
        $artists = $this->getLastFMTop15Artists();
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://ws.audioscrobbler.com',
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        $tracks = array();
        $albums = array();
        $x = 0;
        foreach ($artists as $artist){
            $response = $client->request('GET', '/2.0/?method=artist.getTopAlbums&limit=1&artist='.$artist.'&api_key='.$this->apiKey.'&format=json');
            $response1 = $client->request('GET', '/2.0/?method=artist.getTopTracks&artist='.$artist.'&api_key='.$this->apiKey.'&format=json&limit=3');

            $data = json_decode($response->getBody()->getContents(), true);
            $data1 = json_decode($response1->getBody()->getContents(), true);
            array_push($albums, $data['topalbums']['album']);
            array_push($tracks, $data1['toptracks']['track']);

            array_push($albums[$x],$tracks[$x]);
            // array_push($albums, $data['topalbums']['album'][0]['name'],$data['topalbums']['album'][0]['artist']['name'], $data['topalbums']['album'][0]['url'] ,$data['topalbums']['album'][0]['image'][1]['#text']);
            $x++;
        }


        return $albums;
    }


}
