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
VerifyAccessibility(0);

//récupérer les données du formulaire
$login = FILTER_INPUT(INPUT_POST, "login", FILTER_SANITIZE_STRING);
$password = FILTER_INPUT(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$connexion = FILTER_INPUT(INPUT_POST, "connexion", FILTER_SANITIZE_STRING);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" >
  </head>
  <body>
    <nav class="navAjouter">
      <td><a class="lienBouton boutonHome" href="index.php"><img src="img/home.png"/></a></td>
    </nav>
    <main>
    <form class="formAdd" action="" method="POST">
      <table>
        <tr>
          <td colspan="2"><input type="text" name="login" value="" placeholder="Pseudo"></td>
        </tr>
        <tr>
          <td colspan="2"><input type="password" name="password" value="" placeholder="Mot de passe"></td>
        </tr>
        <tr>
          <?php
          if($connexion){
            //si les champs sont remplis
            if($login && $password){
              ConnectUser($login, $password);
            }
          }
          ?>
          <td colspan="2"><button class="btnCreateIdea" type="submit" name="connexion" value="connexion">Connexion</button></td>
        </tr>
        <tr>
          <td colspan="2"><a href="signin.php">Je n'ai pas encore de compte</a></td>
        </tr>
      </table>
    </form>
  </main>
  </body>
</html>
