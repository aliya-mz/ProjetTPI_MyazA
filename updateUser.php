<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Page de gestion des utilisateurs - affiche une liste des utilisateurs, que l'administrateur peut supprimer
*/

include("backend/autoload.php");

session_start();

//Vérifier que l'administrateur est connecté
VerifyAccessibility(1);

//Récupérer les champs du formulaire
$login = FILTER_INPUT(INPUT_POST, "login", FILTER_SANITIZE_STRING);
$firstName = FILTER_INPUT(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
$lastName = FILTER_INPUT(INPUT_POST, "lastName", FILTER_SANITIZE_STRING);
$eMail = FILTER_INPUT(INPUT_POST, "eMail", FILTER_SANITIZE_STRING);
$password = FILTER_INPUT(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$enregistrer = FILTER_INPUT(INPUT_POST, "enregistrer", FILTER_SANITIZE_STRING);

//Envoyer les modification à la base de données
if($enregistrer){
    UpdateUser($login, $firstName, $lastName, $eMail, $password);
}

//Récpérer les informations de l'utilisateur à modifier
$user = GetUser();
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
          <td colspan="2"><input type="text" name="login" value="<?php echo $user["login"] ?>" placeholder="Pseudo"></td>
        </tr>
        <tr>
          <td colspan="2"><input type="email" name="eMail" value="<?php echo $user["eMail"] ?>" placeholder="Email"></td>
        </tr>
        <tr>
          <td colspan="2"><input type="text" name="lastName" value="<?php echo $user["lastName"] ?>" placeholder="Nom"></td>
        </tr>
        <tr>
          <td colspan="2"><input type="text" name="firstName" value="<?php echo $user["firstName"] ?>" placeholder="Prenom"></td>
        </tr>
        <tr>
          <td colspan="2"><input type="password" name="password" value="" placeholder="Nouveau mot de passe"></td>
        </tr>
        <tr>
          <td colspan="2"><button class="btnCreateIdea" type="submit" name="enregistrer" value="enregistrer">Enregistrer les modifications</button></td>
        </tr>
      </table>
    </form>
  </main>
  </body>
</html>
