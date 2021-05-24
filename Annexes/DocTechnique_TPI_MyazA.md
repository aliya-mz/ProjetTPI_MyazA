# Wearther

Documentation technique, Projet de TPI, *Myaz Aliya*

<img src="DocImages\logo.png"/>



## Table des matières

[TOC]



## Table des versions

| N° de version | Date       | Auteur     | Changements apportés                            |
| ------------- | ---------- | ---------- | ----------------------------------------------- |
| 1.0           | 20.05.2021 | Aliya Myaz | Version finale du document pour le rendu du TPI |





## Introduction

Le projet ***WearTher*** est une application web qui propose des suggestions de tenues en fonction de la météo. Son but est de faire gagner du temps aux utilisateurs, voir de les sauver les jours où leur réveil ne sonne pas. L'application permet, en un clic, d'avoir un aperçu sur la météo du jour et de la semaine à venir, une suggestion de tenue journalière adaptée à la météo, et une vue sur leur agenda du jour, le tout sur la même page. En effet, pour être la plus pratique possible, l'application dispose également d'un calendrier et d'un semainier.

J'ai réalisé ce projet en PHP avec une base de donnée MySQL. J'ai également fait appel à une API externe pour les informations météo.





## Rappel du cahier des charges

### Objectif

L'application à réaliser est un système de recommandation de tenues en fonction de la météo.

- Elle comporte une gestion des utilisateurs, qui peuvent appartenir à deux types de rôles : les utilisateurs et les administrateurs. Ils doivent pouvoir se connecter. Les utilisateurs peuvent créer, modifier et supprimer leur compte. Les administrateurs peuvent créer, modifier et supprimer les comptes des utilisateurs.

- L'utilisateur peut créer, modifier et supprimer des vêtements. Il peut choisir la couleur de son vêtement et lui associer une catégorie et des conditions météorologiques. Les vêtements proposés sont conformes aux conditions météorologiques du jour sélectionné.
  "Des catégories et vêtements de base sont pré-disponibles. L’utilisateur peut en créer de nouveaux."

- Les informations météorologiques sont toujours actualisées depuis la source externe avant d’être affichées. Chaque jour peut être sélectionné individuellement pour voir les détails (température, ensoleillement et suggestions vestimentaires associées).
- Un calendrier avec un prévisionnel météorologique des 3 jours à venir doit être affiché (temp. et ensoleillement).
- L’application est fonctionnelle avec un moins un service de données météo externe.



### Organisation

|                        | Nom              | Email                      |
| ---------------------- | ---------------- | -------------------------- |
| Elève                  | Aliya Myaz       | <aliya.mz@eduge.ch>        |
| Maître d'apprentissage | Oscar François   | <Oscar.Francois@edu.ge.ch> |
| Experts                | Serge Murisier   | serge@murisier.com         |
|                        | Borys Folomietow | <borys@folomietow.ch>      |

***Temps*** : travail à réaliser entre le 3 mars et le 20 mars avec comme horaire de travail : 7h30-11h40 / 12h40 -16h45. A rendre le 20 mars.

***Méthodologie*** : Un planning détaillé doit être réalisé avant la fin de la première journée. Les temps approximatifs qui doivent être attribués à chaque partie du travail sont les suivants : 14h pour l'analyse, 34h pour l'implémentation, 14h pour les tests, et 18h pour la documentation. La méthodologie en 6 étapes doit être utilisée pour la gestion du projet (GANTT) et la méthodologie agile pour le développement
(BACKLOG).



### Livrables

A la fin de la durée du TPI, je dois rendre aux experts et à mon enseignant :

1. Un résumé du TPI

2. Un planning prévisionnel et effectif

3. Un rapport de projet avec le code source en annexe

4. Un manuel d'utilisateur

5. Une journal de travail



### Matériel et logiciels nécessaires

1. Un PC standard école avec Windows 10 ou Linux Ubuntu LTS, 2 écrans
2. Serveur Web et SGBD au choix
3. Environnement intégré de développement au choix
4. Outil de versionnage (gitlab/github ou un conteneur de l’école).
5. Navigateur web (Mozilla Firefox/Google Chrome).
6. Logiciel de création de schémas au choix
7. Logiciel de maquettage au choix
8. API tierce de services météo: https://openweathermap.org/api ou autre jugé équivalent.
9. Outil bureautique à choix pour les documents
10. Matériel personnel



### Changements du cahier des charge

Certains éléments du cahiers des charges ont été modifiés suite à des discussions avec mon enseignant. Les voici :

- De nouvelles catégories de vêtements ne peuvent être ajoutées par l'utilisateur, puisque chacune d'entre elles doit disposer d'un script xml spécifique pour que le vêtement puisse ensuite être affiché.
- La météo et donc les recommandations vestimentaires ne sont disponibles que pour les 5 jours à venir et non la semaine, puisque telles sont les contraintes de l'API





## Méthodologie

### Planification en six étapes

#### 1. S'informer

J'ai commencé par lire attentivement mon énoncé afin d'en ressortir tout ce qui était nécessaire à la réalisation de mon projet, et ai demandé des précisions à mon formateur. J'ai également fait des recherches sur l'API météo que je pourrais utiliser pour mon projet.

#### 2. Planifier

Ensuite, je me suis directement attaquée au planning, sous forme de diagramme de GANTT, dans le but d'être organisée dès le début et d'optimiser mon temps. Cela m'a aussi permis de clarifié toutes les tâches et sous-tâches que je devais réaliser pour mener mon projet jusqu'au bout.

Je me suis appuyée dessus pour faire, juste après, le product backlog avec des user stories, en définir ainsi clairement, du côté de l'utilisateur de mon site, les fonctionnalités à implémenter.

Pour chaque story, j’ai fixé une priorité, grâce à la méthode MoSCoW, pour être plus efficace dans ma manière de travailler. Voici la notation de cette méthode :

M : Must

S : Should

C : Could

W : Won't (non utilisé car pas besoin dans ce projet)

J'ai également ajouté ce caractère :

!  : Bloquant

#### 3. Décider

Dans chaque partie de mon travail, j'ai dû faire des choix, notamment quant au calendrier, dont les instructions étaient plutôt libres, mais aussi des choix quand aux limites de mon travail. En effet, ayant souvent tendance à vouloir faire plus, j'ai du me restreindre de manière à répondre correctement aux objectifs explicitement donnés, dans le temps donné. J'explique dans le journal de bord les différentes décisions que j'ai pris.

#### 4. Réaliser

J'ai donc pu, grâce aux étapes précédentes, implémenter mon travail de manière organisée et réfléchie.

#### 5. Contrôler

