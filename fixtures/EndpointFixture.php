<?php

namespace App\Fixtures;

use App\Domain\EndpointManagement\Endpoint;
use App\Domain\ProjectManagement\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EndpointFixture extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $endpoint = new Endpoint();
        $endpoint->setPath('testPath');
        /** @var Project $project */
        $project = $this->getReference(ProjectFixture::TEST_PROJECT_NAME);
        $endpoint->setProject($project);
        $endpoint->setResponseCode(401);
        $endpoint->setResponseBody([]);

        $manager->persist($endpoint);
        $manager->flush();
    }

    public function getOrder(): int
    {
        return 30;
    }
}
