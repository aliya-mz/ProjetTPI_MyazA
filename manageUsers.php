<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Page de gestion des utilisateurs - affiche une liste des utilisateurs, que l'administrateur peut supprimer
*/

include("backend/autoload.php");
session_start();

//Vérifier que l'administrateur est connecté
VerifyAccessibility(2);

//Récupérer l'identifiant de l'utilisateurs à supprimer
$delete = FILTER_INPUT(INPUT_POST, "delete", FILTER_SANITIZE_STRING);

//Supprimer l'utilisateur sur lequel l'administrateur a cliqué
if($delete){
  DeleteUser($delete);
}
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
    <form class="formAdd" action="manageUsers.php" method="POST">
      <table class="usersList">
       <?PHP
        //Afficher la liste des utilisateurs
        ShowListUsers();
       ?>
      </table>
    </form>
  </main>
  </body>
</html>