J'avais commencé par mettre, dans le planning, tous mes tests à la fin, avant de réaliser que je devais tester chaque fonctionnalité après l'avoir terminée, d'autant plus que les tests étaient déjà créés dès le début à cet effet. J'ai donc effectué tous les tests de chaque fonctionnalité après l'avoir terminée, ainsi que tous les tests des fonctionnalités précédemment réalisées et testées, pour vérifier qu'il n'y ait pas de régression. Un tableau, dans ma documentation, me permet de suivre l'évolution de mes fonctionnalités terminées, en visualisant les tests fonctionnels. Ensuite, je suis allée au-delà des tests et ai essayé d'utiliser "mal" mon programme afin de m'assurer qu'il ne possédait pas de failles.

#### 6. Évaluer

Les bilans de la journée que j'ai écrit après chaque journée de travail m'ont permis, à la fin, de me rendre compte de ma manière de travailler, et d'évoluer. Les plannings prévisionnels et effectifs m'ont également été utiles pour constater la manière de travailler qui me convenait réellement. J'ai donc rédigé un bilan personnel dans ma conclusion, afin de rendre compte de mes constatations et ressentis.



### Développement agile

Le projet est donc réalisé en développement agile, grâce à un diagramme de GANTT et un backlog créé avant le début du travail.





### Plannings

Voici les plannings prévisionnels et effectifs commentés.

Ils également donnés en PDF, pour une meilleure visibilité.



#### Planification prévue

![](docImages/planningPervisionnelPart1.PNG)

*Deux premières semaines*

![](docImages/planningPervisionnelPar2.PNG)

*Dernière semaine*



#### Planification effective

![](docImages/planningEffectifPart1.PNG)

*Deux premières semaines*

![](docImages/planningEffectifPart2.png)

*Dernière semaine*



#### Comparaison

Dans mon planning effectif, j'ai pris un peu d'avance sur le début, avant de revenir sur les dates prévues. Je constate que je n'ai pas suffisamment différencié les longueurs des tâches dans mon planning prévisionnel, même si globalement c'était plutôt juste.

On peut aussi remarquer, sur mon planning effectif, que j'ai tendance à réaliser plusieurs tâches en même temps, au lieu d'attendre d'avoir fini la première. J'ai fait l'effort de suivre plus ou moins l'ordre des tâches, mais dès que j'en commence une, j'ai envie de commencer toutes celles qui lui sont liées. C'est donc difficile à prévoir sur un planning, mais j'arrive mieux à travailler de cette manière.

J'avais également oublié, dans ma planification, d'inscrire les phases de test intermédiaires pour la fin de chaque groupe de fonctionnalités.

Finalement, les bugs découverts vers la fin, qui étaient trop spécifiques pour entrer dans mes scénarios de tests, m'ont aussi un peu déconcentrée du planning sur la fin, puisque je devais chaque jour passer du temps à résoudre ma dernière découverte.







## Analyse fonctionnelle

### Product backlog

| Nom                       | S1 : Inscription                                             |
| ------------------------- | ------------------------------------------------------------ |
| *Description (user story) | En tant qu'utilisateur non connecté, je peux créer un compte, en indiquant mon nom, prénom, pseudo, adresse mail et mot de passe. |
| *Critère d'acceptation*   | Le test 1.1 passe                                            |
| *Priorité*                | ! M                                                          |

| Nom                        | S2 : Connexion                                               |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur non connecté, je peux me connecter en entrant mon pseudo et mon mot de passe. |
| *Critère d'acceptation*    | Les tests 1.2 à 1.5 passent                                  |
| *Priorité*                 | ! M                                                          |

| Nom                        | S3 : Déconnexion                                             |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je peux cliquer sur un bouton pour me déconnecter. |
| *Critère d'acceptation*    | Le test 1.6 passe                                            |
| *Priorité*                 | M                                                            |

| Nom                        | S4 : Modifier son compte                                     |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je peux modifier chacune des informations liées à mon compte. |
| *Critère d'acceptation*    | Le test 1.7 passe                                            |
| *Priorité*                 | S                                                            |

| Nom                        | S5 : Supprimer son compte                                    |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je peux supprimer mon compte |
| *Critère d'acceptation*    | Le test 1.8 passe                                            |
| *Priorité*                 | S                                                            |

| Nom                        | S6 : Créer un utilisateur                                    |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'administrateur connecté, je peux créer un nouvel utilisateur. |
| *Critère d'acceptation*    | Les test 1.12 passe                                          |
| *Priorité*                 | S                                                            |

| Nom                        | S7 : Modifier le compte d'un utilisateur                     |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'administrateur connecté, connecté, je peux modifier les informations d'un compte utilisateur sélectionnée dans une liste |
| *Critère d'acceptation*    | Les tests 1.9 et 1.10 passent                                |
| *Priorité*                 | S                                                            |

| Nom                        | S8 : Supprimer un utilisateur                                |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'administrateur connecté, je peux supprimer un utilisateur sélectionné dans une liste. |
| *Critère d'acceptation*    | Les tests 1.9 et 1.11 passent                                |
| *Priorité*                 | S                                                            |



#### Météo

| Nom                        | S9 : Afficher la météo détaillée                             |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je peux visualiser, pour un jour sélectionné parmi les 5 prochains, la température au cours de la journée et les détails météo pour toutes les trois heures. |
| *Critère d'acceptation*    | Les tests 2.1 passe                                          |
| *Priorité*                 | M                                                            |

| Nom                        | S10 : Afficher la météo résumée                              |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je peux visualiser, dans mon calendrier, pour les quatre prochains jours, la température et l'état d'ensoleillement. |
| *Critère d'acceptation*    | Les tests 2.3 et 3.1 passent                                 |
| *Priorité*                 | S                                                            |



#### Calendrier

| Nom                        | S11 : Afficher le calendrier                                 |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je peux visualiser mon calendrier, mois par mois, avec ses évènements, ainsi que la météo sur les trois jours à venir. |
| *Critère d'acceptation*    | Les tests 2.2, 3.1 et 3.3 passent                            |
| *Priorité*                 | M                                                            |

| Nom                        | S12 : Afficher le semainier                                  |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je peux visualiser mon semainier, contenant tous les évènements hebdomadaires que j'ai ajouté. |
| *Critère d'acceptation*    | Les tests 3.2 à 3.3 passent                                  |
| *Priorité*                 | M                                                            |

| Nom                        | S13 : Ajouter un évènement                                   |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je peux remplir un formulaire contenant une description de l'évènement ainsi que sa date et son heure, ainsi qu'une case à cocher définissant si c'est un évènement hebdomadaire ou unique. |
| *Critère d'acceptation*    | Les tests 3.3 à 3.4 passent                                  |
| *Priorité*                 | M                                                            |

