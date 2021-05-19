# Wearther

**Résumé du rapport TPI**

*Aliya Myaz - Mai 2021*

*École de métiers : CFPT Informatique, Petit-Lancy GE*

*Entreprise formatrice : Formation plein temps (en école)*



## Situation de départ

Pour valider ma formation d'informaticien CFC, je dois effectuer un travail pratique individuel (TPI) d’une durée de 88 heures, sur la base d’un énoncé imposé. Mon projet est une application web qui propose des recommandations de tenues journalières pour la semaine à venir, en se basant sur la météo du jour. Pour accomplir son rôle de la meilleure manière, et être pratique pour l'utilisateur, elle affiche, sur la même page, la météo d'un jour, la tenue recommandée, ainsi que les évènements et activités à accomplir dans la journée. Ainsi, l'application comporte un calendrier et un semainier, pour que l'utilisateur puisse y enregistrer ses activités, et un système de gestion de la garde-robe, pour qu'il puisse enregistrer ses vêtements.



## Mise en œuvre

Le projet a été réalisé en PHP et MySql, en dehors de la fonctionnalité d'affichage de graphique météo qui est en javascript. Il fait également appel à une API externe, *OpenWeatherMap*, qui lui fournit les informations météo. La méthodologie dite de planification en 6 étapes a été utilisée tout au long du projet pour organiser le travail. Un diagramme de GANTT et un Product Backlog ont servi a la planification du projet, afin que toutes les fonctionnalités demandées soient bien implémentées à la fin. Un protocole de tests a également été rédigé dès la planification pour m’assurer de la conformité de l’implémentation par rapport à l’énoncé. Un journal de travail a été quotidiennement tenu à jour pour détailler l'avancement du projet, et pouvoir organiser mon travail au fur et à mesure des jours.



## Résultats

L'application finale à disposition est fonctionnelle et agréable à utiliser. L’intégralité des spécifications du cahier des charges ont pu être implémentées. Un documentation technique, ainsi qu'un guide d'utilisation, ont également été rédigés.









































## Quel est mon le projet ?

Mon projet est un site qui donne de recommandations de tenues, se basant sur la météo et les vêtements possédés par l'utilisateur. Il est possible de s'y inscrire, d'entrer les vêtement présents dans la garde-robe et de se connecter au site pour visualiser les propositions sur les 5 jours à venir. Le site comporte également un calendrier qui permettra de visualiser les évènement des 5 jours à venir et de vérifier si la tenue proposée est adaptée. Si ce n'est pas le cas, il est possible d'en re-générer une aléatoirement.

Ce projet a pour but d'éviter de perdre du temps à rechercher une tenue, et, grâce à la prévision sur 5 jours.



## Fonctionnement du site

Pour le bon fonctionnement de ce projet, je devais réaliser, en PHP :

* une gestion des utilisateurs
* Un formulaire permettant d'entrer les vêtements de l'utilisateur
* le stockage de données les concernant dans une base de données SQL
* l'utilisation d'une API externe qui fournit des informations météorologiques
* Un affichage des informations météorologiques 
* Un système de recommandation de tenue aléatoire, en fonction 
* Un calendrier permettant de gérer les évènements des utilisateur



## Comment le projet peut-il évoluer ?

Le projet étant maintenant fonctionnel, les améliorations pourront surtout servir à étendre les services proposés, et améliorer l'expérience utilisateur.

***Plus de recommandations***

Afin de réunir dans le site plus d'informations dont pourrait avoir besoin d'utilisateur s'agirait d'ajouter des catégories de recommandations, comme des tâches à réaliser dans la semaine et la journée, les affaires à préparer pour le lendemain, par exemple.

***Notifications***

Un système de notifications journalières pourrait être implémenté, afin de réduire les efforts de l'utilisateurs. 