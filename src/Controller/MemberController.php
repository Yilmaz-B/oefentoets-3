<?php

namespace App\Controller;

use App\Entity\Story;
use App\Form\StoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MemberController extends AbstractController
{
    #[Route('/member', name: 'app_member')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $stories = $entityManager->getRepository(Story::class)->findBy(['user' => $this->getUser()]);

        return $this->render('member/index.html.twig', [
            'stories' => $stories,
        ]);
    }

    #[Route('/member/insert', 'member_insert')]
    public function insertStory(Request $request, EntityManagerInterface $entityManager)
    {
        $message = 'Add story';

        $story = new Story();

        $form = $this->createForm(StoryType::class, $story);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $story->setUser($this->getUser());

            $entityManager->persist($story);
            $entityManager->flush();
            $this->addFlash('success', 'Successfully added a story');

            return $this->redirectToRoute('app_member');
        }

        return $this->render('adventure/handleStory.html.twig', [
            'form' => $form,
            'message' => $message
        ]);
    }

    #[Route('/member/update/{id}', 'member_update')]
    public function updateStory(Request $request, EntityManagerInterface $entityManager, int $id)
    {
        $message = 'Update story';

        $story = $entityManager->getRepository(Story::class)->find($id);

        $form = $this->createForm(StoryType::class, $story);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($story);
            $entityManager->flush();
            $this->addFlash('success', 'Successfully updated a story');

            return $this->redirectToRoute('app_member');
        }

        return $this->render('adventure/handleStory.html.twig', [
            'form' => $form,
            'message' => $message,
        ]);
    }
}
