<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Page de gestion des utilisateurs - affiche une liste des utilisateurs, dans laquelle l'administrateur peut les supprimer
*/

include("backend/autoload.php");
session_start();

//Vérifier que l'utilisateur est déconnecté
VerifyAccessibility(2);


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" >
  </head>
  <body>
    <nav class="navAjouter">
      <td><a class="lienBouton boutonHome" href="index.php"><img src="img/home.png"/></a></td>
    </nav>
    <main>
    <form class="formAdd" action="" method="POST">
      <table>
       <?PHP
        //Affichage des utilisateurs
       ?>
      </table>
    </form>
  </main>
  </body>
</html>
