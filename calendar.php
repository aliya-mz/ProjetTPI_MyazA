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
VerifyAccessibility([1]);

$idMonth = FILTER_INPUT(INPUT_GET, "month", FILTER_VALIDATE_INT);
$idYear = FILTER_INPUT(INPUT_GET, "year", FILTER_VALIDATE_INT);

$month = GetMonth($idMonth);
$year = GetYear($idYear);

//Récupérer l'identifiant de l'évènement à supprimer
$delete = FILTER_INPUT(INPUT_POST, "delete", FILTER_SANITIZE_STRING);

//Supprimer l'évènement sur lequel l'utilisateur a cliqué
if($delete){
	DeleteEvent($delete);
}

ExecuteMeteoProgram();
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
		<ul class="navbar-nav justify-content-center daysNav">
			<li class="nav-item">
				<a class="nav-link" href="<?php echo "calendar.php?month=".GetLastMonth($month, $year)."&year=".GetLastMonthsYear($month, $year)?>"><img class="smallIconButton" src="/img/back.png"/></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#"><?php echo GetMonthName(intval($month), true)." ".$year ?></a>
			</li>					
			<li class="nav-item">
				<a class="nav-link" href="<?php echo "calendar.php?month=".GetNextMonth($month, $year)."&year=".GetNextMonthsYear($month, $year)?>"><img class="smallIconButton" src="/img/next.png"/></a>
			</li>
		</ul>
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
                    <a class="nav-link " aria-current="page" href="index.php"><img class="mIconButton" src="img/home.png"/> Home</a>
                  </li>
                  <li class="nav-item">
                    <!--Ajouter évènement-->
					<a class="nav-link" href="newEventCalendar.php"><img class="mIconButton" src="/img/addReminder.png"/> Nouvel évènement</a>
                  </li>
                </ul>
            </div>
            </nav>        
        </div>
        </div>

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

