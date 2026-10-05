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
    public function index(CoasterRepository $coasterRepository): Response
    {
        // $entityManager->getRepository(Coaster::class)->findAll()
        $coasters = $coasterRepository->findAll();

        return $this->render('coaster/index.html.twig', [
            'coasters' => $coasters,
        ]);
    }

    #[Route('/coaster/add')]
    public function add(EntityManagerInterface $em, Request $request): Response
    {
        // Création d'une entité
        $entity = new Coaster();
        // $entity->setName('Blue Fire');
        // CoasterType::class => 'App\Form\CoasterType'
        $form = $this->createForm(CoasterType::class, $entity);
        // Gestion des données envoyées par le formulaire (POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity); // Ajoute l'entité dans le manager
            $em->flush(); // Exécute les requêtes

            // Redirection
            return $this->redirectToRoute('app_base_home');
        }

        return $this->render('coaster/add.html.twig', [
            'coasterForm' => $form, // $form->createView()
        ]);
    }

    #[Route('/coaster/{id}/edit')]
    public function edit(Coaster $entity): Response
    {
        return $this->render('coaster/edit.html.twig');
    }

    public function delete(): Response
    {
        return $this->render('coaster/delete.html.twig');
    }
}
