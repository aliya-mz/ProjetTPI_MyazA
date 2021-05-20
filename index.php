<?php
/*
  Projet     : Suggestion de tenues en fonction de la météo
  Auteur     : Aliya Myaz
  Date       : Mai 2021
  Sujet      : Page principale de l'application
*/

session_start();

include("backend/autoload.php");

//Supprimer les images de vêtements enregistrées dans le dossier
DeleteClothesImages();

//Récupérer le numéro du jour à afficher envoyé en GET
$dayToDisplay = GetDayToDisplay();
//Heure dont les détails doivent être affichés
$hourToDisplay = GetHourToDisplay();

//Récupérer et enregistrer dans la session les informations météo des 5 jours à venir, s'il faut les afficher
if(GetUserRole()==1){
	ExecuteMeteoProgram();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet WearTher">
    <meta name="author" content="Myaz Aliya">
    <title>Home</title>    
    <!-- CSS Bootstrap -->
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- CSS propre au projet-->
    <link href="css/style.css" rel="stylesheet"> 
    <!-- JS pour l'affichage des graphiques météo-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	  <script src="backend/functions.js"></script>    
  </head>

  <body>
    <!--Navigation principale-->
    <nav class="navbar navbar-light sticky-top bg-light flex-md-nowrap p-0 mainNav">
      <a class="brandName" href="#"><img src="img/logo.png" alt="" class="logo">WearTher</a>
      <ul class="navbar-nav px-3 horizontalNav">
        <li class="nav-item navbar-nav justify-content-center">
            <?php 
              //Afficher la navigation entre les jours de la semaine
              ShowDaysNav();
            ?>
        </li>
      </ul>
    </nav>

    <main role="main" class="meteoMain">
        <!--Navigation secondaire-->
        <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar mainSidebar">
              <div class="sidebar-sticky marginTop100">
                <?php 
                    //Afficher la navigation du site en fonction du rôle de l'utilisateur
                    ShowNavByRole();
                ?>        
              </div>
            </nav>        
        </div>
        </div>

		    <?php
          //Affiche la météo, la tenue recommandée et les évènements de la journée, si l'utilisateur est connecté
          if(GetUserRole()==1){
            DisplayDayMeteo($dayToDisplay, $hourToDisplay);            
          }
        ?>
     </main>     
  </body>
</html>