| Nom                        | S14 : Afficher les évènements d'une journée                  |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je peux, en sélectionnant un jour parmi les 5 jours à venir, afficher les évènements assignés à cette date et ce jour de la semaine. |
| *Critère d'acceptation*    | Les tests 3.5 à 3.6 passent                                  |
| *Priorité*                 | S                                                            |

| Nom                        | S15 : Supprimer un évènement                                 |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je supprimer un évènement en cliquant sur la croix. |
| *Critère d'acceptation*    | Le test 3.7 passe                                            |
| *Priorité*                 | S                                                            |



#### Vêtements

| Nom                        | S16 : Ajouter un vêtement                                    |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je peux ajouter un vêtement à ma garde-robe en replissant un formulaire, qui indique son type et sa couleur, ainsi que la catégorie météo et intervalle de température dans lequel il peut être porté. |
| *Critère d'acceptation*    | Le test 4.1 passe                                            |
| *Priorité*                 | M                                                            |

| Nom                        | S17 : Afficher un vêtement                                   |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateurs connecté, je peux visualiser l'image d'un vêtement que j'ai créé, qui est un fichier SVG généré grâce au type et à la couleur du vêtement. |
| *Critère d'acceptation*    | Le test 4.2 passe                                            |
| *Priorité*                 | S                                                            |

| Nom                        | S18 : Afficher ma garde-robe                                 |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateurs connecté, je peux visualiser l'image d'un vêtement que j'ai créé, qui est un fichier SVG généré grâce au type et à la couleur du vêtement. |
| *Critère d'acceptation*    | Le test 4.1 et 4.2 passent                                   |
| *Priorité*                 | S                                                            |

| Nom                        | S19 : Afficher une recommandation de tenue                   |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je peux visualiser, pour chaque jour sélectionné parmi les 5 à venir, une tenue adaptée à la météo prévue. |
| *Critère d'acceptation*    | Les tests 4.2 à 4.3 passent                                  |
| *Priorité*                 | M                                                            |

| Nom                        | S20 : Modifier un vêtement                                   |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je peux ajouter un vêtement à ma garde-robe en replissant un formulaire, qui indique son type et sa couleur, ainsi que la catégorie météo et intervalle de température dans lequel il peut être porté. |
| *Critère d'acceptation*    | Le test 4.4 passe                                            |
| *Priorité*                 | S                                                            |

| Nom                        | S21 : Supprimer un vêtement                                  |
| -------------------------- | ------------------------------------------------------------ |
| *Description (user story)* | En tant qu'utilisateur connecté, je peux ajouter un vêtement à ma garde-robe en replissant un formulaire, qui indique son type et sa couleur, ainsi que la catégorie météo et intervalle de température dans lequel il peut être porté. |
| *Critère d'acceptation*    | Le test 4.5 passe                                            |
| *Priorité*                 | S                                                            |



## Description de l'interface

Voici une description des pages principales de l'application. Seuls les formulaires, qui ne présentent pas de particularités, ne sont par présentés.



***Page d'accueil*** : Affiche, pour une journée parmi les 5 à venir, la météo tout au long de la journée, une recommandations de tenue adaptée à la tenue, ainsi que les activités et évènements. Navigation entre ces jours.

Fonctionnalités : S9 et S19

![](docImages\captureAccueil.PNG)

***Page de gestion de la garde-robe*** : Affiche les vêtements ajoutés par l'utilisateur, avec des contrôles permettant de les modifier et de les supprimer.

Fonctionnalités : S16 à S21

![](DocImages\captureGardeRobe.PNG)



***Calendrier*** : Calendrier classique affichant les évènements ajoutés par l'utilisateur, ainsi que la météo du matin et du soir pour les trois jours à venir. Navigation de mois en mois.

Fonctionnalités : S10, S11, S13 et S15

![](DocImages\captureCalendrier.PNG)



***Semainier*** : Semainier affichant, pour chaque jour de la semaine, de 6h à 22h, les activités hebdomadaires enregistrées par les utilisateurs.

Fonctionnalités : S12, S13 et S15

![](DocImages\captureSemainier.PNG)








## Analyse organique

### Technologies utilisées

- PHP 7.3.21
- CSS
- JavaScript
- MySQL
- Bootstrap 5
- Google Charts



### Environnement

J'ai développé mon projet sur Visual Studio Code.

Pour la planification, j'ai réalisée le planning en document Excel, les maquettes sur Figma, les diagrammes sur Umlet.

J'ai également réalisé tout le reste de la documentation en Markdown, grâce à Typora.

J'ai créé un repo git et y est sauvegardé mon projet plusieurs fois par jour, nécessairement avant de quitter la classe, grâce à Git Kraken.



### Description de l’architecture du projet

#### Schéma client-serveur

![](docImages/architectureMaterielle.png)

#### Organisation des répertoires

*Racine* : Les pages du site sont toutes à la racine du projet. Les répertoires ***backend***, ***css*** et ***img*** sont également à la racine.

*css* : Le répertoire ***css*** contient l'unique fichier css du projet.

*img* : Le répertoire ***img*** contient les icones du site, ainsi qu'un autre répertoire, ***imgClothes***, qui est vide, et dans lequel sont créées dynamiquement les images des vêtement lors de l'affichage.

*backend* : Le répertoire ***backend*** contient les fonctions et classes PHP, ainsi que les fonctions javascript du projet. Il contient aussi le répertoire ***database***

*database* : Le répertoire ***database*** contient, dans des fichiers séparés, les constantes de connexion à la base de données, la fonction de connexion à la base de données, ainsi que les CRUD des toutes les tables.

![](docImages/architectureTechnique.png)



### Modèle logique de données

La base de données est composée des six tables suivantes.

<img src="docImages/mld.png"/>



### Description des tables

#### Table "User"

Sauvegarde les informations du compte de l'utilisateur, dont son mot de passe en SHA1.

![](docImages/userTable.PNG)



#### Table "Role"

Sauvegarde la liste des rôles prédéfinis pour les utilisateurs (déconnecté, utilisateur, administrateur).

![](docImages/roleTable.PNG)



#### Table "Clothe"

Sauvegarde les vêtements des utilisateurs avec leurs météo correspondante.

![](docImages/clotheTable.PNG)



#### Table "Event"

Sauvagarde les évènements des utilisateurs, qui peuvent être uniques ou hebdomadaires.

![](docImages/eventTable.PNG)



#### Table "Category"

Sauvegarde les catégories de vêtements disponibles prédéfinies. Le fonctionnement du programme ne dépend pas de l'index des catégories.

![](docImages/categoryTable.PNG)



#### Table "Weather"

Sauvegarde les groupes météo prédéfinis (Neige, Pluie, Normal). Le fonctionnement du programme ne dépend pas de l'index.

![](docImages/weatherTable.PNG)



### Services externes

#### OpenWeatherMap

