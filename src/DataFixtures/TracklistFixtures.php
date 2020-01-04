<?php

namespace App\DataFixtures;

use App\Entity\Tracklist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TracklistFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);


       for ($i = 0; $i < 20; $i++)
        {
            $track = new Tracklist();
             $track->setAlbumId($i);
            $track->setSong('Banger'. $i);
            $manager->persist($track);

         }






        $manager->flush();
    }
}
