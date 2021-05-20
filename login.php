<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Page de connexion - formulaire pour se connecter à un compte existant
*/

include("backend/autoload.php");
session_start();

//Vérifier que l'utilisateur est déconnecté
VerifyAccessibility([0]);

//récupérer les données du formulaire
$login = FILTER_INPUT(INPUT_POST, "login", FILTER_SANITIZE_STRING);
$password = FILTER_INPUT(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$connexion = FILTER_INPUT(INPUT_POST, "connexion", FILTER_SANITIZE_STRING);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet WearTher">
    <meta name="author" content="Myaz Aliya">
    <title>Connexion</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- CSS propre au projet-->
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    <!--Navigation principale-->
    <nav class="navbar navbar-light sticky-top bg-light flex-md-nowrap p-0 navCalendar">
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

      <!--Formulaire de connexion-->
      <form class="formAdd" action="" method="POST" class="listClothes">
      <table>
        <tr>
          <td colspan="2"><input type="text" name="login" value="" placeholder="Pseudo"></td>
        </tr>
        <tr>
          <td colspan="2"><input type="password" name="password" value="" placeholder="Mot de passe"></td>
        </tr>
        <tr>
          <td colspan="2"><button class="btnCreateIdea" type="submit" name="connexion" value="connexion">Connexion</button></td>
        </tr>
        <tr>
          <td colspan="2" class="error">
            <?php
              if($connexion){
                //si tous les champs sont remplis
                if($login && $password){
                  //Essayer de connecter l'utilisateur, envoyer un message d'erreur si échec
                  ConnectUser($login, $password);
                }
              }
            ?>
          </td>
        </tr>
        <tr>
          <td colspan="2"><a href="signin.php">Je n'ai pas encore de compte</a></td>
        </tr>
      </table>
      </form>
  </main>
  </body>
</html>
