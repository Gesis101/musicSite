<?php

namespace App\DataFixtures;

use App\Entity\Albums;
use App\Entity\Songs;
use App\Controller\LastFMController;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AlbumFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $lastfm = new LastFMController();
        $data = $lastfm->getTopAlbums();
    foreach ($data as $a){
        $album = new Albums();
        $album->setTitle($a[0]['name']);
        $album->setArtist($a[0]['artist']['name']);
        $album->setImageSource($a[0]['image'][3]['#text']);

        foreach ($a[1] as $s){
            $song = new Songs();
            $song->setAlbum($album);
            $song->setSongName($s['name']);
            $manager->persist($song);

        }
        $manager->persist($album);

        dump($a[1]);
    }


        $manager->flush();
    }
}