Pour réaliser mon système de météo, j'ai utilisé l'API **OpenWeatherMap**, et plus spécifiquement la version gratuite de l'offre "*5 day weather forecast*", qui permet d'obtenir, pour les 5 jours (5x24h) à partir de maintenant, des informations météo détaillées toutes les trois heures.

Voici le lien de la documentation de cette version : https://openweathermap.org/forecast5

J'ai ensuite dû réaliser des fonctions qui permettent de traiter ces informations brutes, pour en retirer ce dont mon application a besoin, et les organiser de manière pratique pour les récupérer et les afficher ensuite.



#### Google Charts

Google Charts est un outil qui visualiser des données sous forme de graphique sur un site web. Pour l'utiliser, j'ai intégré un javascript à mon projet. Ce script charge des bibliothèques de graphiques Google et crée un objet de graphique. Les graphiques sont rendus à l'aide de la technologie HTML5 / SVG.

Lien de la documentation google charts : https://developers.google.com/chart/interactive/docs



### Classes PHP

J'ai créé des classes PHP, qui me permettent toutes d'organiser et d'enregistrer les informations météo renvoyées par l'API.



#### Classe Week

Enregistre une liste de jours (de type *day*).

**Méthodes :**

public *__construct($infosMeteo)* : Crée la liste de jours grâce au tableau récupéré en paramètre

public *GetDays()* : Retourne le liste des jours

public *GetDay($numDay)* : Retourne le jour présent à l'emplacement de la liste récupérée en paramètre



#### Classe Day

Enregistre une liste d'enregistrements météo (de type *meteoRecord*).

**Méthodes :**

public *__construct($infosMeteo)* : Crée la liste d'enregistrements météo grâce au tableau récupérée en paramètre

public *GetHours()* : Retourne le liste des enregistrements

public *GetHour($numHour)* : Retourne l'enregistrement présent à l'emplacement de la liste récupérée en paramètre

public *GetDate()* : Retourne la date du jour



#### Classe MeteoRecord

Enregistre toutes les informations météo liées à un enregistrement

**Méthodes :**

*Chaque méthode retourne une information météo différente*





### Fonctions principales du projet

Tout ce qui concerne la gestion des utilisateurs, de la météo, du calendrier, du semainier et de la garde-robe est programmé sous forme de fonctions. Celles-ci sont réunies dans un même fichier (functions.php). Voici la liste de ces fonctions, ainsi que la description de leur rôle.

Seules les fonctions principales, qui résument le fonctionnement du programme, sont présentées. Les autres sont généralement des petites fonctions sans autre intérêt que la séparation des tâches, et sont déjà commentées dans le code source. Les fonctions d'affichage notamment ne sont pas présentées si elles ne comportent rien de particulier.



#### Gestion des utilisateurs

Fonction **VerifyAccessibility**($acceptedRole) :

Son rôle est de vérifier que l'utilisateur a le droit d'accéder à la page courante. Elle vérifie si le rôle de l'utilisateur connecté est identique à l'un des rôles récupérés en paramètre, et si ce n'est pas la cas, redirige vers la page principale.

Fonction **ConnectUser**($login, $password) :

Son rôle est de connecter un utilisateur si possible. Elle vérifie que le nom d'utilisateur recherché existe dans la base de données. Si c'est le cas, récupère son mot de passe hashé, puis vérifie qu'il soit identique au mot de passe entré grâce à la fonction php "*password_verify*". S'ils sont identiques, l'identifiant de l'utilisateur est enregistré dans la session, et est alors connecté.

Fonction **UpdateUser**($login, $firstName, $lastName, $eMail, $password) :

Modifie les informations de l'utilisateur dans la base de données. Si le mot de passe a été modifié dans le formulaire, le hash avant de l'envoyer avec le reste des informations dans la requête update.



#### Fonctionnement de la météo

Fonction **ExecuteMeteoProgram**() :

Son rôle de d'obtenir et d'enregistrer les prévisions météo.

Elle appelle l'API météo pour obtenir les détails météo des 5 jours à venir, pour toutes les trois heures, et sélectionne uniquement les informations nécessaires au programme

Elle classe ces informations dans un tableau de jours, qui eux-même sont des tableaux d'enregistrements.

Ce tableau "semaine" est envoyé en paramètre à un nouvel objet *week*, qui va créer une liste d'objets *day*, qui eux-même vont créer une liste d'objets *meteoRecord*. La classe *meteoRecord* sauvegarde alors toutes les informations de la prévision météo d'une heure précise.

Pour finir, l'objet *week*, contenant donc toutes les prévisions météo pour la semaine à venir, est enregistré dans la session.



Fonction **DisplayTemperatureGraphic**($hours, $temperatures, $date) :  

Transforme les tableaux d'heures et de températures de la journée en un string qui représente un tableau js, puis écrit en HTML l'appel d'une fonctions javascript qui utilise les services de Google Charts pour afficher un graphique des températures de la journée, dans une balise dont l'identifiant correspond la date du jour à afficher.



Fonction **DisplayRecordingsDetails**($day, $idRecording) :

Affiche, pour une heure sélectionnée dans la journée, l'humidité, la probabilité de précipitations et la vitesse du vent, en récupérant les informations dans grâce à l'objet *meteoRecord* de l'heure correspondante.



Fonction **DisplayDaysEvents**($numDay) :  

Son rôle est d'afficher les évènements et activités d'une journée.

Elle récupère les activité du semainier dont le jour correspond au jour de la semaine du jour à affiché.

Récupère ensuite les évènements du calendrier correspondant à la date du jour affiché. Trie l'ensemble des évènements et activités récupérés par ordre chronologique, puis les affiche.



Fonction **DisplayMeteoSummary**($numDay) :

Son rôle est d'afficher la météo dans une case du calendrier.

Elle récupère la température et le groupe météo du matin et du soir, et les affiche dans la case correspondant du calendrier.

Si l'heure de récupération des informations du matin est déjà passée, récupère à la place les informations de l'heure actuelle, et si l'heure du soir est déjà passée, récupère à la place la dernière heure.



#### Fonctionnement du calendrier et semainier

Fonction **GetCalendarDays**($month, $year) :

Génère le tableau des jours à afficher pour un mois donné d'une année donnée



Fonction **GetEventsBetween**($dateStart, $dateEnd) :

Son rôle est d'obtenir les évènements du calendrier pour un mois donné.

Elle transforme les dates de début et de fin en timestamp pour pouvoir les envoyer dans la requête SQL, puis envoie une requête SELECT.



#### Gestion des vêtements

Fonction **GetClothesForMeteo**($temperatures, $weathers) :

Récupère, pour  chaque groupe de vêtements (hauts, bas, chaussures...), tous les vêtements qui correspondent à la météo



