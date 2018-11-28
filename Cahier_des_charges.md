# Projet Annuel

## Informations

- Groupe : AUBLET, CANAVAGGIO, LONGUET, ROGER
- Nom du projet : CVbien
- Type de document : Cahier des charges
- Version : 1.0
- Statut du document : En cours

### 1. PRÉSENTATION GÉNÉRALE DU PROJET
#### 1.1.Pitch

Les développeurs mettent sur leur C.V leur Git, Stack, Site perso, Linkedin, etc... Il n'existe aucun standard de C.V vitrine pour les développeurs.
Nous proposons de créer une application web qui permettrait de créer un espace personnel qui centraliserait toutes ces informations et serait configurable à souhait (projets, expériences, compétences, moocs, certifications, etc).
Le site pourrait également servir aux recruteurs qui pourraient trouver des profils en fonction de critères précis.

#### 1.2 Brief  
1.2.1.Besoin et contexte

Dans un monde professionnel ou le C.V se dématérialise de plus en plus, en tant que développeurs nous n'avons pas de solution simple, rapide et efficace qui centralise et met en avant les compétences qu'on ne peut pas forcément mettre sur notre C.V.  
Nous utilisons des sites variés :
 - Linkedin
 - Github
 - Portfolio Perso
 - Profil Stackoverflow  

Nous aimerions avoir une application moderne qui permettrait de facilement mettre en place un site vitrine et qui regrouperait les sites cités ci-dessus, mais aussi d'autres modules comme par exemple :
 - Informations Personnelles
 - Compétences
 - Projets
 - Certifications  
  
Les possibilités de personnalisation seraient multiples, aucun espace ne se ressemblerait. Ce site serait un réel mi-chemin entre un portfolio et une carte de visite.

En tant que recruteurs, nous souhaiterions pouvoir trouver, via une application moderne, des profils de développeurs selon les critères cités ci-dessus.

Le site devrait permettre de :
 - Créer/Editer des comptes utilisateurs
 - Afficher/Créer/Editer un espace personnel
 - Faire une recherche d'espaces personnels selon critères
    
1.2.2 Utilisateurs

Les utilisateurs principaux seront les développeurs voulant mettre en avant leur compétences.  
Les utilisateurs secondaires seront les RH ou les recruteurs en recherche de profils devs, freelanceurs, consultants, ...  
Les supers utilisateurs seront les Administrateurs qui s'assureront du bon fonctionnement du site.

1.2.3 Description de l’application

Trois types d'utilisateurs :
 - Développeur
 - Ressource Humaine
 - Administrateur

L'utilisateur développeur pourra se créer un compte sur le site via un couple email/password.
Connecté sur son espace il pourra :
 - Activer/Désactiver son espace
 - Modifier son espace :
 - Ajouter/Modifier/Supprimer des modules
 - Déplacer des modules
 - Modifier son image de profil
 - Modifier son image de bannière

L'utilisateur ressource humaine se verra attribuer un compte via abonnement mensuel.
Connecté sur son espace il pourra :
 - Utiliser l'outil de recherche de profils
 - Accéder à l'espace personnel d'un développeur

L'utilisateur administrateur s'assurera du bon fonctionnement du site via un espace dédié.
Cet espace ne sera pas détaillé dans ce document compte tenu de sa nature technique.

1.2.4 Fonctionnalités principales

- Se connecter a l'application via un formulaire de login et de mot de passe
- Portail d'administration
- Fonction de mot de passe perdu
- Possibilité de créer son CV en ligne via différent modèle prédéfinis ou custom
- Consultation des CV des utilisateurs sans besoin avoir besoin de se connecter
- Possibilité de rechercher des CV via différent filtre
- Portail de paiement pour la recherche dans la base de données
- Possibilité d'ajouter tous ses projets majeurs en ligne

### 2. DÉROULEMENT DU PROJET
2.1.1 Réalisation

•        Tous les développeurs développent sur le même environnement grâce à l'outil Docker
•        Environnement technique : BootStrap, Symfony, Nginx, PostreSQL

2.1.2 Recette

Phase de test permettant la vérification des fonctionnalités, des algorithmes, des l’interfaces

2.1.3 Déploiement

Basculer de la réalisation à la production, avec des procédures de retour en arrière, des tests de validité de comportement de l’application et l’identification des risques possibles.

### 3. PRÉCONISATIONS GÉNÉRALES

3.1 Charte graphique et navigation

L'application devra :
 - être responsive pour tablettes et téléphones.
 - être intuitive et simple d'utilisation.
 - être moderne en termes de design.

3.2 Matériels et compétences
 - Environnement Linux/Windows/Mac récent
 - Maitrise de Symfony, Environnement de développement PHP, HTML/CSS et langage SQL.
