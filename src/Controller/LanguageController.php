<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageController extends AbstractController
{
    #[Route('/switch-language', name: 'app_switch_language', methods: ['GET'])]
    public function switchLanguage(Request $request): Response
    {
        // Get the locale from the query parameter
        $locale = $request->query->get('locale', 'fr'); // Default to 'fr' if not provided

        // Validate the locale
        if (!in_array($locale, ['fr', 'en'])) {
            $locale = 'fr'; // Fallback to default if invalid
        }

        // Store the locale in the session
        $request->getSession()->set('_locale', $locale);

        // Debug: Log the session locale
        dump('Session locale set to: ' . $request->getSession()->get('_locale'));

        // Redirect back to the referring page or homepage
        $referer = $request->headers->get('referer');
        dump('Referer: ' . $referer);

        // Simplify redirect logic: always redirect to app_homepage with the new locale
        $redirectUrl = $this->generateUrl('app_homepage', ['_locale' => $locale]);
        dump('Redirecting to: ' . $redirectUrl);

        return $this->redirect($redirectUrl);
    }
}