Fonction **GenerateDress**($temperatures, $weathers) :

Son rôle est de créer une tenue adaptée à la météo.

Elle récupère, pour chaque groupe de vêtements, la liste des vêtements adaptés à la météo, grâce à la fonction *GetClothesForMeteo*

Pour chaque groupe de vêtements (haut et bas ou ensemble, chaussures, manteau), elle sélectionne un vêtement aléatoire.

Ainsi, elle crée une tenue complète, comportant une veste ou manteau s'il fait froid, et prévient l'utilisateur s'il lui manque des vêtements dans sa garde-robe pour pouvoir sortir de chez lui.



Fonction **CreateClotheImage**($idCategory, $color) :

Crée un fichier SVG vide dans un sous-répertoire du projet, avec un nom aléatoire.

Récupère dans la base de données le script xml, correspondant à une image vectorielle, de la catégorie du vêtement à afficher. Remplace la couleur dans le script par la couleur du vêtements, enregistrée pour le vêtement dans la base de données.

Retourne le chemin de l'image créée.





### Argumentation des choix de méthodes de résolution

#### Choix de l'API météo

J'ai choisi l'API OpenWeatherMap parce que j'avais déjà un peu travaillé dessus, et qu'elle proposait une offre gratuite pratique et qui convenait pour l'utilisation que je voulais en faire. En plus, l'apparence professionnelle du site, comparément aux autres, donnait plus confiance pour la suite.

#### Méthode de réalisation du calendrier

J'ai décidé de réaliser le calendrier entièrement, sans avoir recours à un service externe, parce que je n'en avais jamais utilisé, et aurais donc eu du mal à évaluer la difficulté et le longueur de la tâche, d'autant plus qu'il fallait le personnaliser en y intégrant la météo.

#### Images des vêtements de type vectoriel

Il fallait que j'affiche des images de vêtements, auxquels l'utilisateur pouvait attribuer des couleurs. J'ai choisi de mettre un input de type couleur pour le laisser personnaliser totalement la couleur, et pouvoir ainsi mieux reconnaitre son vêtement. Ainsi, il fallait que je modifie l'image, ne pouvant créer un nombre illimité d'image avec. La manière la plus simple de modifier une image avec du php est d'avoir une image vectorielle, dont le fichier est un script pouvant être facilement modifié. Mon programme génère donc à la demande une image vectorielle avec un script pré-existant pour chaque type de vêtement, dans le quelque il remplace juste l'emplacement de définition de la couleur. Tout est dynamique, je ne stocke des images nul part, et toutes les informations existent dans la base de données.








## Plan de tests et tests

### Périmètre des tests

Les tests de ce projet englobent les actions normales qu'un utilisateur, sur un navigateur classique moderne.



### Environnement de test

**Côté navigateur**

Google Chrome 90.0.4430.212 (64 bits) sur Windows 10 Pro, version 2004

**Côté serveur**

WampServer Version 3.2.3 (64 bits)

PHP 7.3.21

MySQL 5.7.31



### Scénarios de test - modifications à faire

Les scénarios ont été écrits avant la réalisation du projet, afin de garantir la réponse aux demandes du cahier des charge. Lors de la réalisation d'un scénario, faire attention à ce que son scénario prérequis ait été exécuté avant. Dans le cadre de ce travail, les tests ont été exécutés manuellement.

Mauvaise utilisation / Fonctionnel /!\

#### Scénarios - gestion des utilisateurs

| Nom                  | 1.1 Inscription                                              |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S1 : Inscription                                             |
| *Situation*          | Je suis déconnecté ; Je clique sur *"Connexion"* dans la navigation de la page principale ; en-dessous du formulaire de connexion, je clique sur "*je n'ai pas encore de compte*" ; j'entre les valeurs de test suivantes dans le formulaire : "**Nom**" : "*NomTest*" - "**Prénom**" : "PrenomTest" - "**Mail**" : "*test@gmail.com*" - "**Pseudo**" : "*PseudoTest*", "**Mot-de-passe**" : "*abc*"; Je clique sur "*valider*" |
| *Résultats attendus* | Je suis redirigé vers la page principale, déconnecté.        |
| *Statut*             | ✓                                                            |

| Nom                  | 1.2 Connexion utilisateur (prérequis : scénario 1.1)         |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S2 : Connexion                                               |
| *Situation*          | Je suis déconnecté ; Je clique sur *"Connexion"* dans la navigation de la page principale ; J'entre les valeurs suivantes dans le formulaire : "**Pseudo**" : "*pseudoTest*" - "**Mot de passe**" : "*abc*"; Je clique sur "*valider*" |
| *Résultats attendus* | Je suis redirigé vers la page principale, connecté. Dans la barre de navigation, je vois le le bouton "*Déconnexion*". Des liens menant vers le calendrier, le semainier, la garde-robe et l'ajout de vêtements sont apparus. |
| *Statut*             | ✓                                                            |

| Nom                  | 1.3 Connexion administrateur                                 |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S2 : Connexion                                               |
| *Situation           | Etant donné que le compte administrateur existe déjà par défaut ; Je clique sur *"Connexion"* dans la navigation de la page principale ; J'entre les valeurs suivantes dans le formulaire : "**Pseudo**" : "SuperAdmin" - "**Mot de passe**" : "*abcd*"; Je clique sur "*valider* |
| *Résultats attendus* | Je suis redirigé vers la page principale, connecté. Dans la barre de navigation, je vois le le bouton "*Déconnexion*" et le lien "*Gestion des utilisateurs*" |
| *Statut*             | ✓                                                            |

| Nom                  | 1.4 Refus de la connexion mot de passe erroné                |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S2 : Connexion                                               |
| *Situation*          | Je suis déconnecté ; Je n'ai pas créé de compte ; Je clique sur *"Connexion"* dans la navigation de la page principale ; J'entre les valeurs suivantes dans le formulaire : "**Pseudo**" : "*pseudoTest*" - "**Mot de passe**" : "*abcd*"; Je clique sur "*valider* |
| *Résultats attendus* | Je reçois un message d'erreur m'indiquant que le nom d'utilisateur ou le mot de passe est erroné |
| *Statut*             | ✓                                                            |

| Nom                  | 1.5 Refus de la connexion utilisateur inexistant             |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S2 : Connexion                                               |
| *Situation*          | Je suis déconnecté ; Je n'ai pas créé de compte ; Je clique sur *"Connexion"* dans la navigation de la page principale ; J'entre les valeurs suivantes dans le formulaire : "**Pseudo**" : "*pseudoInexistant*" - "**Mot de passe**" : "*abcd" ; Je clique sur "*valider*" |
| *Résultats attendus* | Je reçois un message d'erreur m'indiquant que le nom d'utilisateur ou le mot de passe est erroné. |
| *Statut*             | ✓                                                            |

