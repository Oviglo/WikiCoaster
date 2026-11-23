<?php

namespace App\Controller;

use App\Entity\Coaster;
use App\Form\CoasterType;
use App\Repository\CategoryRepository;
use App\Repository\CoasterRepository;
use App\Repository\ParkRepository;
use App\Service\DescriptionGeneratorService;
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

            return $this->redirectToRoute('app_coaster_index');
        }

        return $this->render('coaster/add.html.twig', [
            'coasterForm' => $form,
        ]);
    }

    #[Route('coaster/')]
    // Injection de dépendance
    public function index(
        CoasterRepository $coasterRepository,
        ParkRepository $parkRepository,
        CategoryRepository $categoryRepository,
        Request $request,
    ): Response
    {
        $park = $request->query->get('park', '');
        $category = $request->query->get('category', '');

        $count = 10;
        $page = $request->query->get('p', 1);

        $coasters = $coasterRepository->findFiltered(
            $park,
            $category,
            $page,
            $count,
        );

        $pageCount = max(ceil($coasters->count() / $count), 1);
        
        return $this->render('coaster/index.html.twig', [
            'coasters' => $coasters,
            'categories' => $categoryRepository->findAll(),
            'parks' => $parkRepository->findAll(),
            'pageCount' => $pageCount,
        ]);
    }

    #[Route('coaster/{id}/edit')]
    // Param converter
    public function edit(Coaster $entity, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(CoasterType::class, $entity);
        // Récupère les valeurs (POST) envoyées depuis le formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_coaster_index');
        }

        return $this->render('coaster/edit.html.twig', [
            'coasterForm' => $form,
        ]);
    }

    #[Route('coaster/{id}/delete')]
    public function delete(Coaster $coaster, EntityManagerInterface $em, Request $request): Response
    {
        if ($this->isCsrfTokenValid(
            'delete'.$coaster->getId(),
            $request->request->get('_token')
        )) {
            $em->remove($coaster);
            $em->flush();

            return $this->redirectToRoute('app_coaster_index');
        }


        return $this->render('coaster/delete.html.twig', [
            'coaster' => $coaster,
        ]);
    }

    #[Route('/coaster/{id}/generate-description')]
    public function generateDescription(
        Coaster $coaster,
        DescriptionGeneratorService $dgs,
        EntityManagerInterface $em
    ): Response
    {
        $dgs->generateForCoaster($coaster);
        $em->flush();

        return $this->redirectToRoute('app_coaster_index');
    }
}
