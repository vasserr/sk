<?php

namespace App\Presentation\Controller;

use App\Domain\EndpointManagement\EndpointManagerInterface;
use App\Domain\ProjectManagement\ProjectRepository;
use App\Presentation\Request\CreateEndpointRequest;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\Attribute\Required;

#[Route('/api/endpoint')]
class EndpointController extends AbstractController
{
    protected LoggerInterface $logger;

    #[Route('/create/{projectId}', methods: ['POST'])]
    public function create(CreateEndpointRequest $request,
                          ProjectRepository $projectRepository,
                          int $projectId,
                          EndpointManagerInterface $endpointManager,
                          SerializerInterface $serializer): JsonResponse
    {
        $project = $projectRepository->findOneBy(['id' => $projectId]);
        if (null === $project) {
            throw new NotFoundHttpException('Project not found');
        }
        try {
            $endpoint = $endpointManager->create($project,
                $request->getPath(),
                $request->getRequestCode(),
                $request->getRequestBody());

            return new JsonResponse(['endpoint' => $serializer->serialize($endpoint, 'json')]);
        } catch (\Throwable $exception) {
            $this->logger->error('Create endpoint error', [
                'exception' => $exception,
                'projectId' => $projectId,
            ]);
        }

        return new JsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    #[Required]
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