| Nom                  | 1.6 Déconnexion                                              |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S3 : Déconnexion                                             |
| *Situation*          | Je suis connecté en tant qu'utilisateur (scénario 1.2) ; Je clique sur *"Déconnexion"* dans la navigation de la page principale |
| *Résultats attendus* | Je suis redirigé vers la page principale, déconnecté. Seuls le bouton "Connexion" est affiché dans la navigation. |
| *Statut*             | ✓                                                            |

| Nom                  | 1.7 Modifier son compte                                      |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S4 : Modifier son compte                                     |
| *Situation*          | Je suis connecté en tant qu'utilisateur (scénario 1.2) ; Je clique sur *"Mon compte"* dans la navigation de la page principale ; sur la page "*Mon compte*" ; Je modifie le champs "**Mail**" par "*nouveau@gmail.com*" ; Je clique sur "*Valider*" ; Je clique sur "*Home*" ; Je re-clique sur *"Mon compte"* depuis la page principale |
| *Résultats attendus* | Le champs "**Mail**" contient : "*nouveau@gmail.com*";       |
| *Statut*             | ✓                                                            |

| Nom                  | 1.8 Supprimer son compte                                     |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S8 : Supprimer un utilisateur                                |
| *Situation*          | Je suis connecté en tant qu'utilisateur (scénario 1.2) ; Je clique sur *"Mon compte"* dans la navigation de la page principale ; Je clique sur "*Supprimer* mon compte" ; je suis redirigé vers la page d'accueil, déconnecté ; je clique sur "inscription"; j'entre mes identifiants et valide le formulaire |
| *Résultats attendus* | La connexion est refusée.                                    |
| *Statut*             | ✓                                                            |

| Nom                  | 1.9 Voir les utilisateurs                                    |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S5 : Supprimer un utilisateur ; S.7 Modifier le compte d'un utilisateur |
| *Situation*          | Je suis connecté en tant qu'administrateur (scénario 1.3); Je clique sur "*Gestion des utilisateurs*" dans la navigation de la page principale |
| *Résultats attendus* | Alors, je suis redirigé vers la page de gestion des utilisateurs, qui affiche la liste des comptes utilisateurs. |
| *Statut*             | ✓                                                            |

| Nom                  | 1.10 Modifier un compte utilisateur                          |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S7 : Modifier le compte d'un utilisateur                     |
| *Situation*          | Je suis connecté en tant qu'administrateur (scénario 1.3); Je clique sur "*Gestion des utilisateurs*" dans la navigation de la page principale ; je clique sur le bouton *edit* d'un utilisateur ; je remplace le pseudo de l'utilisateur par *pseudoModifie* |
| *Résultats attendus* | Alors, je suis redirigé vers la page de gestion des utilisateurs, qui affiche l'utilisateur avec comme pseudo *pseudoModifie* |
| *Statut*             | ✓                                                            |

| Nom                  | 1.11 Supprimer un utilisateur                                |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S8 : Supprimer un utilisateur                                |
| *Situation*          | Je suis connecté en tant qu'administrateur (scénario 1.3) ; Je clique sur la case à cocher de l'utilisateur *"PseudoTest"* dans la liste de la page "*Gestion des utilisateurs*"  (scénario 1.8) ;  Je clique sur "*Supprimer*" |
| *Résultats attendus* | La page est actualisée et l'utilisateur *"PseudoTest"* n'est plus dans la liste. |
| *Statut*             | ✓                                                            |

| Nom                  | 1.12 Ajouter un utilisateur                                  |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S6 : Créer un utilisateur                                    |
| *Situation*          | Je suis connecté en tant qu'administrateur (scénario 1.3) ; Je clique sur "*Gestion des utilisateurs*" dans la navigation de la page principale ; Je clique sur "Ajouter un utilisateur" ; Je remplis le formulaire et le valide |
| *Résultats attendus* | Alors, je suis redirigé vers la page de gestion des utilisateurs, qui affiche dans la liste des utilisateurs l'utilisateur ajouté |
| *Statut*             | ✓                                                            |



#### Scénarios  - gestion de la météo

| Nom                  | 2.1 Afficher météo d'une journée                             |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S9 : Afficher la météo détaillée                             |
| *Situation*          | Je suis connecté en tant qu'utilisateur (scénario 1.2) ; Je suis sur la page principale |
| *Résultats attendus* | Je peux voir, pour le jour actuel, l'évolution de la température au cours de la journée |
| *Statut*             | ✓                                                            |

| Nom                          | 2.2 Afficher météo d'une heure de la journée                 |
| ---------------------------- | ------------------------------------------------------------ |
| *User story*                 | S9 : Afficher la météo détaillée                             |
| *Situation*                  | Je suis connecté en tant qu'utilisateur (scénario 1.2) ; Je suis sur la page principale |
|                              | Je peux voir, pour le jour actuel, pour lune heure proche de l'heure actuelle, les informations suivantes : description de la météo, humidité, vitesse du vent et probabilité de précipitations. |
| *Résultats attendus**Statut* | ✓                                                            |

| Nom                  | 2.3 Afficher la météo résumée                                |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S10 : Afficher la météo résumée                              |
| *Situation*          | Je suis connecté en tant qu'utilisateur (scénario 1.2) ; Je clique sur "*Calendrier*"  depuis la page principale |
| *Résultats attendus* | Je peux voir, pour le jour actuel et des deux suivants, la température et le niveau d'ensoleillement du matin et du soir. |
| *Statut*             | ✓                                                            |



#### Scénarios  - gestion du calendrier

| Nom                  | 3.1 Afficher le calendrier                                   |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S11 : Afficher le calendrier                                 |
| *Situation*          | Je suis connecté en tant qu'utilisateur ; Je clique sur "*Calendrier*"  depuis la page principale |
| *Résultats attendus* | La page apparaît avec un calendrier, dont le mois affiché est le mois actuel. Le nombre de jours du mois (Mai = 31) est correct.  Les jour de la semaine du jour actuel est correct. |
| *Statut*             | ✓                                                            |

| Nom                  | 3.2 Afficher le semainier                                    |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S12 : Afficher le semainier                                  |
| *Situation*          | Je suis connecté en tant qu'utilisateur; Je clique sur "*Calendrier*"  depuis la page principale |
| *Résultats attendus* | La page apparaît avec un semainier (lundi-dimanche).         |
| *Statut*             | ✓                                                            |

| Nom                  | 3.3 Ajouter un évènement au calendrier |
| -------------------- | -------------------------------------- |
| *User story*         | S13 : Ajouter un évènement             |
| *Situation*          | [A faire]                              |
| *Résultats attendus* |                                        |
| *Statut*             | ✓                                      |

