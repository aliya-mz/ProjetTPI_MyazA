
# Journal de bord

## Table des matières
[TOC]

## Lundi 04.05.2021

*A faire :*

- Planning
- Backlog
- Maquettes
- Diagramme de classes

**Matin**

*Fait :*

J'ai lu l'énoncé, réalisé le planning prévisionnel, qui a pris un peu plus de temps que prévu, et posé des questions à l'enseignant qui me suit.

Nous avons convenu que je pouvais, au lieu de donner la météo sur la semaine à venir, la donner sur les 5 jours à venir, puisque telles étaient le contraintes de l'API gratuite (openweathermap).

J'ai ensuite réalisé le backlog, en me référant à l'énoncé. Je l'ai donc fini plus tôt que prévu.

**Après-midi**

*Fait :*

J'ai réalisé les maquettes principales du site (page principale, calendrier, semainier, formulaire d'ajout de vêtements, page de visualisation des vêtements).

Ensuite, j'ai fini de modéliser la base de données, puisque mon énoncé ne contenait pas d'instructions particulières pour la gestion du calendrier. J'ai également réaliser un diagramme de classes php pour la gestion des informations météo.

Durant la dernière heure, j'ai commencé à écrire mes tests, en me basant sur le product backlog et sur les maquettes.



## Mardi 04.05.2021

*A faire :*

- Finir les scénarios de tests
- Créer la BD
- Créer les CRUD

- Implémenter la recherche d'événements par date dans le CRUD
- Créer les formulaires de login et signin
- Gérer l'accès aux pages en fonction des rôles

**Matin**

7h30 : J'ai fait les tests concernant la météo, le calendrier, le semainier et la gestion de la garde-robe. 

9h20 : J'ai créé la base de données en fonction du modèle de l'énoncé complété la veille. Ensuite, j'ai fait le CRUD des utilisateurs et celui des vêtements.

**Après-midi**

12h40 : J'ai fait le CRUD des évènements pour le calendrier. J'ai passé un peu de temps à faire des recherches pour manipuler les dates, puisque je dois les faire passer du PHP au SQL dans la création et la recherche d'évènements. Finalement, je les ai mises en timestamp dans la BD, donc je dois les convertir en timestamp avant de les envoyer à la requête. 

Voilà comment j'ai fait :

```php
$hour = date('h', strtotime($dateStart));
$minute = date('i', strtotime($dateStart));
$mMonth = date('m', strtotime($dateStart));
$day = date('d', strtotime($dateStart));
$year = date('Y', strtotime($dateStart));

//Transformer les dates en timestamp mySQL
$timestamp = date ('Ymd H: i: s', mktime ($startHour, $startMinute, 0, $startMonth, $startDay, $startYear));
```



14h40 : J'ai réalisé les formulaires de connexion et d'inscription, en gérant l'enregistrement des informations du compte, dont le hash du mot de passe, et le système de vérification des informations lors de la connexion.

j'ai également géré les autorisations, avec trois rôles : "déconnecté", "utilisateur" et "administrateur".



## Mercredi 05.05.2021

*A faire :*

- Créer la page qui permet de supprimer les utilisateurs dans une liste
- Créer la fonction qui génère les jours à afficher pour le calendrier (arrangement pour que la semaine ne soit pas coupée dans l'affichage du mois)
- 

**Matin**



**Après-midi**





## Jeudi 06.05.2021

*A faire :*



**Matin**



**Après-midi**



 

## Lundi 10.05.2021

*A faire :*



**Matin**



**Après-midi**



 

## Mardi 11.05.2021

*A faire :*



**Matin**



**Après-midi**





 

## Mercredi 12.05.2021

*A faire :*



**Matin**



**Après-midi**





 

## Lundi 17.05.2021

*A faire :*



**Matin**



**Après-midi**





 

## Mardi 18.05.2021

*A faire :*



**Matin**



**Après-midi**





 

## Mercredi 19.05.2021

*A faire :*



**Matin**



**Après-midi**





## Jeudi 20.05.2021

*A faire :*



**Matin**



**Après-midi**





