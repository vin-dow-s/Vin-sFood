# Vin's Food 🍽️🍷

Ce projet regroupe mes recettes de cuisine personnelles illustrées et détaillées (inspirées d'un livre de cuisine), en incluant la possibilité de filtrer les recettes par pays d'origine.

Une recette est définie en page d'accueil par un nom, une miniature (thumbnail), un aperçu des ingrédients, et un pays d'origine.   
La page "Détails" permet d'accéder à toutes les étapes de la recette, la liste complète des ingrédients, les temps (préparation, cuisson...), et à d'autres photos complémentaires.

Un système d'authentification est présent pour me permettre d'accéder à toutes les opérations du CRUD en tant qu'admin.   
Un visiteur peut simplement voir les recettes sans intéragir avec (création de compte pour le moment désactivée).

_________________
##  15/03/2023 :white_check_mark:
### Ajout d'un filtre "Végétarien"
Création d'un champ ``veggie`` dans l'entité *Recette* : booléen qui indique si une recette est végétarienne ou non.

Ajout du champ dans le formulaire d'ajout/modification d'une recette.

Un logo "veggie" s'affiche maintenant sur la card de chaque recette végétarienne et un filtre `data-filter` permet d'afficher uniquement ces recettes là (on leur ajoute la classe `.veggie` dynamiquement, ce qui permet de les identifier).

_________________
##  12/03/2023 :white_check_mark:
### Ajout d'une gallerie de photos Lightbox pour chaque recette
Création d'une entité *Images* en BDD qui contiendra toutes les photos associées à une recette, et modification de l'entité *Recette* existante en ajoutant un champ `thumbnail` qui contiendra la miniature de la recette affichée sur la page d'accueil, ainsi qu'un champ `images` lié à l'entité correspondante et contenant toutes les photos d'une recette.

La première image sélectionnée lors de l'upload sera automatiquement considérée comme la miniature (affichée en page d'accueil **uniquement**).

Sur la page "Détails" d'une recette, il est maintenant possible d'afficher plusieurs photos grâce à une boucle qui récupère toutes les images associées à une recette SAUF la miniature.
Implémentation de **Lightbox** pour gérer le diaporama.

Modifications du CSS pour gérer le responsive de la page "Détails".

________________
##  09/03/2023 :white_check_mark:
### Upload de plusieurs images possible et suppression individuelle en AJAX
Modification du formulaire d'ajout/modification de recette en utilisant un champ `FileType` pour pouvoir uploader plusieurs images à la fois (Vich précédemment).

Modification du HTML/CSS des Vues pour pouvoir afficher par la suite plusieurs images.

Suppression des dimensions `max-width/height` en CSS associées aux miniatures en page d'accueil -> redimensionner avant l'upload pour améliorer les performances.

_______________
##  21/02/2023 :white_check_mark:
### Modifications suite W3C Validator   
• Compression et redimensionnement des images   
• Ajout des balises `alt`   
• Amélioration du comportement des liens/boutons   
• Corrections CSS concernant les `padding`   

_______________
##  08/02/2023 :white_check_mark:
### Base fonctionnelle du projet
• CRUD opérationnel   
• Upload d'image simple avec Vich   
• Filtres par pays et drapeaux correspondants   
• Authentification et sécurité (compte admin crée puis création de compte désactivée)   
• Ajout conversions automatiques des temps/durées en TWIG   
• Modification du CSS pour le responsive   
