<?php

namespace App\Controller;

use App\Entity\Story;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $stories = $entityManager->getRepository(Story::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'stories' => $stories,
        ]);
    }

    #[Route('/admin/delete/{id}', 'admin_delete')]
    public function deleteStory(EntityManagerInterface $entityManager, int $id)
    {
        $stories = $entityManager->getRepository(Story::class)->find($id);

        $entityManager->remove($stories);
        $entityManager->flush();
        $this->addFlash('success', 'Successfully deleted a story');

        return $this->redirectToRoute('app_admin');
    }
}
