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
        $entity = new Coaster();
        $entity->setName("Blue Fire");

        $em->persist($entity); // Indique à Doctrine qu'il y a une nouvelle entité
        $em->flush(); // Met à jour la DB

        return $this->render('coaster/add.html.twig');
    }
}