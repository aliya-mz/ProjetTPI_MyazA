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

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Garde-robe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css" >
  </head>
  <body>
    <!--Navigation principale-->
		<nav class="navbar navbar-expand-lg navbar-light bg-light navCalendar">
			<div class="container-fluid">
				<a class="navbar-brand" href="#">Garde-robe</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
        <ul class="navbar-nav justify-content-center">
          <!--Retour page principale-->
					<li class="nav-item">
						<a class="nav-link " aria-current="page" href="index.php"><img class="smallIconButton" src="img/home.png"/></a>
					</li>
		  	</ul>
				</div>
			</div>
		</nav>
    <main>
    <form action="manageClothes.php" method="POST">
      <main class="listClothes">
       <?PHP
        //Afficher la liste des vêtements
        DisplayClothesList();
       ?>
      </main>
    </form>
  </main>
  </body>
</html>
