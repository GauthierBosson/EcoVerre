# EcoVerre

#### Prérequis :

Yarn |  NodeJs | Composer | Version PHP 7.2 ou supérieur 

## Description de l'application

Site de collecte de verre pour la ville de Toulouse

Collaborateurs | Nom | Prénom | 
------------   | ------------- | ------------- | 
1 | 	Da Costa   |  Théo
2	| Lhermitte   | Joffrey 
3	| Bosson     | Gauthier
4	| Allalah    | Clément 
5 | 	Follin    |	Emilie


## Cahier des charges 
- [x] permet aux utilisateurs de pouvoir consulter la localisation des différentes bennes à verre dans leur commune.
- [x] permet aussi aux utilisateurs d’avoir un itinéraire pour rejoindre la benne de leur choix.
- [x] possibilité pour les référents d’avoir accès à des rapports d’incidents ou à l’état des bennes de leur commune.
- [x] Geolocalisation 


## Consultation du site
- [x] La map montrera toutes les bennes à verres à proximité de l’utilisateur
- [x] L’utilisateur pourra interagir avec un bot sur la page d’accueil s’il a besoin d’aide.
- [x] L’utilisateur a la possibilité d’interagir avec les bennes en cliquant dessus

## Cas d'utilisation - Rôle: Utilisateur 
- [x] L’utilisateur peut être géolocaliser 
- [x] L’utilisateur peut voir les bennes qui sont à proximité de lui
- [x] L’utilisateur pourra interagir avec un bot s'il a besoin d'aide 
- [x] L’utilisateur a la possibilité d’interagir avec les bennes en cliquant dessus 

## Cas d'utilisation - Rôle: Référent 
- [x] Il possède tous les cas d’usage d’un utilisateur anonyme.
- [x] S'authentifier
- [x] Il possède un dashboard qui lui permet d’administrer les bennes de sa commune
- [x] Le référent a la possibilité de modifier l’état d’une benne
- [x] Le référent aura la possibilité de voir des statistiques par rapport aux différentes benne de sa commune
- [x] En cas de problème, le référent a la possibilité de contacter un administrateur via la messagerie interne de l’application

## Cas d'utilisation - Rôle:  Administrateur
- [x] Il possède tous les cas d’usage d’un utilisateur anonyme.
- [x] Il possède tous les cas d’usage d’un référent.
- [x] S'authentifier
- [x] Il possède un dashboard qui lui permet d’administrer l’application
- [x] Il reçoit les messages lié au formulaire de contact disponible sur l’application.
- [x] Il a la possibilité de gérer les référents (créer des comptes référents / les modifier / les supprimer).
- [x] Un administrateur peut contacter un référent via la messagerie intern.

 
 # Installation du projet 
 
 


### 1ère étape : 

```bash
git clone https://github.com/GauthierBosson/EcoVerre.git
```

### 2ème étape : 

Si vous n'avez pas composer sur votre pc : https://getcomposer.org/

Sinon tapez directement cette commande dans votre console 

```bash
composer install 
```

Puis, après avoir installer yarn à l'aide du tutorial : https://yarnpkg.com/en/docs/getting-started

```bash
yarn encore dev
```

### 3ème étape : 


```bash
php bin/console server:run
```

### 4ème étape : 

L'application est lancée, vous n'avez plus qu'à naviguer 






