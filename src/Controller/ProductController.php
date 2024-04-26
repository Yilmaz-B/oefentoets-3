<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/member/product', name: 'member_products')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('member/products.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
