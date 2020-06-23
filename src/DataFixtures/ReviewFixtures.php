<?php

namespace App\DataFixtures;


use App\Entity\Songs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Review;
use App\Entity\Albums;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ReviewFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        date_default_timezone_set("Europe/London");
        $now = new \DateTime();

        for($i = 5; $i < 10; $i++){
           $album = new Albums();
            $album->setTitle('We made it'.$i);
            $album->setArtist('Eminem'.$i);
            $album->setAverageRating(5);
            $album->setCategory(5);

            $user = new User();
            $user->setEmail('fake@fake.com'.$i);
            $user->setActive(true);
            $user->setPassword($this->encoder->encodePassword($user, '0000'));
            $user->setRoles(['ROLE_USER']);
            $user->setUsername('user'.$i);

            $songs = new Songs();
            $songs->setAlbum($album);
            $songs->setSongName('song_name'.$i);
            $songs->setUser($user);


            $review = new Review();
            $review->setPostedAt($now);
            $review->setComment($i.". This is test comment number ".$i);
            $review->setUserRating(5);
            $review->setAlbums($album);
            $review->setAuthorName($user);

            $manager->persist($songs);
            $manager->persist($album);
            $manager->persist($user);
           $manager->persist($review);
        }

        $manager->flush();
    }



}
