
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
VerifyAccessibility([1]);

//Récupérer le jour et l'heure de l'activité à ajouter
$idHour = FILTER_INPUT(INPUT_GET, "hour", FILTER_VALIDATE_INT);
$idDay = FILTER_INPUT(INPUT_GET, "day", FILTER_VALIDATE_INT);
$hour = GetHour($idHour);
$day = GetDay($idDay);

//Récupérer les champs du formulaire
$description = FILTER_INPUT(INPUT_POST, "description", FILTER_SANITIZE_STRING);
$save = FILTER_INPUT(INPUT_POST, "save", FILTER_SANITIZE_STRING);

if($save){
  //Ajouter l'activité à la base de données
	SaveEvent(1, $description, $hour, "", $hour, $day);

  //Rediriger vers le semainier
	header('Location: weeklyPlanner.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet WearTher">
    <meta name="author" content="Myaz Aliya">
    <title>Nouvelle activité</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- CSS propre au projet-->
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    
	  <!--Navigation principale-->
	  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 navCalendar">
      <a class="brandName" href="#"><img src="img/logo.png" alt="" class="logo">WearTher</a>
    </nav>

    <main class="ordinaryForm">
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

      <!--Formulaire d'ajout d'activité-->
      <form class="formAdd" action="<?php echo "newEventWeekly.php?day=$day&hour=".intval($hour)?>" method="POST" class="listClothes">
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
  </body>
</html>