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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet Wearther">
    <meta name="author" content="Myaz Aliya">
    <title>Gestion du compte</title>
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

      <form class="formAdd" action="" method="POST" class="listClothes">
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
