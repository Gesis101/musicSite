<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Reviews;

class ReviewFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        date_default_timezone_set("Europe/London");
        $now = new \DateTime();

        for($i = 2; $i < 19; $i++){
            $review = new Reviews();
            $review->setPostedAt($now);
            $review->setUserComment($i.". This is test comment number ".$i);
            $review->setUserId($i);
            $review->setUserRating(5);
            $manager->persist($review);
        }

        $manager->flush();
    }



}
