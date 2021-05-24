
# Journal de travail

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



## Lundi 10.05.2021

*A faire :*

- Implémentation du système de récupération et stockage d'informations météo

- Affichage météo
- Tests météo

**Matin**

8h40 : Je commence le système météo. Pour ça, je dois d'abord récupérer les informations grâce à l'API. Je lis la documentation de l'option que j'ai choisie au début de mon travail, et essaie de créer la bonne requête. Puis je l'implémente dans mon code.

10h00 : Je crée des classes pour gérer l'enregistrement des informations météo récupérées.

**Après-midi**

12h40 : Je réalise des fonctions de classement des informations, afin de ne récupérer que celles dont j'ai besoin, et de les organiser de manière pratique pour pouvoir facilement les afficher ensuite.

14h00 : Je commencer à réaliser des fonctions d'affichage, qui me permettent d'afficher les informations détaillées pour chaque jours.

 

## Mardi 11.05.2021

*A faire :*

- Finir affichage météo

- Fonctionnalités création, modification et suppression de vêtement
- Génération dynamique de l'image du vêtement (vectoriel)

**Matin**

7h30 : Je n'avais pas fini l'affichage de la météo, donc je continue. Je dois trier les évènements de chaque journée par ordre chronologique, et gérer l'affichage des détails météo pour une heure de la journée sélectionnée.

9h40 : Je m'occupe de l'affichage de ma météo résumée (température et catégorie météo) dans le calendrier pour les 3 jours à venir.

**Après-midi**

12h40 : Je commence le système de gestion de la garde-robe en créant des formulaires de création, modification et suppression des vêtements. 

15h00 : Le site doit permettre d'afficher des images des vêtements que les utilisateurs vont créer. Je dois donc créer une fonctionnalité de génération d'images vectorielles (.svg) représentant la catégorie et la couleur du vêtement. L'image ne sera stockée nul part, mais sera générée au moment de l'affichage grâce à la base de données.

 

## Mercredi 12.05.2021

*A faire :*

- Finir génération images vectorielles
- Discuter avec mon enseignant de la gestion des catégories de vêtements
- Rechercher images vectorielles pour chaque catégorie de vêtement
- Algorithme de recommandation de tenues
- Corrections calendrier
- Documentation


**Matin**

7h30 : Je finis la dernière tâche d'hier. Je n'ai pas encore les images vectorielles des vêtements, mais je teste quand même avec des valeurs par défaut. Les tests de création, modification, suppression et affichage des vêtements passent.

8h30 : La dernière étape pour la gestion des vêtement est la génération de tenues journalières adaptées à la météo. Je réalise donc l'algorithme qui permet de sélectionner aléatoirement une tenue complète en fonction de la température de la journée et du groupe météo (pluie, etc...)

11h00 : Le gros du travail est fini. Je commence à corriger ce qui ne fonctionne pas, dont quelques petites fonctionnalité que j'ai oublié d'implémenter, comme le déplacement de mois en mois sur le calendrier, que j'ai oublié d'implémenter.

**Après-midi**

12h40 : mon enseignant pour discuter dans la consigne. En effet, je pensais mettre, pour chaque type de vêtement (veste, chaussures...) un modèle d'image SVG dans la BD pour pouvoir les afficher. Or dans la consigne, on me demande de pouvoir ajouter des types, qui ne pourront donc pas avoir d'image attribuée. Puis je continue les corrections concernant la gestion du calendrier et du semainier.

16h00 : Je réalise les tests l'ensemble des fonctionnalités. Les tests passent. La partie fonctionnement du site est terminée.



## Lundi 17.05.2021

*A faire :*

- Créer le template
- Appliquer le template sur l'ensemble du site.
- Refaire les tests
- Avancer sur la documentation (s'il reste du temps) 

**Matin**

7h30 : Je crée le template que je vais utiliser pour toutes les pages de mon site

10h30 : Je commence à l'implémenter

**Après-midi**

12h40 : Je continue à ajuster le template à mes différents types de pages.

15h20 : Je réalise les tests pour vérifier que les changements n'ont pas entraîné de régression.

16h00 : Je réalise grâce aux tests qu'il y a un problème avec l'ajout d'activités au semainier, causé par le fait qu'il peut y avoir plusieurs. Je règle le problème en supprimant automatiquement l'activité existante à une certaine heure, au moment où une autre est ajoutée à la même heure du même jour.

 

## Mardi 18.05.2021

*A faire :*

- Faire l'analyse organique de la documentation
- Faire le résumé du travail
- Créer le template pour les formulaires du site

**Matin**

7h30 : Je programme les trois jours qui me restent pour être sûre de bien terminer la documentation et les autres documents

8h00 : Je réalise la partie planification de la documentation et commence l'analyse organique

**Après-midi**

12h40 : Je continue la réalisation de mes documentations en faisant la documentation utilisateurs.

14h00 : Je suis partie.



## Mercredi 19.05.2021

*A faire :*

- Documentation : faire le manuel d'utilisateur et le résumé du projet, entre autres
- Tests avancés (recherche de dysfonctionnements inattendus, en testant sur différents navigateurs, et en utilisant le site de manière non idéale)
- Eventuelles corrections

**Matin**

7h30 : Je découvre une erreur dans mon système d'affichage de météo dans le calendrier qui n'apparaît que tôt le matin. Je la corrige donc, et fais un push.

8h00 : Je continue l'analyse organique.

**Après-midi**

12h40 : Je continue la documentation, et pose des questions concernant certaines parties à mon enseignant.



## Jeudi 20.05.2021

*A faire :*

- **Documentation :** 
- Corriger backlog et tests
- Description des tables
- Corriger MLD

- **Code : **
- Ajouter images vêtements
- Changer le visuel des formulaires
- (Déplacer les méthodes de gestion de la météo dans les classes météo)
- Nettoyer et finir de commenter le code

**Matin**

7h30 : Je crée les scripts pour les images vectorielles, en modifiant des images déjà existantes. Je les ajoute à la base de données. 

8h30 : J'implémente le template de formulaire à tous les formulaires du site.

10h00 : Je relis l'intégralité de mon code source, pour le corriger, nettoyer et commenter.

**Après-midi**

13h40 : Analyse fonctionnelle - correction backlog + tests

16h30 : Je corrige le modèle logique de données que j'avais réalisé au début, et décris mes tables dans l'analyse organique.



## Samedi 22.05.2021

*A faire :*

- **Documentation :**
- Ajouter planifications prévues et effectives
- Description architecture projet
- Description des fonctions
- Relire tous les documents
- Assembler et convertir en PDF

**Matin**

7h30 : Je réalise une dernière fois tous mes tests pour vérifier que rien n'a été cassé quand j'ai nettoyé le code.

8h30 : Je rassemble tous les fichiers de mon code source pour pouvoir en faire un PDF.

9h15 : Je réalise la description de l'architecture, et corrige l'écriture de mes tests.

10h00 : Je commence la description des fonctions de mon projet.

**Après-midi**

12h40 : Je continuer la description des fonction.

14h00 : Je relis l'ensemble de mes documents pour corriger les erreurs et compléter ce qui manque.

15h30 : J'exporte mon planning effectif en PDF et l'ajoute à ma documentation, puis je crée dossiers de rendu.







