<?php

namespace App\Presentation\Controller;

use App\Domain\EndpointManagement\EndpointManagerInterface;
use App\Domain\ProjectManagement\ProjectRepository;
use App\Presentation\Request\CreateEndpointRequest;
use App\Supply\Traits\LoggerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[Route('/api/endpoint')]
class EndpointController extends AbstractController
{
    use LoggerTrait;

    #[Route('/{projectName}/new', methods: ['POST'])]
    public function create(CreateEndpointRequest $request,
                          ProjectRepository $projectRepository,
                          string $projectName,
                          EndpointManagerInterface $endpointManager): JsonResponse
    {
        $project = $projectRepository->findOneBy(['name' => $projectName]);
        if (null === $project) {
            throw new NotFoundHttpException('Project not found');
        }
        try {
            $endpoint = $endpointManager->create($project,
                $request->getPath(),
                $request->getResponseCode(),
                $request->getResponseBody()
            );

            return new JsonResponse(['url' => $this->generateUrl('using', [
                    'path' => $endpoint->getPath(),
                    'project' => $endpoint->getProject()->getName(),
                ]),
            ]);
        } catch (Throwable $exception) {
            $this->logger->error('Create endpoint error', [
                'exception' => $exception,
                'project' => $project->getName(),
            ]);
        }

        return new JsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
