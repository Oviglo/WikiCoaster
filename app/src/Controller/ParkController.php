<?php

namespace App\Controller;

use App\Entity\Park;
use App\Form\ParkType;
use App\Repository\ParkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/park')]
final class ParkController extends AbstractController
{
    #[Route(name: 'app_park_index', methods: ['GET'])]
    public function index(ParkRepository $parkRepository): Response
    {
        return $this->render('park/index.html.twig', [
            'parks' => $parkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_park_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $park = new Park();
        $form = $this->createForm(ParkType::class, $park);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($park);
            $entityManager->flush();

            return $this->redirectToRoute('app_park_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('park/new.html.twig', [
            'park' => $park,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_park_show', methods: ['GET'])]
    public function show(Park $park): Response
    {
        return $this->render('park/show.html.twig', [
            'park' => $park,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_park_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Park $park, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParkType::class, $park);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_park_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('park/edit.html.twig', [
            'park' => $park,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_park_delete', methods: ['POST'])]
    public function delete(Request $request, Park $park, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$park->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($park);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_park_index', [], Response::HTTP_SEE_OTHER);
    }
}
