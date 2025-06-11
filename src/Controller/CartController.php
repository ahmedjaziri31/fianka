<?php

namespace App\Controller;

use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart_show')]
    public function show(CartRepository $cartRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Please log in.');
        }

        $cart = $cartRepository->findOneBy(['user' => $user]);

        return $this->render('cart/show.html.twig', [
            'cart' => $cart,
        ]);
    }
}