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

//Récupérer l'identifiant de l'utilisateur à supprimer ou modifier
$delete = FILTER_INPUT(INPUT_POST, "delete", FILTER_SANITIZE_STRING);
$modify = FILTER_INPUT(INPUT_POST, "modify", FILTER_SANITIZE_STRING);

if($delete){
  //Supprimer l'utilisateur sur lequel l'administrateur a cliqué
  DeleteUser($delete);
}
else if($modify){
  //Redirigier vers le formulaire de modification en envoyant en get l'identifiant de l'utilisateur sélectionné
  header('Location: updateUser.php?idUser='.$modify);
  exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet WearTher">
    <meta name="author" content="Myaz Aliya">
    <title>Gestion des utilisateurs</title>
    <!-- CSS Bootstrap -->
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- CSS propre au projet-->
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    <!--Navigation principale-->
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 mainNav">
      <a class="brandName" href="#"><img src="img/logo.png" alt="" class="logo">WearTher</a>
      <span class="pageTitle">Gestion des utilisateurs</span>
    </nav>

    <main role="main" class="meteoMain">
        <!--Navigation secondaire-->
        <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar mainSidebar">
            <div class="sidebar-sticky marginTop100">
                <ul class="nav flex-column">
                  <!--Retour page principale-->
                  <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="index.php"><img class="mIconButton" src="img/home.png"/></a>
                  </li>
                  <!--Création nouvel utilisateur-->
                  <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="signin.php"><img class="mIconButton" src="img/addUser.png"/></a>
                  </li>
                </ul>
            </div>
            </nav>        
        </div>
        </div>

        <form action="manageUsers.php" method="POST" class="listClothes">
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
