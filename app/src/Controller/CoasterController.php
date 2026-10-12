<?php

namespace App\Controller;

use App\Entity\Coaster;
use App\Form\CoasterType;
use App\Repository\CoasterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoasterController extends AbstractController
{
    #[Route('/coaster')]
    // Injection de dépendance
    public function index(CoasterRepository $coasterRepository): Response
    {
        $coasters = $coasterRepository->findAll();

        return $this->render('coaster/index.html.twig', [
            'coasters' => $coasters,
        ]);
    }

    #[Route('/coaster/add')]
    public function add(EntityManagerInterface $em, Request $request): Response
    {
        $entity = new Coaster();
        // $entity->setName("Blue Fire");
        // CoasterType::class => 'App\Form\CoasterType'
        $form = $this->createForm(CoasterType::class, $entity);
        // Traitement des données $_POST 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity); // Indique à Doctrine qu'il y a une nouvelle entité
            $em->flush(); // Met à jour la DB

            // redirection
            return $this->redirectToRoute('app_coaster_index');
        }


        return $this->render('coaster/add.html.twig', [
            'coasterForm' => $form,
        ]);
    }

    #[Route('coaster/{id}/edit')]
    // Param converter, permet de convertir un paramètre en entité
    public function edit(Coaster $entity, Request $request, EntityManagerInterface $em): Response
    {
        // On ne crée pas d'entité car elle est envoyée dans les paramètres

        $form = $this->createForm(CoasterType::class, $entity);
        // Traitement des données $_POST 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Pas besoin de "persist" car Doctrine connait déjà l'entité
            $em->flush(); // Met à jour la DB

            // redirection
            return $this->redirectToRoute('app_coaster_index');
        }

        return $this->render('coaster/edit.html.twig', [
            'coasterForm' => $form,
        ]);
    }

    #[Route('/coaster/{id}/delete')]
    public function delete(Coaster $coaster, EntityManagerInterface $em, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coaster->getId(), $request->request->get('_token'))) {
            $em->remove($coaster);
            $em->flush();

            return $this->redirectToRoute('app_coaster_index');
        }

        return $this->render('/coaster/delete.html.twig', [
            'coaster' => $coaster,
        ]);
    }
}