| Nom                  | 3.4 Ajouter un évènement au semainier |
| -------------------- | ------------------------------------- |
| *User story*         | S13 : Ajouter un évènement            |
| *Situation*          | [A faire]                             |
| *Résultats attendus* |                                       |
| *Statut*             | ✓                                     |

| Nom                  | 3.5 Afficher les évènements uniques pour un jour (prérequis : 3.3) |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S14 : Afficher les évènements d'une journée                  |
| *Situation*          | Je suis connecté en tant qu'utilisateur ; Je suis sur la page principale |
| *Résultats attendus* | La page apparaît avec le jour suivant (si on est mercredi -> jeudi). Je vois l'évènement nommé "Anniversaire ", assigné à l'heure : "*20:00*". |
| *Statut*             | ✓                                                            |

| Nom                  | 3.6 Afficher les évènements hebdomadaires pour un jour (prérequis : 3.4) |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S14 : Afficher les évènements d'une journée                  |
| *Situation*          | Je suis connecté en tant qu'utilisateur ; Je suis sur la page principale |
| *Résultats attendus* | La page apparaît avec le jour actuel. Je vois l'évènement nommé "Sport", assigné à l'heure : "*18:00*" |
| *Statut*             | ✓                                                            |

| Nom                  | 3.7 Supprimer un évènement                                   |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S15 : Supprimer un évènement                                 |
| *Situation*          | Je suis connecté en tant qu'utilisateur ; Je suis sur la page principale ; je clique sur "calendrier" ; Je clique sur la croix de l'évènement "Anniversaire" |
| *Résultats attendus* | L'évènement disparaît du calendrier                          |
| *Statut*             | ✓                                                            |



#### Scénarios - gestion de la garde-robe

[Nom ; Type ; Couleur ; Catégorie météo ; temp min ; temp max]

["Pull vert préféré" ;  "Pull" ;  "\#F08080" ;  "Neige" ;  -10, 20]

| Nom                  | 4.1 Ajouter un vêtement                                      |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S16 : Ajouter un vêtement                                    |
| *Situation*          | Je suis connecté en tant qu'utilisateur ; Je clique sur "*Nouveau vêtement*" sur la page principale ;  Je remplis le formulaire avec les données de test ci-dessus ; J'appuie sur "*valider*" |
| *Résultats attendus* | Je suis redirigé vers ma garde-robe. Je peux y voir, dans la catégorie "*Pulls*", le titre de mon vêtement : "*Pull vert préféré*". |
| *Statut*             | ✓                                                            |

| Nom                  | 4.2 Afficher l'image d'un vêtement (prérequis : scénario 4.1) |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S17 : Afficher les vêtements                                 |
| *Situation*          | Je suis connecté en tant qu'utilisateur ; Je clique sur "*Ma garde-robe*" sur la page principale. |
| *Résultats attendus* | Je suis redirigé vers ma garde-robe. Je peux y voir l'image d'un pull vert. |
| *Statut*             | ✓                                                            |

| Nom                  | 4.3 Afficher un tenue adaptée à la météo                     |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S19 : Afficher une recommandation de tenue                   |
| *Situation*          | Je suis connecté en tant qu'utilisateur ; J'ai ajouté les données de test ci-dessus ; Je clique sur le deuxième  lien de la navigation horizontale (bouton du jour de demain) sur la page principale |
| *Résultats attendus* | Sur la page du jour, une tenue comprenant un haut, un bas et des chaussures au minimum est affiché. La tenue est adaptée à la météo affichée : la température et l'ensoleillement affiché est compris dans les intervalles de température et catégories météo de chaque vêtement. |
| *Statut*             | ✓                                                            |

| Nom                  | 4.4 Modifier un vêtement (prérequis : scénario 4.1)          |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S20: Modifier un vêtement                                    |
| *Situation*          | Je suis connecté en tant qu'utilisateur ; Je clique "ma garde robe" ; Je cliquer sur le bouton *edit* d'un vêtement ; Je modifier son nom dans le formulaire ; je valide le formulaire |
| *Résultats attendus* | Le nom du vêtement affiché dans la garde-robe est le nouveau nom |
| *Statut*             | ✓                                                            |

| Nom                  | 4.5 Supprimer un vêtement (prérequis : scénario 4.1)         |
| -------------------- | ------------------------------------------------------------ |
| *User story*         | S21 : Supprimer un vêtement                                  |
| *Situation*          | Je clique "ma garde robe" ; Je cliquer sur le bouton *X* d'un vêtement |
| *Résultats attendus* | Le vêtement a disparu de la garde-robe                       |
| *Statut*             | ✓                                                            |





### Evolution des tests

| N° test | J0 - 03.05 | J1 - 04.05 | J2 - 05.05 | J3- 06.05 | J4- 10.05 | J5- 11.05 | J6- 12.05 | J7- 17.05 | J8- 18.05 | J9- 18.05 | J10- 29.05 |
| ------- | ---------- | ---------- | ---------- | --------- | --------- | --------- | --------- | --------- | --------- | --------- | ---------- |
| 1.1     | N.A.       | N.A.       | ✔️          | ✔️         | ✔️         | ✔️      | ✓         | ✓         | ✓         | ✓         | ✓          |
| 1.2     | N.A.       | N.A.       | ✔️          | ✔️         | ✔️         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 1.3     | N.A.       | N.A.       | ✔️          | ✔️         | ✔️         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 1.4     | N.A.       | N.A.       | ✔️          | ✔️         | ✔️         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 1.5     | N.A.       | N.A.       | ✔️          | ✔️         | ✔️         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 1.6     | N.A.       | N.A.       | ✔️          | ✔️         | ✔️         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 1.7     | N.A.       | N.A.       | ✔️          | ✔️         | ✔️         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 1.8     | N.A.       | N.A.       | ✔️          | ✔️         | ✔️         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 1.9     | N.A.       | N.A.       | ✔️          | ✔️         | ✔️         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 1.10     | N.A.       | N.A.       | ✔️          | ✔️         | ✔️         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 1.11     | N.A.       | N.A.       | ✔️          | ✔️         | ✔️         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 1.12     | N.A.       | N.A.       | ✔️          | ✔️         | ✔️         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 2.1     | N.A.       | N.A.       | N.A.       | ❌         | ❌         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 2.2     | N.A.       | N.A.       | N.A.       | ❌         | ❌         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 2.3     | N.A.       | N.A.       | N.A.       | ❌         | ❌         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 3.1     | N.A.       | N.A.       | N.A.       | ❌         | ✔️         | ✔️       | ✓         | ✓         | ✓         | ✓         | ✓          |
| 3.2     | N.A.       | N.A.       | N.A.       | N.A.      | ✔️         | ✔️         | ✓         | ✓         | ✓         | ✓         | ✓          |
| 3.3     | N.A.       | N.A.       | N.A.       | N.A.      | ✔️         | ✔️         | ✓         | ✓         | ✓         | ✓         | ✓          |
| 3.4     | N.A.       | N.A.       | N.A.       | N.A.      | ❌         | ❌         | ❌         | ✓         | ✓         | ✓         | ✓          |
| 3.5     | N.A.       | N.A.       | N.A.       | N.A.      | ❌         | ✔️         | ✔️         | ✓         | ✓         | ✓         | ✓          |
| 3.6     | N.A.       | N.A.       | N.A.       | N.A.      | ❌         | N.A.      | ❌         | ✓         | ✓         | ✓         | ✓          |
| 3.7     | N.A.       | N.A.       | N.A.       | N.A.      | ❌         | ✔️         | ✔️         | ✓         | ✓         | ✓         | ✓          |
| 3.8     | N.A.       | N.A.       | N.A.       | N.A.      | N.A.         | ❌         | ❌         | ✓         | ✓         | ✓         | ✓          |
| 4.1     | N.A.       | N.A.       | N.A.       | N.A.      | N.A.         | N.A.      | ✔️         | ✓         | ✓         | ✓         | ✓          |
| 4.2     | N.A.       | N.A.       | N.A.       | N.A.      | N.A.         | N.A.      | ✔️         | ✓         | ✓         | ✓         | ✓          |
| 4.3     | N.A.       | N.A.       | N.A.       | N.A.      | N.A.         | N.A.      | ✔️         | ✓         | ✓         | ✓         | ✓          |
| 4.4     | N.A.       | N.A.       | N.A.       | N.A.      | N.A.         | N.A.      | ✔️         | ✓         | ✓         | ✓         | ✓          |
| 4.5     | N.A.       | N.A.       | N.A.       | N.A.      | N.A.         | N.A.      | ✔️         | ✓         | ✓         | ✓         | ✓          |

