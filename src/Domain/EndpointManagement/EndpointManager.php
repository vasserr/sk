<?php

namespace App\Domain\EndpointManagement;

use App\Domain\ProjectManagement\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class EndpointManager implements EndpointManagerInterface
{
    protected EntityManagerInterface $entityManager;

    public function create(Project $project, string $path, int $responseCode, array $responseBody = []): Endpoint
    {
        $endpoint = new Endpoint();
        $endpoint->setProject($project);
        $endpoint->setPath($path);
        $endpoint->setResponseCode($responseCode);
        $endpoint->setResponseBody($responseBody);
        $this->entityManager->persist($endpoint);
        $this->entityManager->flush();
    }

    public function remove(Endpoint $endpoint): void
    {
        if (Endpoint::STATE_REMOVED === $endpoint->getState()) {
            return;
        }

        $endpoint->setState(Endpoint::STATE_REMOVED);
        $this->entityManager->persist($endpoint);
        $this->entityManager->flush();
    }

    #[Required]
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
}
