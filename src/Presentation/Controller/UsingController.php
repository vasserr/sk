<?php

namespace App\Presentation\Controller;

use App\Domain\EndpointRegistry\EndpointRepository;
use App\Domain\ProjectManagement\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UsingController extends AbstractController
{
    #[Route('{projectName}/{path}', name: 'using')]
    public function index(Request $request,
                          string $projectName,
                          string $path,
                          ProjectRepository $projectRepository,
                          EndpointRepository $endpointRepository): JsonResponse
    {
        $project = $projectRepository->findOneBy(['name' => $projectName]);

        if (null === $project) {
            throw new NotFoundHttpException('Project not found');
        }

        $endpoint = $endpointRepository->findOneByProjectIdAndPath($project->getId(), $path);

        if (!$endpoint) {
            throw new NotFoundHttpException('Endpoint not found or broken.');
        }

        return new JsonResponse($endpoint->getResponseBody(), $endpoint->getResponseCode());
    }
}