N.A. : Non applicable

✗ : Echec du test

✓ = ✔️  : Succès du test





## Conclusion

Pour résumer, je vais faire un tour de ce que j'avais à faire, de ce que j'ai fait, de ce qui peut encore être fait. Ensuite, je ferai un bilan en exprimant les difficultés réalisées lors du travail, et donnerai mon ressenti personnel quant au travail.

### Que devais-je réaliser ?

Je devais donc créer une application web de recommandation vestimentaire hebdomadaire en fonction de la météo.

Pour le bon fonctionnement de ce projet, je devais réaliser, en PHP :

* Une gestion des utilisateurs, avec création, modification, et suppression par le possesseur du compte et par l'administrateur
* Une gestion de la garde robe avec ajout, modification et suppression de vêtements
* Le stockage de données les concernant dans une base de données SQL
* L'utilisation d'une API externe qui fournit des informations météorologiques
* Un affichage des informations météorologiques
* Un système de recommandation de tenue aléatoire, en fonction de la météo
* Un calendrier permettant de gérer les évènements des utilisateur et d'afficher la météo pour les 4 jours à venir



### Comment le projet peut-il évoluer ?

J'ai implémenté toutes les fonctionnalités demandées. Le projet étant maintenant fonctionnel, les améliorations pourront surtout servir à étendre les services proposés, et améliorer l'expérience utilisateur.

#### Améliorations possibles

***Amélioration de l'algorithme de recommandation***

L'algorithme de recommandation de tenue pourrait prendre en compte davantage de paramètres, comme par exemple les différences de météo au cours de la journée, et les heures des activités de la personne, afin de s'adapter à la météo des heures où elle sortira. Il pourrait également prendre en compte la couleur des vêtements pour faire des choix plus esthétiques.

***Création manuelle de tenue***

L'application pourrait permettre à l'utilisateur de créer lui-même des tenues, en choisissant un ensemble de vêtements qu'il aime porter ensemble. Ces tenues seraient alors affichées dans les recommandation, comme les tenues crées automatiquement.

***Sauvegarde des tenues pour une date précise***

L'application pourrait enregistrer une tenue recommandée pour un jour précis, afin que la même soit réaffichée, pour le même jour, la prochaine fois que l'utilisateur rouvrira la page.



### Difficultés rencontrées

La partie, dans la programmation, qui m'a semblé la plus difficile, est la gestion des dates. En effet, j'ai dû créer et traiter des dates, faire des calculs, les envoyer dans un type différent à la base de données, notamment pour créer le calendrier.

A part cette complication, que j'ai bien surmontée, je n'ai pas particulièrement eu de problèmes dans la réalisation du projet

J'ai en revanche rencontré quelques difficultés avec la documentation, puisque c'est un exercice auquel je n'étais pas très habituée, mais, en m'en tenant aux ressources que j'avais, j'ai réussi à accomplir la tâche.



### Bilan personnel

J'ai, dès le début, décidé de ne rien ajouter à mon cahier des charges, et de tout faire de la manière la plus simple possible, puisque j'ai généralement tendance à faire le contraire, et que ça me porte préjudice. J'ai pris du temps pour énumérer les tâches et estimer le temps qu'elles me prendraient, pour être sûre que j'étais large. Je suis heureuse de constater que ces efforts ont porté leurs fruits et que j'ai parfaitement réussi à organiser mon temps, sans trop d'efforts. J'en conclus que je devrais plus souvent mettre cela en place.

D'autre part, c'était agréable de travailler sur un projet qui était adapté à mes connaissances, et qui demandait quand même de la réflexion, puisqu'il y a plusieurs algorithmes que j'ai dû inventer pour réaliser les fonctionnalités. Malgré que ce soit fait dans le cadre d'un examen, je me suis plus amusée que stressée, du moins pour la partie programmation.

Et je suis plutôt contente du résultat final, qui, même s'il peut être amélioré et optimisé, est complet, fonctionnel, organisé et satisfaisant visuellement.



### Remerciements

Je tiens à remercier M. François, mon enseignant, pour son accompagnement et ses conseils, ainsi que l'ensemble des professeurs qui m'ont permis d'acquérir les connaissances nécessaires à la réalisation de mon travail, spécialement M. Bonvin, mon professeur de classe.



## Webographie



### API Météo

https://openweathermap.org/forecast5



### Graphiques

https://developers.google.com/chart/interactive/docs



### Affichage

https://getbootstrap.com/docs/5.0/getting-started/introduction/

https://getbootstrap.com/docs/4.0/examples/dashboard/#



### Autres

https://www.php.net/manual/fr/ref.datetime.php





## Glossaire

**CRUD** : Création, Lecture, Mise-à-jour, Suppression (« Create, Read, Update, Delete »).

**Backlog** : Liste de tâches priorisées représentent les fonctionnalités du programme

**User story** : Description simple et précise de l'utilisation d'une fonctionnalité