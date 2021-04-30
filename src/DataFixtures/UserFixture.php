<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Service\Attribute\Required;

class UserFixture extends Fixture
{
    public const TEST_USERNAME = 'userForTest';
    public const TEST_PASSWORD = '123456';
    public const TEST_API_TOKEN = 'apiTokenForTest';

    protected UserPasswordEncoderInterface $userPasswordEncoder;

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername(self::TEST_USERNAME);
        $encodedPassword = $this->userPasswordEncoder->encodePassword($user, self::TEST_PASSWORD);
        $user->setPassword($encodedPassword);
        $user->setApiToken(self::TEST_API_TOKEN);
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $manager->flush();
    }

    #[Required]
    public function setEncoder(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
}
