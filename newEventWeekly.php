
<?php
/*
  Projet     : Suggestion de tenues en fonction de la météo
  Auteur     : Aliya Myaz
  Date       : Mai 2021
  Sujet      : Formulaire pour ajouter un évènement au calendrier
*/

session_start();

include("backend/autoload.php");

//Vérifier que l'utilisateur est connecté
VerifyAccessibility(1);

//Récupérer en get !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$hour = "08";
$day = "02";

//Récupérer l'identifiant de l'évènement à supprimer
$description = FILTER_INPUT(INPUT_POST, "description", FILTER_SANITIZE_STRING);
$save = FILTER_INPUT(INPUT_POST, "save", FILTER_SANITIZE_STRING);

//Ajouter l'activité hebdomadaire à la BD
if($save){
	SaveEvent(1, $description, $hour, "", $day);
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouvelle activité</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css" >
  </head>
  <body>
	<main class="mainCalendar">		
		<!--Navigation principale-->
		<nav class="navbar navbar-expand-lg navbar-light bg-light navCalendar">
			<div class="container-fluid">
				<a class="navbar-brand" href="#"><?php echo $day." à ".$hour. " h"?></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarText">
				<ul class="justify-content-right navbar-nav me-auto mb-2 mb-lg-0">
					<!--Retour page principale-->
					<li class="nav-item">
						<a class="nav-link " aria-current="page" href="index.php"><img class="smallIconButton" src="img/home.png"/></a>
					</li>
                    <!--Calendrier-->
					<li class="nav-item">
						<a class="nav-link " aria-current="page" href="calendar.php">Calendrier</a>
					</li>
                    <!--Semainier-->
					<li class="nav-item">
						<a class="nav-link " aria-current="page" href="weeklyPlanner.php">Semainier</a>
					</li>
				</ul>
				</div>
			</div>
		</nav>

		<!--Formulaire ajout d'une activité-->
        <form class="formAdd" action="newEventWeekly.php" method="POST">
      <table>
        <tr>
          <td colspan="2"><input type="text" name="description" value="" placeholder="Description de l'activité"></td>
        </tr>
        <tr>          
          <td colspan="2"><button class="btnCreateIdea" type="submit" name="save" value="save"><img class="iconButton" src="img/submit.png"/></button></td>
        </tr>
      </table>
    </form>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>