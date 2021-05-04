
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
$startHour = date('h', strtotime($dateStart));
$startMinute = date('i', strtotime($dateStart));
$startMonth = date('m', strtotime($dateStart));
$startDay = date('d', strtotime($dateStart));
$startYear = date('Y', strtotime($dateStart));

//Transformer les dates en timestamp mySQL
$timestampStart = date ('Ymd H: i: s', mktime ($startHour, $startMinute, 0, $startMonth, $startDay, $startYear));
```



14h00 : J'ai commencé les formulaires de connexion et d'inscription.





## Mercredi 05.05.2021

*A faire :*



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





