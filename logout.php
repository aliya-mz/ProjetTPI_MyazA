<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Page de déconnexion
*/

include("backend/autoload.php");

session_start();

//Détruire la session
session_destroy();
$_SESSION = array();

//Rediriger vers la page d'accueil
header('Location: index.php');
exit;