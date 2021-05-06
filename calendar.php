
<?php
/*
  Projet     : Suggestion de tenues en fonction de la météo
  Auteur     : Aliya Myaz
  Date       : Mai 2021
  Sujet      : Page "calendrier", où s'affiche le calendrier mois par mois, avec les évènements qui y sont inscrits, et la météo pour les trois prochains jours
*/

session_start();

include("backend/autoload.php");

//Vérifier que l'utilisateur est connecté
VerifyAccessibility(1);

//Mettre en dynamique !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$month = "05";
$year = "2021";

//Récupérer l'identifiant de l'évènement à supprimer
$delete = FILTER_INPUT(INPUT_POST, "delete", FILTER_SANITIZE_STRING);

//Supprimer l'évènement sur lequel l'utilisateur a cliqué
if($delete){
	DeleteEvent($delete);
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendrier</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css" >
  </head>
  <body>
	<main class="mainCalendar">
		<nav class="navbar navbar-expand-lg navbar-light bg-light navCalendar">
			<div class="container-fluid">
				<a class="navbar-brand" href="#">Calendrier</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarText">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<!--Retour page principale-->
					<li class="nav-item">
						<a class="nav-link " aria-current="page" href="index.php"><img class="smallIconButton" src="img/home"/></a>
					</li>
				</ul>
				<ul class="navbar-nav justify-content-center">
					<li class="nav-item">
						<a class="nav-link" href="#"><img class="smallIconButton" src="/img/back.png"/></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"><?php echo GetMonthName(intval($month), true)." ".$year ?></a>
					</li>					
					<li class="nav-item">
						<a class="nav-link" href="#"><img class="smallIconButton" src="/img/next.png"/></a>
					</li>
				</ul>			
				<span class="navbar-text">
					<!--Ajouter évènement-->
					<a class="nav-link" aria-current="page" href="newEventCalendar.php"><img class="iconButton" src="/img/addReminder.png"/></a>
				</span>
				</div>
			</div>
		</nav>

		<!--Affichage d'un mois du calendrier-->
		<form class="calendarForm" action="calendar.php" method="POST">			
			<?php
				DisplayMonthCalendar($month, $year);
			?>
		</form>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>