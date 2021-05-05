
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

Je lis l'énoncé, réalise le planning prévisionnel, qui prend un peu plus de temps que prévu, et pose des questions à l'enseignant qui me suit.

Nous convenons que je peux, au lieu de donner la météo sur la semaine à venir, la donner sur les 5 jours à venir, puisque telles sont le contraintes de l'API gratuite (openweathermap).

Je réalise ensuite le product backlog, en me référant à l'énoncé. Je le finis plus tôt que prévu.

**Après-midi**

Je réalise les maquettes principales du site (page principale, calendrier, semainier, formulaire d'ajout de vêtements, page de visualisation des vêtements).

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

- 

- Créer la page qui permet de supprimer les utilisateurs dans une liste
- Créer la fonction qui génère les jours à afficher pour le calendrier (arrangement pour que la semaine ne soit pas coupée dans l'affichage du mois)
- Récupérer les évènements à afficher dans le calendrier et le semainier
- Affichage du calendrier (s'il me reste du temps)

**Matin**

7h30 : Je commence la journée en testant ce que j'avais fait la veille, c'est à dire le système de gestion des utilisateurs. J'ai dois résoudre quelques problèmes de fonctionnement, puisque les tests ne passent pas

8h30 : Erreurs corrigées, les tests passent. J'ai avancé sur la documentation, notamment en remplissant mon tableau d'avancée des tests.

9h30 : Je réalise la page de gestion des utilisateurs, réservée aux administrateurs. J'effectue les tests, que je valide.

10h30 : Je commence le calendrier



**Après-midi**



➔ **Bilan de la journée** :



## Jeudi 06.05.2021

*A faire :*



**Matin**



**Après-midi**



 

## Lundi 10.05.2021

*A faire :*



**Matin**



**Après-midi**



➔ **Bilan de la journée** :



 

## Mardi 11.05.2021

*A faire :*



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





