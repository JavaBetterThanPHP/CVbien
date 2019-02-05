# PROJET ANNUEL - ESGI - 4A

## Informations

- Groupe : AUBLET, CANAVAGGIO, LONGUET, ROGER
- Nom du projet : CVbien
- Type de document : Cahier des charges
- Version : 1.2
- Statut du document : En cours

### 1. PRÉSENTATION GÉNÉRALE DU PROJET
#### 1.1. Pitch

Les développeurs mettent sur leur C.V leur Git, Stack, Site perso, Linkedin, etc... Il n'existe aucun standard de C.V vitrine pour les développeurs. Nous proposons de créer une application web type CMS qui permettrait de créer un espace personnel qui centraliserait toutes ces informations et serait configurable à souhait (projets, expériences, compétences, moocs, certifications, etc).
Le site permettra aux recruteurs de trouver des profils facilement et en fonction de critères précis.

#### 1.2 Brief  

##### 1.2.1. Besoin et contexte

Dans un monde professionnel ou le C.V se dématérialise de plus en plus, en tant que développeur nous n'avons pas de solution simple, rapide et efficace qui centralise et met en avant les compétences qu'on ne peut pas forcément mettre sur notre C.V.  
Nous utilisons des sites variés, par exemple :
 - Linkedin, Facebook, Instagram, ...
 - Github, Gitlab
 - Portfolio Perso
 - Profil Stackoverflow
 - Codepen, JSFiddle

 Les recruteurs, aujourd'hui, sont eux, face à un manque d'information lors de leurs processus d'embauche. En effet, le C.V décrit de moins en moins bien les profils de developpeurs, les outils étant très diversifiés dans ce secteur d'activité. De plus, la demande d'emploi dans ce secteur étant très forte, le recruteur souhaiterait pouvoir embaucher rapidement.
    
##### 1.2.2 Utilisateurs

Les utilisateurs principaux seront les développeurs voulant mettre en avant leurs compétences. Qu'ils soient en freelance, consultant, en recherche d'emploi, en recherche de challenge.

Les utilisateurs secondaires seront des recruteurs, des chasseurs de tête, des RH, ou bien des personnes intéréssées pour monter des projets ambitieux et donc à la recherche de developpeur.

Les supers utilisateurs seront les Administrateurs qui s'assureront du bon fonctionnement du site.

##### 1.2.3 Description de l’application

Nous aimerions avoir une application moderne qui permettrait de facilement mettre en place un site vitrine et qui regrouperait ce genre de sites cités, mais aussi d'autres modules comme par exemple :
 - Informations Personnelles
 - Compétences, Loisirs, Langues
 - Projets, sites réalisés/en réalisation, implication dans l'open source
 - Certifications, Diplômes, Moocs
  
Les possibilités de personnalisation seraient multiples, aucun espace ne se ressemblerait. Selon l'avancement du projet, il serait même possible pour la communauté du site de proposer des modules. Cette application serait un réel mi-chemin entre un portfolio et une carte de visite.

En tant que recruteurs, nous souhaiterions pouvoir trouver, via une application moderne, des profils de développeurs selon les critères cités ci-dessus.

Le site devrait donc permettre de :
 - Créer/Editer des comptes utilisateurs
 - Afficher/Créer/Editer un espace personnel
 - Faire une recherche d'espaces personnels selon critères

##### 1.2.4 Fonctionnalités principales

Pour tous :
- Consultation des espaces personnels des utilisateurs sans avoir besoin de se connecter
- Se connecter à l'application via un formulaire de login et de mot de passe
- Fonction de mot de passe perdu

Developpeur :
- Rendre invisible son compte
- Possibilité de créer son espace personnel en manipulant les modules existants :
    - Ajouter un module
    - Supprimer un module
    - Editer un module
    - Déplacer un module
- Modifier la photo et la bannière de son espace personnel

Recruteur :
- Possibilité de rechercher des CV via des critères précis
- Portail de paiement pour la création d'un compte pro
- Historique des recherches de profils

Admin :
- Accès au portail d'administration

##### 1.3 Risques
|               Risque identifié               | Probabilité d'occurence | Impact |                                                                         Résolution                                                                         |
|:--------------------------------------------:|:-----------------------:|:------:|:----------------------------------------------------------------------------------------------------------------------------------------------------------:|
| Développement commercial plus long que prévu |           30%           |  Moyen |                                                     Renforcer le budget des campagnes de communication                                                     |
|       Apparition d'un concurrent direct      |           10%           |  Moyen | Implémentation de nouvelles fonctionnalités spéciales : Recherche de profil intelligente, Système de classement des profils en fonction des Modules, ...   |   
|    Augmentation du coût des ressources IT    |           15%           | Faible |                  Augmentation possible d'ici 2021 au minima. Le site générera des revenus et le budget pourra être modifié en conséquence-                 |
|    Difficulté de recrutement    |           5%           | Faible |                 Demande de profils au réseau des écoles spécialisées en informatiques, recrutement d'apprentis/stagiaires                 |
|    Service PayPal fermé ou indisponible    |           10%           | Fort |                 Développement en urgence d'un paiment par sécurisé par carte bleue avec notre banque Société Générale                 |

### 2. DÉROULEMENT DU PROJET

#### 2.1 Réalisation
- Les développeurs travaillent sur le même environnement grâce à l'outil Docker
- Environnement technique : BootStrap, Symfony, Nginx, PostreSQL

#### 2.2 Intégration continue
Intégration continue des environnements de test et de production avec Travis CI et Heroku

#### 2.3 Recette
Phase de test permettant la vérification des fonctionnalités, des algorithmes, des interfaces

#### 2.4 Déploiement
Basculer de la réalisation à la production, avec des procédures de retour en arrière, des tests de validité de comportement de l’application et l’identification des risques possibles.

### 3. PRÉCONISATIONS GÉNÉRALES

#### 3.1 Charte graphique et navigation

L'application devra :
 - être responsive pour tablettes et téléphones.
 - être intuitive et simple d'utilisation.
 - être moderne en termes de design.

#### 3.2 Matériels et compétences
 - Environnement Linux/Windows/Mac récent
 - Maitrise de Symfony, d'un environnement de développement PHP, HTML/CSS, Javascript et SQL.
 
#### 3.2 Stack Technique  

 - [**GitHub**](https://github.com/JavaBetterThanPHP/CVbien)
 - Php 7.2^
 - Symfony 4.2
 - Docker :
     - PostgreSQL : 11.1
     - Nginx : 1.14
 - Bootstrap 4.1^
 - [Packery](https://packery.metafizzy.co/#cdn)
 - GitFlow
 - ZenHub
 - Code Factor
 - Travis
 - PhpStorm 2018^
 - Visual Studio Code 1.28^
