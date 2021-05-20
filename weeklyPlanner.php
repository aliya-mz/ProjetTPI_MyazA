<?php
/*
  Projet     : Suggestion de tenues en fonction de la météo
  Auteur     : Aliya Myaz
  Date       : Mai 2021
  Sujet      : Page "semainier", où s'affiche le semainier, avec les évènements qui y sont inscrits
*/

session_start();

include("backend/autoload.php");

//Vérifier que l'utilisateur est connecté
VerifyAccessibility([1]);

//Récupérer l'identifiant de l'évènement à supprimer
$delete = FILTER_INPUT(INPUT_POST, "delete", FILTER_SANITIZE_STRING);

//Supprimer l'évènement sur lequel l'utilisateur a cliqué
if($delete){
	DeleteEvent($delete);
}
?>

<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet Wearther">
    <meta name="author" content="Myaz Aliya">

    <title>Calendrier</title>

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- CSS propre au projet-->
    <link href="css/style2.css" rel="stylesheet"> 
    <link href="css/style.css" rel="stylesheet"> 

    <script src="backend/functions.js"></script>    
  </head>

  <body>
    <!--Navigation principale-->
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 navCalendar">
      <a class="brandName" href="#"><img src="img/logo.png" alt="" class="logo">Wearther</a>
    </nav>

    <main class="mainCalendar">
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
                </ul>
            </div>
            </nav>        
        </div>
        </div>

        <!--Affichage du semainier-->
		<form class="calendarForm weekPlanner" action="weeklyPlanner.php" method="POST">			
			<?php
				DisplayWeekPlanner();
			?>
		</form>
     </main>     
    
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>

