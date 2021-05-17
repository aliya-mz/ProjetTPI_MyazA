<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Page de gestion de la garde robe - une liste des vêtements, que l'utilisateur peut modifier peut supprimer
*/

include("backend/autoload.php");
session_start();

//Vérifier que l'utilisateur est connecté
VerifyAccessibility(1);

DeleteClothesImages();

//Récupérer l'identifiant du vêtement à supprimer
$delete = FILTER_INPUT(INPUT_POST, "delete", FILTER_SANITIZE_STRING);
$update = FILTER_INPUT(INPUT_POST, "update", FILTER_SANITIZE_STRING);

//Supprimer le vêtement sur lequel l'utilisateur a cliqué
if($delete){
  DeleteClothe($delete);
}
//Modifier le vêtement sur lequel l'utilisateur a cliqué
if($update){
  header('Location: updateClothe.php?idClothe='.$update);
  exit;
}
?>

<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet Wearther">
    <meta name="author" content="Myaz Aliya">

    <title>Home</title>

    <!-- CSS Bootstrap -->
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- CSS propre au projet-->
    <link href="css/style2.css" rel="stylesheet"> 
    <link href="css/style.css" rel="stylesheet"> 

	  <script src="backend/functions.js"></script>    
  </head>

  <body>
    <!--Navigation principale-->
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 mainNav">
      <a class="brandName" href="#"><img src="img/logo.png" alt="" class="logo">Wearther</a>
      <span class="pageTitle">Garde-robe</span>
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
                  <li class="nav-item">
                    <a class="nav-link" href="addClothe.php"><img class="mIconButton" src="img/plus.png"/></a>
                  </li>
                </ul>
            </div>
            </nav>        
        </div>
        </div>

		  <main>
        <form action="manageClothes.php" method="POST" class="listClothes">
        <?PHP
          //Afficher la liste des vêtements
          DisplayClothesList();
         ?>
        </form>
     </main>     
    
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>

