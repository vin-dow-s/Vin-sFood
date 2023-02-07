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
     * CREATE : ADD A NEW RECIPE
     * @Route("/ajoutRecette", name="ajoutRecette", methods={"GET", "POST"})
     */
    public function ajoutRecette(Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$this->getUser()) {
            $this->addFlash('error', 'Accès refusé');
            return $this->redirectToRoute('main_accueil');
        }

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
            return $this->redirectToRoute('detailsRecette', [
                "id" => $recette->getId()
            ]);
        }

        return $this->render('recette/ajoutRecette.html.twig', [
            'recetteForm' => $recetteForm->createView()
        ]);
    }

    /**
     * UPDATE : EDIT A RECIPE
     * @Route("/modifierRecette/{id}", name="modifierRecette", methods={"GET", "POST"})
     */
    public function modifierRecette(Recette $recette, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$this->getUser()) {
            $this->addFlash('error', 'Accès refusé');
            return $this->redirectToRoute('main_accueil');
        }

        $recetteForm = $this->createForm(RecetteType::class, $recette);

        $recetteForm->handleRequest($request);

        $file = $recette->getImageFile();
        $fileName = $recette->getImageName();

        if($recetteForm->isSubmitted() && $recetteForm->isValid()){
            //Upload image
            $newImage = $recetteForm->get('imageFile')->getData();
            $newImageName = $recetteForm->get('imageFile')->getName();
            if ($newImage) {
                $recette->setImageFile($newImage);
                $recette->setImageName($newImageName);
            }
            else {
                $recette->setImageFile($file);
                $recette->setImageName($fileName);
            }

            $entityManager->persist($recette);
            $entityManager->flush();

            $this->addFlash('success', 'Recette modifiée avec succès !');
            return $this->redirectToRoute('detailsRecette', [
                "id" => $recette->getId()
            ]);
        }

        return $this->render('recette/modifierRecette.html.twig', [
            'recetteForm' => $recetteForm->createView()
        ]);
    }

    /**
     * DELETE : DELETE A RECIPE
     * @Route("/supprimerRecette/{id}", name="supprimerRecette", methods={"GET", "POST"})
     */
    public function supprimerRecette(Recette $recette, EntityManagerInterface $entityManager): Response
    {
        if(!$this->getUser()) {
            $this->addFlash('error', 'Accès refusé');
            return $this->redirectToRoute('main_accueil');
        }

        $entityManager->remove($recette);
        $entityManager->flush();

        $this->addFlash('success', 'Recette supprimée avec succès !');
        return $this->redirectToRoute('main_accueil');
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
}
