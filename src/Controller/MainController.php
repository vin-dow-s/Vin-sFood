<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * READ : SHOW ALL RECIPES, ORDERED BY DATE 'DESC' (LATEST FIRST)
     * @Route("/", name="main_accueil")
     */
    public function listeRecettes(RecetteRepository $repo): Response
    {
        $recettes = $repo->findBy([], ['dateAjout' => 'DESC']);
        return $this->render('main/accueil.html.twig', [
            "recettes" => $recettes
        ]);
    }

}
