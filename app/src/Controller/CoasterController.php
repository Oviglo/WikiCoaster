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
    #[Route('/coaster/add')]
    public function add(EntityManagerInterface $em, Request $request): Response
    {
        // Création d'une entité
        // $entity = new Coaster();
        // $entity->setName('Blue Fire');

        // $em->persist($entity); // Ajoute l'entité dans le manager
        // $em->flush(); // Exécute les requêtes

        $entity = new Coaster;
        // CoasterType::class => 'App\Form\CoasterType'
        $form = $this->createForm(CoasterType::class, $entity);
        // Récupère les valeurs (POST) envoyées depuis le formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirectToRoute('app_base_home');
        }

        return $this->render('coaster/add.html.twig', [
            'coasterForm' => $form,
        ]);
    }

    #[Route('coaster/')]
    public function index(CoasterRepository $coasterRepository): Response
    {
        $coasters = $coasterRepository->findAll();

        return $this->render('coaster/index.html.twig', [
            'coasters' => $coasters,
        ]);
    }
}
