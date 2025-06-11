<?php
// src/Controller/StaticController.php
namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StaticController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request, ProductRepository $productRepository): Response
    {
        $query = $request->query->get('q', '');
        $products = $query ? $productRepository->findBySearchQuery($query) : [];
        return $this->render('static/search.html.twig', [
            'products' => $products,
            'query' => $query,
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('static/about.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('static/contact.html.twig');
    }

    #[Route('/guide', name: 'size_guide')]
    public function guide(): Response
    {
        return $this->render('static/guide.html.twig');
    }

    #[Route('/care', name: 'care_pulls')]
    public function care(): Response
    {
        return $this->render('static/care.html.twig');
    }

    #[Route('/terms', name: 'app_terms')]
    public function terms(): Response
    {
        return $this->render('static/terms.html.twig');
    }
}