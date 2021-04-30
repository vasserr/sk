<?php

namespace App\Fixtures;

use App\Presentation\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Service\Attribute\Required;

class UserFixture extends Fixture implements OrderedFixtureInterface
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
        $this->setReference(self::TEST_USERNAME, $user);
    }

    #[Required]
    public function setEncoder(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function getOrder(): int
    {
        return 10;
    }
}
