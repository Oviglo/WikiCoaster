<?php

namespace App\Controller;

use App\Entity\Coaster;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoasterController extends AbstractController
{
    #[Route('/coaster/add')]
    public function add(EntityManagerInterface $em): Response
    {
        // Création d'une entité
        $entity = new Coaster();
        $entity->setName('Blue Fire');

        $em->persist($entity); // Ajoute l'entité dans le manager
        $em->flush(); // Exécute les requêtes

        return $this->render('coaster/add.html.twig');
    }
}
