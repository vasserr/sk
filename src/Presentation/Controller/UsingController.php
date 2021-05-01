<?php

namespace App\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsingController extends AbstractController
{
    #[Route('{project}/{path}', name: 'using')]
    public function index(): JsonResponse
    {
        //TODO implement logic
        return  new JsonResponse();
    }
}
