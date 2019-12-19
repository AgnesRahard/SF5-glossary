<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('admin');
        // $user->setPassword($this->passwordEncoder($user,'1234'));
        $user->setPassword($this->passwordEncoder->encodePassword(
                      $user,
                      '1234'
                  ));
        $user->setRoles(["ROLES_ADMIN"]);

        $manager->persist($user);
        $manager->flush();
    }
}
