<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/{_locale}', name: 'app_homepage', defaults: ['_locale' => 'fr'], requirements: ['_locale' => 'en|fr'])]
    #[Route('/', name: 'app_root', defaults: ['_locale' => 'fr'])]
    public function index(Request $request, string $_locale): Response
    {
        // Get the locale from the session, fallback to URL parameter
        $sessionLocale = $request->getSession()->get('_locale', $_locale);
        $request->setLocale($sessionLocale);

        return $this->render('base.html.twig');
    }
}