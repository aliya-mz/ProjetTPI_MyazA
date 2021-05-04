<?php
/*
  Projet     :
  Date       : Novembre/décembre 2020
  Auteur     : Aliya Myaz
  Sujet      : Page d'accueil du projet
*/

/*
session_start();
include("backend/autoload.php");

$categorie = FILTER_INPUT(INPUT_POST, "categorie", FILTER_SANITIZE_STRING);
*/
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css" >
  </head>
  <body>
  <!--Barre de navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <div class="container-fluid">
		<a class="navbar-brand" href="#">Home</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarText">
		  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<!--Lien page actuelle-->
			<li class="nav-item">
			  <a class="nav-link active" aria-current="page" href="#">Météo</a>
			</li>
			<!--Lien caldenrier-->
			<li class="nav-item">
			  <a class="nav-link" href="#">Calendrier</a>
			</li>
			<!--Liste déroulante gestion de la garde-robe-->
			<li class="nav-item dropdown">
			  <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				Garde-robe
			  </a>
			  <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
				<li><a class="dropdown-item" href="#">Ajouter des vêtements</a></li>
				<li><a class="dropdown-item" href="#">Voir mes vêtements</a></li>
				<li><a class="dropdown-item" href="#">Vêtements de la semaine</a></li>
			  </ul>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#">Deconnexion</a>
			</li>
		  </ul>
		  <span class="navbar-text">
		  </span>
		</div>
	  </div>
	</nav>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>