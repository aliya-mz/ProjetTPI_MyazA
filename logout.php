<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Page de déconnexion
*/

include("backend/autoload.php");
session_start();

//détruire la session
session_destroy();
$_SESSION = array();

//retourner sur la page d'accueil
header('Location: index.php');
exit;