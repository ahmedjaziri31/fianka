<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IconController extends AbstractController
{
    #[Route('/icon', name: 'app_icon')]
    public function index(): Response
    {
        return $this->render('icon/index.html.twig', [
            'controller_name' => 'IconController',
        ]);
    }
}
