<?php

namespace App\Presentation\Controller;

use App\Domain\ProjectManagement\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/endpoint')]
class EndpointController extends AbstractController
{
    #[Route('/create/{projectId}', methods: ['POST'])]
    public function create(Request $request, ProjectRepository $projectRepository, int $projectId): JsonResponse
    {
        $project = $projectRepository->findOneBy(['id' => $projectId]);
        if (null === $project) {
            throw new NotFoundHttpException('Project not found');
        }

        return new JsonResponse(['project' => $project->getUserId()]);
    }
}
