<?php

namespace App\Form;

use App\Entity\Recette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom de la recette',
            ])
            ->add('tempsPreparation', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Temps de préparation',
                'required' => true,
            ])
            ->add('tempsCuisson', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Temps de cuisson',
                'required' => false,
            ])
            ->add('tempsRepos', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Temps de repos',
                'required' => false,
            ])
            ->add('nbPersonnes', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control nice-select wide'
                ],
                'choices' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5'
                ],
                'label' => 'Nombre de personnes',
                'required' => true,
            ])
            ->add('apercuIngredients', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => 85
                ],
                'label' => 'Aperçu des ingrédients',
                'required' => true,
            ])
            ->add('veggie', CheckboxType::class, [
                'attr' => [
                    'style' => 'margin-left: 5px; margin-bottom: 25px'
                ],
                'label' => 'Recette végétarienne'
            ])
            ->add('listeIngredients', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Liste des ingrédients',
                'required' => true,
            ])
            ->add('etapes', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Etapes de la recette'
            ])
            ->add('dateAjout', DateType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
                'label' => 'Date d\'ajout de la recette'
            ])
            ->add('categorie', ChoiceType::class, [
                'placeholder' => 'Choisir un pays',
                'choices' => [
                    'Allemagne' => 'Allemagne',
                    'Espagne' => 'Espagne',
                    'Etats-Unis' => 'Etats-Unis',
                    'France' => 'France',
                    'Grèce' => 'Grèce',
                    'Inde' => 'Inde',
                    'Indonésie' => 'Indonésie',
                    'Israël' => 'Israël',
                    'Italie' => 'Italie',
                    'Liban' => 'Liban',
                    'Portugal' => 'Portugal',
                    'Republique Tchèque' => 'RepubliqueTcheque',
                    'Royaume-Uni' => 'Royaume-Uni',
                    'Suisse' => 'Suisse',
                    'Turquie' => 'Turquie',
                    'Vietnam' => 'Vietnam',
                ],
                'attr' => [
                    'class' => 'form-control nice-select wide'
                ],
                'label' => 'Pays d\'origine',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
            ])
            /* V1 : Ajout d'une seule image avec Vich
            ->add('imageFile', VichImageType::class, [
                'label' => 'Photo de la recette',
                'attr' => [
                    'id' => 'imgRecette',
                    'style' => 'text-align: center',
                    'onchange' => 'loadFile(event)',
                ],
                'mapped' => false,
                'required' => false
            ])
            */
            //V2 : Ajout de plusieurs images sans Vich
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn-box',
                    'style' => 'text-align: center',
                ],
                'label' => 'AJOUTER'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
