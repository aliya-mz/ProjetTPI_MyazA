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
VerifyAccessibility([2]);

//Récupérer l'identifiant de l'utilisateurs à supprimer
$delete = FILTER_INPUT(INPUT_POST, "delete", FILTER_SANITIZE_STRING);
$modify = FILTER_INPUT(INPUT_POST, "modify", FILTER_SANITIZE_STRING);

//Supprimer l'utilisateur sur lequel l'administrateur a cliqué
if($delete){
  DeleteUser($delete);
}
else if($modify){
  //Redirigier vers le formulaire de modification
  header('Location: updateUser.php?idUser='.$modify);
  exit;
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
      <a class="lienBouton boutonHome" href="index.php"><img src="img/home.png"/></a>
      <a class="lienBouton boutonHome" href="signin.php">Ajouter un utilisateur</a>
    </nav>
    <main class="bg-light">
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
