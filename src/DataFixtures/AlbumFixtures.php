<?php

namespace App\DataFixtures;

use App\Entity\Albums;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AlbumFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);


        for ($t = 0; $t < 16; $t++){
            $album = new Albums();
            $album->setArtist('lilTester'.$t)
                ->setAverageRating(5)
                 ->setCategory(1)
                ->setTitle('WeMadeItTester'.$t);
            $manager->persist($album);
        }

        $manager->flush();
    }
}
