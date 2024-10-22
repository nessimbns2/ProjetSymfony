<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        $age=25+5;
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController','name'=>'Ali','age'=>$age
        ]);
    }

    #[Route('/showservice/{service}', name: 'showService')]
    public function showService($service): Response
    {
        return $this->render('service/showservice.html.twig', [
            'service'   => '$service',
        ]);
    }

    #[Route('/redirect', name: 'redirect')]
    public function goToHome(): Response
    {
      return $this->redirectToRoute('home');
    }
}
