<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BaseController extends AbstractController
{
    /**
     * Page d'accueil
     */
    #[Route('/')]
    public function home(): Response
    {
        // Crée un rendu html du template Twig
        return $this->render('base/home.html.twig');
    }
    
}
