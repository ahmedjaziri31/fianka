<?php
// src/Controller/NewsletterController.php
namespace App\Controller;

use App\Entity\Newsletter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter/subscribe', name: 'app_newsletter_subscribe', methods: ['POST'])]
    public function subscribe(Request $request, EntityManagerInterface $entityManager): Response
    {
        $email = $request->request->get('email');

        if (!$email) {
            $this->addFlash('error', 'Veuillez entrer une adresse email valide.');
            return $this->redirectToRoute('app_homepage');
        }

        $newsletter = new Newsletter();
        $newsletter->setEmail($email);
        $newsletter->setSubscribedAt(new \DateTime());

        $entityManager->persist($newsletter);
        $entityManager->flush();

        $this->addFlash('success', 'Merci de vous être abonné(e) !');
        return $this->redirectToRoute('app_homepage');
    }
}