
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

//Mettre en dynamique !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$month = "05";
$year = "2021";

//Récupérer l'identifiant de l'évènement à supprimer
$description = FILTER_INPUT(INPUT_POST, "description", FILTER_SANITIZE_STRING);
$dateStart = FILTER_INPUT(INPUT_POST, "dateStart", FILTER_SANITIZE_STRING);
$dateEnd = FILTER_INPUT(INPUT_POST, "dateEnd", FILTER_SANITIZE_STRING);
$save = FILTER_INPUT(INPUT_POST, "save", FILTER_SANITIZE_STRING);

//Supprimer l'évènement sur lequel l'utilisateur a cliqué
if($save){
	SaveEvent(0, $description, $dateStart, $dateEnd, 0, 0);
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet Wearther">
    <meta name="author" content="Myaz Aliya">
    <title>Nouvel évènement</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- CSS propre au projet-->
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    <!--Navigation principale-->
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 navCalendar">
      <a class="brandName" href="#"><img src="img/logo.png" alt="" class="logo">Wearther</a>
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

      <form class="formAdd" action="newEventCalendar.php" method="POST" class="listClothes">
        <table>
          <tr>
            <td colspan="2"><input type="text" name="description" value="" placeholder="Description de l'évènement"></td>
          </tr>
          <tr>
          <td colspan="2"><label>Début de l'évènement</label></td>
          </tr>
          <tr>
            <td colspan="2"><input type="datetime-local" name="dateStart" value=""></td>
          </tr>
          <tr>
          <td colspan="2"> <label>Fin de l'évènement</label></td>
          </tr>
          <tr>
            <td colspan="2"><input type="datetime-local" name="dateEnd" value=""></td>
          </tr>
          <tr>          
            <td colspan="2"><button class="btnCreateIdea" type="submit" name="save" value="save"><img class="iconButton" src="img/submit.png"/></button></td>
          </tr>
        </table>
      </table>
      </form>
    </main>

	  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>