<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Page de gestion des utilisateurs - affiche une liste des utilisateurs, que l'administrateur peut supprimer
*/

include("backend/autoload.php");

session_start();

//Vérifier qu'un utilisateur ou administrateur est connecté
VerifyAccessibility([1,2]);

//Récupérer l'utilisateur à modifier si ce n'est pas l'utilisateur connecté
$idUser = FILTER_INPUT(INPUT_GET, "idUser", FILTER_VALIDATE_INT);

//Récupérer les champs du formulaire
$login = FILTER_INPUT(INPUT_POST, "login", FILTER_SANITIZE_STRING);
$firstName = FILTER_INPUT(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
$lastName = FILTER_INPUT(INPUT_POST, "lastName", FILTER_SANITIZE_STRING);
$eMail = FILTER_INPUT(INPUT_POST, "eMail", FILTER_SANITIZE_STRING);
$password = FILTER_INPUT(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$validate = FILTER_INPUT(INPUT_POST, "validate", FILTER_SANITIZE_STRING);
$delete = FILTER_INPUT(INPUT_POST, "delete", FILTER_SANITIZE_STRING);

//Envoyer les modification à la base de données
if($validate){
  UpdateUser($login, $firstName, $lastName, $eMail, $password, $idUser);
}
else if($delete){
  //Supprimer l'utilisateur actuel
  DeleteUser(GetIdUser());

  //Déconnexion forcée
  header('Location: logout.php');
  exit;
}

//Récpérer les informations de l'utilisateur à modifier
if(GetUserRole()==1){
  //Si un utilisateur est connecté
  $user = GetUser();
}
else{
  //Si un administrateur est connecté
  $user = GetUserToUpdate($idUser);
}
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
          <td colspan="2"><button class="btnCreateIdea" type="submit" name="validate" value="validate">Enregistrer les modifications</button></td>
        </tr>
        <?php
          //Si un utilisateur est connecté, afficher un bouton pour lui permettre de supprimer son compte
          if(GetUserRole()==1){
            echo '<tr>
                  <td colspan="2"><button class="btnCreateIdea" type="submit" name="delete" value="delete">Supprimer mon compte</button></td>
                  </tr>';
          }
        ?>
      </table>
    </form>
  </main>
  </body>
</html>
