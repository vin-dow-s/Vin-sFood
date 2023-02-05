<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RecetteController extends AbstractController
{
    /**
     * ADD A NEW RECIPE
     * @Route("/ajoutRecette", name="ajoutRecette", methods={"GET", "POST"})
     */
    public function ajoutRecette(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recette = new Recette();

        $recetteForm = $this->createForm(RecetteType::class, $recette);

        $recetteForm->handleRequest($request);

        if($recetteForm->isSubmitted() && $recetteForm->isValid()){
            //Upload image
            $file = $recetteForm->get('imageFile')->getData();
            $fileName = $recetteForm->get('imageFile')->getName();
            $recette->setImageFile($file);
            $recette->setImageName($fileName);

            $entityManager->persist($recette);
            $entityManager->flush();

            $this->addFlash('success', 'Recette ajoutée avec succès !');
            return $this->redirectToRoute('main_accueil');
        }

        return $this->render('recette/ajoutRecette.html.twig', [
            'recetteForm' => $recetteForm->createView()
        ]);
    }

    /**
     * DETAILS OF A RECIPE
     * @Route("/detailsRecette/{id}", name="detailsRecette")
     */
    public function detailsRecette(int $id, RecetteRepository $recetteRepository): Response
    {
        $recette = $recetteRepository->find($id);

        if (!$recette)
            throw $this->createNotFoundException('Pas de recette avec cet identifiant');

        return $this->render('recette/detailsRecette.html.twig', [
            "recette" => $recette
        ]);
    }

    /**
     * EDIT A RECIPE
     * @Route("/modifierRecette/{id}", name="modifierRecette", methods={"GET", "POST"})
     */
    public function modifierRecette(Recette $recette, Request $request, EntityManagerInterface $entityManager): Response
    {
        $recetteForm = $this->createForm(RecetteType::class, $recette);

        $recetteForm->handleRequest($request);

        if($recetteForm->isSubmitted()){
            //Upload image
            $file = $recetteForm->get('imageFile')->getData();
            $fileName = $recetteForm->get('imageFile')->getName();
            $recette->setImageFile($file);
            $recette->setImageName($fileName);

            $entityManager->persist($recette);
            $entityManager->flush();

            $this->addFlash('success', 'Recette modifiée avec succès !');
            return $this->redirectToRoute('main_accueil');
        }

        return $this->render('recette/modifierRecette.html.twig', [
            'recetteForm' => $recetteForm->createView()
        ]);
    }
}
