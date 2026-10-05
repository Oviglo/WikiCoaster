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
}