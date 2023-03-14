# Vin's Food 🍽️🍷

Ce projet regroupe mes recettes de cuisine personnelles illustrées et détaillées (inspirées d'un livre de cuisine), en incluant la possibilité de filtrer les recettes par pays d'origine.

Une recette est définie en page d'accueil par un nom, une miniature (thumbnail), un aperçu des ingrédients, et un pays d'origine.
La page "Détails" permet d'accéder à toutes les étapes de la recette, la liste complète des ingrédients, les temps (préparation, cuisson...), et à d'autres photos complémentaires.

Un système d'authentification est présent pour me permettre d'accéder à toutes les opérations du CRUD en tant qu'admin.
Un visiteur peut simplement voir les recettes sans intéragir avec (création de compte pour le moment désactivée).

_________________
##  12/03/2023 :white_check_mark:
### Ajout d'une gallerie de photos Lightbox pour chaque recette
Création d'une entité Images en BDD qui contiendra toutes les photos associées à une recette, et modification de l'entité Recette existante en ajoutant un champ "thumbnail" qui contiendra la miniature de la recette affichée sur la page d'accueil.

Sur la page "Détails" d'une recette, il est maintenant possible d'afficher plusieurs photos.
Implémentation de **Lightbox** pour gérer le diaporama.
