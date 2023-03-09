<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isEmpty;


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
            //On récupère les images
            $this->traitementImages($recetteForm, $recette, $entityManager);

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

        if($recetteForm->isSubmitted() && $recetteForm->isValid()){
            //On récupère les images
            $this->traitementImages($recetteForm, $recette, $entityManager);

            $this->addFlash('success', 'Recette modifiée avec succès !');
            return $this->redirectToRoute('detailsRecette', [
                "id" => $recette->getId()
            ]);
        }

        return $this->render('recette/modifierRecette.html.twig', [
            'recette' => $recette,
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

    /**
     * IMAGES PROCESSING : GET FROM FORM, ASSIGN NEW NAMES, MOVE TO images/recettes, SAVE NAMES IN DB
     */
    private function traitementImages(FormInterface $recetteForm, Recette $recette, EntityManagerInterface $entityManager): void
    {
        $images = $recetteForm->get('images')->getData();

        //On boucle sur les images
        foreach ($images as $image) {
            //On génère un nouveau nom de fichier
            $fichier = md5(uniqid()) . '.' . $image->guessExtension();

            //On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('pictures_directory'),
                $fichier
            );

            //On stocke le nom de l'image dans la BDD
            $img = new Images();
            $img->setName($fichier);
            $recette->addImage($img);
        }

        //On affecte la première image en tant qu'image mise en avant dans l'accueil
        $recette->setThumbnail($recette->getPremiereImage()->getName());

        $entityManager->persist($recette);
        $entityManager->flush();
    }

    /**
     * DELETE ONE IMAGE
     * @Route("/supprimerImage/{id}", name="supprimerImage", methods={"DELETE"})
     */
    public function supprimerImage(Images $image, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        //On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            //On récupère le nom de l'image
            $nom = $image->getName();
            //On supprime le fichier
            unlink($this->getParameter('pictures_directory').'/'.$nom);

            $entityManager->remove($image);
            $entityManager->flush();

            //On répond en JSON
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
    }
}
