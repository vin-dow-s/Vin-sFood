<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_accueil")
     */
    public function listeRecettes(RecetteRepository $repo): Response
    {
        $recettes = $repo->findAll();
        return $this->render('main/accueil.html.twig', [
            "recettes" => $recettes
        ]);
    }

}
