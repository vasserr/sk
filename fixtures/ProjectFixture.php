<?php

namespace App\Fixtures;

use App\Domain\ProjectManagement\Project;
use App\Presentation\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectFixture extends Fixture implements OrderedFixtureInterface
{
    public const TEST_PROJECT_NAME = 'projectForTest';

    public function load(ObjectManager $manager)
    {
        $project = new Project();
        $project->setName(self::TEST_PROJECT_NAME);
        /** @var User $user */
        $user = $this->getReference(UserFixture::TEST_USERNAME);
        $project->setUserId($user->getId());
        $manager->persist($project);
        $manager->flush();
        $this->addReference(self::TEST_PROJECT_NAME, $project);
    }

    public function getOrder(): int
    {
        return 20;
    }
}