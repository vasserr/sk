<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/endpoint')]
class EndpointController extends AbstractController
{
    #[Route('/create/{project}', methods: ['POST'])]
    public function create(int $project): JsonResponse
    {
        return new JsonResponse(['project' => $project]);
    }
}
