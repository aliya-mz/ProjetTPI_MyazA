
# Journal de bord

## Table des matières
[TOC]

**Note** : la section "*à faire*" est définie à la fin de la journée de travail précédente

## Lundi 04.05.2021

*A faire :*

- Planning
- Backlog
- Maquettes
- Diagramme de classes

**Matin**

7h30 : Je lis l'énoncé, réalise le planning prévisionnel, qui prend un peu plus de temps que prévu, et pose des questions à l'enseignant qui me suit.

Nous convenons que je peux, au lieu de donner la météo sur la semaine à venir, la donner sur les 5 jours à venir, puisque telles sont le contraintes de l'API gratuite (openweathermap).

Je réalise ensuite le product backlog, en me référant à l'énoncé. Je le finis plus tôt que prévu.

**Après-midi**

12h40 : Je réalise les maquettes principales du site (page principale, calendrier, semainier, formulaire d'ajout de vêtements, page de visualisation des vêtements).

Ensuite, je finis de modéliser la base de données, puisque mon énoncé ne contient pas d'instructions particulières pour la gestion du calendrier. J'ai réalise également un diagramme de classes PHP pour la gestion des informations météo.

15h30 : Je commence à écrire mes tests, en me basant sur le product backlog et sur les maquettes.

➔ **Bilan de la journée** :



## Mardi 04.05.2021

*A faire :*

- Finir les scénarios de tests
- Créer la BD
- Créer les CRUD

- Implémenter la recherche d'événements par date dans le CRUD
- Créer les formulaires de login et signin
- Gérer l'accès aux pages en fonction des rôles

**Matin**

7h30 : Je fais les tests concernant la météo, le calendrier, le semainier et la gestion de la garde-robe. 

9h20 : Je crée la base de données en fonction du modèle de l'énoncé complété la veille. Ensuite, je fais le CRUD des utilisateurs et celui des vêtements.

**Après-midi**

12h40 : Je fais le CRUD des évènements pour le calendrier. Je passe un peu de temps à faire des recherches pour manipuler les dates, puisque je dois les faire passer du PHP au SQL dans la création et la recherche d'évènements. Finalement, je les enregistre en timestamp dans la BD, donc je dois les convertir en timestamp avant de les envoyer à la requête. 

Voilà comment j'ai fait :

```php
$hour = date('h', strtotime($date));
$minute = date('i', strtotime($date));
$month = date('m', strtotime($date));
$day = date('d', strtotime($date));
$year = date('Y', strtotime($date));

//Transformer les dates en timestamp mySQL
$timestamp = date ('Ymd H: i: s', mktime ($hour, $minute, 0, $month, $day, $year));
```

14h40 : Je réalise les formulaires de connexion et d'inscription, en gérant l'enregistrement des informations du compte, dont le hash du mot de passe, et le système de vérification des informations lors de la connexion.

je m'occupe ensuite du système de gestion les autorisations, avec trois rôles : "déconnecté", "utilisateur" et "administrateur".

➔ **Bilan de la journée** : Je commence à être un peu plus éparpillée dans mes tâches que ce qui était prévu sur le planning.



## Mercredi 05.05.2021

*A faire :*

- Avancer la documentation

- Créer la page qui permet de supprimer les utilisateurs dans une liste
- Créer la fonction qui génère les jours à afficher pour le calendrier (arrangement pour que la semaine ne soit pas coupée dans l'affichage du mois)
- Récupérer les évènements à afficher dans le calendrier et le semainier
- Affichage du calendrier (s'il reste du temps)

**Matin**

7h30 : Je commence la journée en testant ce que j'avais fait la veille, c'est à dire le système de gestion des utilisateurs. J'ai dois résoudre quelques problèmes de fonctionnement, puisque les tests ne passent pas

8h30 : Erreurs corrigées, les tests passent. J'ai avancé sur la documentation, notamment en remplissant mon tableau d'avancée des tests.

9h30 : Je réalise la page de gestion des utilisateurs, réservée aux administrateurs. J'effectue les tests, que je valide.

10h30 : J'ai oublié d'implémenter la fonctionnalité de modification du compte, que je n'avais pas mis dans le planning, je rattrape donc rapidement cette partie. J'effectue les tests, qui sont validés.

11h00 : Pareil pour les messages d'erreur lors de le connexion, je les ajoute et les teste. La partie "gestion des utilisateurs" est terminée.

**Après-midi**

12h40 : Je commence le calendrier. Puisque je n'ai jamais réalisé de calendrier, je décide de réaliser le réaliser entièrement par moi-même, au lieu de faire appel à un service extérieur, qui pourrait me demander plus de temps que ce que j'avais prévu. Pour cela, je dois d'abord créer un système qui, pour un mois et une année donnée, délimite les jours à afficher pour qu'une semaine ne soit pas coupée. J'apprécie à nouveau ce merveilleux moment de travail avec les dates.

14h35 : Je fais l'affichage du calendrier, et ça marche pas, parce que ma CSS fait n'importe quoi avec Bootstrap.

16h00 : C'est à peu près réglé, le calendrier s'affiche, mais j'ai fait juste le nécessaire pour la suite. Je reviendrai sur les détails plus tard. Maintenant j'essaie de récupérer les évènements à afficher dans la page du calendrier.

➔ **Bilan de la journée** :



## Jeudi 06.05.2021

*A faire :*

- Finir la récupération des évènements du calendrier et du semainier - ok
- Finir l'affichage du calendrier et des évènements - ok
- Affichage du semainier - en cours
- Création et suppression d'évènements - en cours
- Implémentation du système de récupération et stockage d'informations météo

**Matin**

Je poursuis mes péripéties avec les dates, pour la gestion du calendrier.

7h30 :  Je reviens sur l'avant-dernier point que j'ai abandonnée hier, et fais en sorte que les dates s'affichent joliment sur le calendrier.

8h30 : Je reviens sur le dernier point que j'ai abandonné hier, c'est à dire la récupération d'évènements dans un intervalle de dates.

9h00 : J'ai enfin réglé mon problème de requêtes avec un intervalle de dates, je commence donc l'affichage des évènements que j'ai réussi à récupérer. Je dois créer un tableau associatif dynamiquement, pour récupérer les évènement facilement pour un jour donné. Ensuite, je fais un peu de php/html/css pour afficher "joliment" les évènements dans le calendrier.

10h30 : J'implémente la création et suppression d'évènements

**Après-midi**

12h40 : Je continue la création d'évènements

13h30 :  J'implémente le semainier

15h00 : Je fais en sorte qu'on puisse se déplacer de mois en mois sur le calendrier, grâce à des paramètres envoyés en *get* (année et mois).

16h00 : Finalement, je n'ai pas le temps de commencer la partie météo. Je fais les dernières corrections pour terminer la gestion du calendrier/semainier, et pouvoir commencer la météo lundi prochain

 ➔ **Bilan de la journée** : Ca fonctionne mieux quand on travaille le matin.



## Lundi 10.05.2021

*A faire :*

- Implémentation du système de récupération et stockage d'informations météo

- Affichage météo
- Tests météo
- Fonctionnalités création, modification et suppression de vêtement
- Discuter avec mon enseignant des catégories de vêtements
- Rechercher images vectorielles pour chaque catégorie de vêtement

**Matin**



**Après-midi**



➔ **Bilan de la journée** :



 

## Mardi 11.05.2021

*A faire :*

- Génération dynamique de l'image du vêtement (vectoriel)

- Algorithme de recommandation de tenues
- Documentation

**Matin**



**Après-midi**



➔ **Bilan de la journée** :



 

## Mercredi 12.05.2021

*A faire :*



**Matin**



**Après-midi**



➔ **Bilan de la journée** :



 

## Lundi 17.05.2021

*A faire :*



**Matin**



**Après-midi**





 

## Mardi 18.05.2021

*A faire :*



**Matin**



**Après-midi**



➔ **Bilan de la journée** :



 

## Mercredi 19.05.2021

*A faire :*



**Matin**



**Après-midi**



➔ **Bilan de la journée** :





## Jeudi 20.05.2021

*A faire :*



**Matin**



**Après-midi**



➔ **Bilan de la journée** :





