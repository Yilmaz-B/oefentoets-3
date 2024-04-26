<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ProductLine;
use App\Form\OrderType;
use App\Form\ProductLineType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Date;
use function Symfony\Component\Clock\now;

class ProductController extends AbstractController
{
    #[Route('/category', name: 'categories')]
    public function viewCategories(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Category::class)->findAll();

        return $this->render('product/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/{id}', name: 'category_products')]
    public function viewProducts(EntityManagerInterface $entityManager, int $id): Response
    {
        $products = $entityManager->getRepository(Product::class)->findBy(array('category' => $id));

        return $this->render('product/products.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/products/{id}', name: 'product_details')]
    public function viewProductDetails(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);
        $order = new Order();

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setUser($this->getUser());
            $order->setOrderDate(new \DateTime());

            $entityManager->persist($order);
            $entityManager->flush();
            $this->addFlash('success', 'Product toegevoegd aan winkelmand');

            return $this->redirectToRoute('categories');
        }

        return $this->render('product/productDetails.html.twig', [
            'form' => $form,
            'product' => $product
        ]);
    }
}
