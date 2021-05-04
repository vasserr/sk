<?php

namespace App\Domain\EndpointManagement;

use App\Domain\ProjectManagement\Project;
use App\Supply\Traits\EntityManagerTrait;

class EndpointManager implements EndpointManagerInterface
{
    use EntityManagerTrait;

    public function create(Project $project, string $path, int $responseCode, ?string $responseBody): Endpoint
    {
        $endpoint = new Endpoint();
        $endpoint->setProject($project);
        $endpoint->setPath($path);
        $endpoint->setResponseCode($responseCode);
        $endpoint->setResponseBody($responseBody);
        $this->save($endpoint);

        return $endpoint;
    }

    public function pause(Endpoint $endpoint): void
    {
        if (Endpoint::STATE_PAUSED === $endpoint->getState()) {
            return;
        }

        $endpoint->setState(Endpoint::STATE_PAUSED);
        $this->save($endpoint);
    }

    protected function save(Endpoint $endpoint): void
    {
        $this->entityManager->persist($endpoint);
        $this->entityManager->flush();
    }

    public function remove(Endpoint $endpoint): void
    {
        $this->entityManager->remove($endpoint);
        $this->entityManager->flush();
    }
}
