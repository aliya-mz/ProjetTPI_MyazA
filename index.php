<?php
/*
  Projet     : Suggestion de tenues en fonction de la météo
  Auteur     : Aliya Myaz
  Date       : Mai 2021
  Sujet      : Page de formulaire pour ajouter un un vêtement dans la garde-robe
*/

session_start();

include("backend/autoload.php");

//Récupérer le numéro du jour à afficher envoyé en GET
$dayToDisplay = GetDayToDisplay();

//Récupérer et enregistrer dans la session les informations météo des 5 jours à venir (se met à jour si plus de 5 minutes sont passées)
ExecuteMeteoProgram();
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script src="backend/functions.js"></script>
  </head>
  <body>
  	<!--Navigation principale-->
	<nav class="navbar navbar-expand-lg navbar-light bg-light navCalendar">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">Home</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<?php 
					//Afficher la barre de navigation en fonction du rôle de l'utilisateur
					ShowNavByRole();
				?>
			</ul>
			<!--Navigation entre les jours de la semaine-->
			<ul class="navbar-nav justify-content-center">
				<?php 
					//Afficher la barre de navigation en fonction du rôle de l'utilisateur
					ShowDaysNav();
				?>				
			</ul>
		</div>
	</nav>

	<!--Affichage journalier-->
	<main>
		<form>
		<?php
			//Affiche les informations météo et complémentaires du jour sélectionné
			DisplayDayMeteo($dayToDisplay);
		?>
		</form>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>