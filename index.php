<?php
/*
  Projet     : Suggestion de tenues en fonction de la météo
  Auteur     : Aliya Myaz
  Date       : Mai 2021
  Sujet      : Page de formulaire pour ajouter un un vêtement dans la garde-robe
*/

session_start();

include("backend/autoload.php");

//$_SESSION["jourAffichage"] = [idJour]; (entre 0 et 4 ; default = 0)
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
  	<!--Navigation principale-->
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
			  <a class="nav-link active" aria-current="page" href="#">Home</a>
			</li>

			<?php 
			//Afficher la barre de navigation en fonction du rôle de l'utilisateur
				ShowNavByRole();
			?>
			
			
		  </ul>
		  <span class="navbar-text">
			Organise ta journée
		  </span>
		</div>
	  </div>
	</nav>

	<!--Navigation entre les jours de la semaine-->
	<ul class="nav justify-content-end">
		<li class="nav-item">
			<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Lundi</a>
		</li>
		<li class="nav-item">
			<a class="nav-link active" aria-current="page" href="#">Mardi</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#">Mercredi</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#">Jeudi</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#">Vendredi</a>
		</li>
	</ul>

	<!--Affichage journalier-->
	<main>
		
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>