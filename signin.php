<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Page d'inscription - formulaire pour créer un nouveau compte
*/

include("backend/autoload.php");

session_start();

//Vérifier que l'utilisateur est déconnecté ou que c'est un administrateur
VerifyAccessibility([0, 2]);

//récupérer les données du formulaire
$login = FILTER_INPUT(INPUT_POST, "login", FILTER_SANITIZE_STRING);
$firstName = FILTER_INPUT(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
$lastName = FILTER_INPUT(INPUT_POST, "lastName", FILTER_SANITIZE_STRING);
$eMail = FILTER_INPUT(INPUT_POST, "eMail", FILTER_SANITIZE_STRING);
$password = FILTER_INPUT(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$enregistrer = FILTER_INPUT(INPUT_POST, "enregistrer", FILTER_SANITIZE_STRING);

if($enregistrer){
  //Si tous les paramètres ont bien été entrés
  if($login && $eMail && $password){
    //Enregistrer l'utilisateur dans la base de données
    SignUserIn($login, $firstName, $lastName, $eMail, $password);
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet WearTher">
    <meta name="author" content="Myaz Aliya">
    <title>Inscription</title>
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
                    <a class="nav-link " aria-current="page" href="index.php"><img class="mIconButton" src="img/home.png"/>Home</a>
                  </li>
                </ul>
            </div>
            </nav>        
        </div>
        </div>

      <!--Formulaire d'ajout d'utilisateur-->
      <form class="formAdd" action="" method="POST" class="listClothes">
        <table>
          <tr>
            <td colspan="2"><input type="text" name="login" value="" placeholder="Pseudo"></td>
          </tr>
          <tr>
            <td colspan="2"><input type="email" name="eMail" value="" placeholder="Email"></td>
          </tr>
          <tr>
            <td colspan="2"><input type="text" name="lastName" value="" placeholder="Nom"></td>
          </tr>
          <tr>
            <td colspan="2"><input type="text" name="firstName" value="" placeholder="Prenom"></td>
          </tr>
          <tr>
            <td colspan="2"><input type="password" name="password" value="" placeholder="Mot de passe"></td>
          </tr>
          <tr>
            <td colspan="2"><button class="btnCreateIdea" type="submit" name="enregistrer" value="enregistrer">Inscription</button></td>
          </tr>
        </table>
      </form>
    </main>
  </body>
</html>
