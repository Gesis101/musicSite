<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
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
        for ($i = 0; $i < 10; $i++){
            $user = new User();
            $user->setUsername('APIUser'.$i);
            $user->setPassword($this->encoder->encodePassword($user, '0000'));
            $user->setEmail('fake@fake.com');
            $user->setActive(true);
            $user->setId($i);
            if ($this->is_prime($i)){
                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles(['USER_ROLE']);
            }
            $manager->persist($user);
            $apiToken1 = new ApiToken($user);
            $apiToken2 = new ApiToken($user);
            $manager->persist($apiToken1);
            $manager->persist($apiToken2);
        }

        $manager->flush();
    }
    function is_prime($number)
    {
        // 1 is not prime
        if ( $number == 1 ) {
            return false;
        }
        // 2 is the only even prime number
        if ( $number == 2 ) {
            return true;
        }
        // square root algorithm speeds up testing of bigger prime numbers
        $x = sqrt($number);
        $x = floor($x);
        for ( $i = 2 ; $i <= $x ; ++$i ) {
            if ( $number % $i == 0 ) {
                break;
            }
        }

        if( $x == $i-1 ) {
            return true;
        } else {
            return false;
        }
    }

}
