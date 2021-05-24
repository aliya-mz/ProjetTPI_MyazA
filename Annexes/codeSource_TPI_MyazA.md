```php+HTML
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

```

```php+HTML
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
```

```php+HTML
<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Page de gestion du compte
*/

include("backend/autoload.php");

session_start();

//Vérifier qu'un utilisateur ou un administrateur est connecté
VerifyAccessibility([1,2]);

//Récupérer l'utilisateur à modifier si c'est l'administrateur qui est connecté
$idUser = FILTER_INPUT(INPUT_GET, "idUser", FILTER_VALIDATE_INT);

//Récupérer les champs du formulaire
$login = FILTER_INPUT(INPUT_POST, "login", FILTER_SANITIZE_STRING);
$firstName = FILTER_INPUT(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
$lastName = FILTER_INPUT(INPUT_POST, "lastName", FILTER_SANITIZE_STRING);
$eMail = FILTER_INPUT(INPUT_POST, "eMail", FILTER_SANITIZE_STRING);
$password = FILTER_INPUT(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$validate = FILTER_INPUT(INPUT_POST, "validate", FILTER_SANITIZE_STRING);
$delete = FILTER_INPUT(INPUT_POST, "delete", FILTER_SANITIZE_STRING);

if($validate){
  //Envoyer les modification à la base de données
  UpdateUser($login, $firstName, $lastName, $eMail, $password, $idUser);
  //Retourner sur la page principale
  header('Location: index.php');
  exit;
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
  //Si un utilisateur est connecté, récupérer ses informations
  $user = GetUser();
}
else{
  //Si un administrateur est connecté, récupérer les informations de l'utilisateur qu'il a sélectionné
  $user = GetUserToUpdate($idUser);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet WearTher">
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

      <!--Formulaire de modification du compte-->
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
```

```php+HTML
<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Formulaire qui gère la modification des vêtements de l'utilisateur
*/

session_start();

include("backend/autoload.php");

//Vérifier qu'un utilisateur est connecté
VerifyAccessibility([1]);

//Récupérer les informations du vêtement à modifier
$idClothe = FILTER_INPUT(INPUT_GET, "idClothe", FILTER_VALIDATE_INT);
$clothe = GetClothe($idClothe);

//Récupérer les types de vêtements dans la BD (pantalon, veste, etc...)
$categories = readCategories();
//Récupérer les catégories météo prédéfinies dans la BD (pluie, neige, etc...)
$weathers = readWeathers();

//récupérer les champs du formulaire
$name = FILTER_INPUT(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$idCategory = FILTER_INPUT(INPUT_POST, "categoryClothe", FILTER_VALIDATE_INT);
$idWeather = FILTER_INPUT(INPUT_POST, "groupWeather", FILTER_VALIDATE_INT);
$minTemp = FILTER_INPUT(INPUT_POST, "minTemp", FILTER_VALIDATE_INT);
$maxTemp = FILTER_INPUT(INPUT_POST, "maxTemp", FILTER_VALIDATE_INT);
$color = FILTER_INPUT(INPUT_POST, "color", FILTER_SANITIZE_STRING);
$validate = FILTER_INPUT(INPUT_POST, "validate", FILTER_SANITIZE_STRING);

//Lorsque le formulaire est envoyé
if($validate){
  //Enregistrer le vêtement dans la BD
  UpdateClotheById($idClothe, $name, $idCategory, $idWeather, $color, $minTemp, $maxTemp);

  //Retourner sur la garde-robe
  header('Location: manageClothes.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet WearTher">
    <meta name="author" content="Myaz Aliya">
    <title>Modification vêtement</title>
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

      <!--Formulaire de modification de vêtement-->
      <form class="formAdd" action="" method="POST" class="listClothes">
        <table class="formClothes">
          <tr>
            <td colspan="2"><div class="contenantSvg"> <?php DisplayClothe($clothe); ?> </div></td>
          </tr>
          <tr>
            <td colspan="2"><input type="text" name="name" value="<?php echo $clothe["name"];?>" placeholder="Nom (ex : pull vert préféré)" required></input</td>
          </tr>      
          <tr>
            <td colspan="2"> <label>Sélectionner une couleur</label> </td>
          </tr>
          <tr>
            <td colspan="2"> <input type="color" name="color" value="<?php echo $clothe["color"];?>" required> </td>
          </tr>
          <tr>
            <td colspan="2"> <label>Type de vêtement</label> </td>
          </tr>
          <tr>
            <td colspan="2"> <?php CategoriesToSelect($categories, $clothe["idCategory"]) ?> </td>
          </tr>  
          <tr>
            <td colspan="2"> <label>Température minimum</label> </td>
          </tr>        
          <tr>
            <td colspan="2"> <input type="number" name="minTemp" value="<?php echo $clothe["tempMin"];?>" required> </td>
          </tr>
          <tr>
            <td colspan="2"> <label>Température maximum</label> </td>
          </tr>         
          <tr>
            <td colspan="2"> <input type="number" name="maxTemp" value="<?php echo $clothe["tempMax"];?>" required> </td>
          </tr>         
          <tr>
            <td colspan="2"> <label>Météo</label> </td>
          </tr>
          <tr>
            <td colspan="2"> <?php WeathersToSelect($weathers, $clothe["idWeather"]) ?> </td>
          </tr>
          <tr>
            <td colspan="2"><button class="btnCreateIdea" type="submit" name="validate" value="validate">Enregistrer</button></td>
          </tr>
        </table>
      </form>  
    </main>
  </body>
</html>
```

```php+HTML

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
```

```php+HTML

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

//Récupérer les informations du formulaire sur l'évènement à ajouter
$description = FILTER_INPUT(INPUT_POST, "description", FILTER_SANITIZE_STRING);
$dateStart = FILTER_INPUT(INPUT_POST, "dateStart", FILTER_SANITIZE_STRING);
$save = FILTER_INPUT(INPUT_POST, "save", FILTER_SANITIZE_STRING);

if($save){
  //Enregistrer l'évènement dans la base de données
	SaveEvent(0, $description, $dateStart, $dateStart, 0, 0);

  //Rediriger vers le calendrier
  header('Location: calendar.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet WearTher">
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

      <!--Formulaire d'ajout d'évènement-->
      <form class="formAdd" action="newEventCalendar.php" method="POST" class="listClothes">
        <table>
          <tr>
            <td colspan="2"><input type="text" name="description" value="" placeholder="Description de l'évènement"></td>
          </tr>
          <tr>
          <td colspan="2"><label>Date l'évènement</label></td>
          </tr>
          <tr>
            <td colspan="2"><input type="datetime-local" name="dateStart" value=""></td>
          </tr>
          <tr>          
            <td colspan="2"><button class="btnCreateIdea" type="submit" name="save" value="save"><img class="iconButton" src="img/submit.png"/></button></td>
          </tr>
        </table>
      </table>
      </form>
    </main>
  </body>
</html>
```

```php+HTML
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
VerifyAccessibility([2]);

//Récupérer l'identifiant de l'utilisateur à supprimer ou modifier
$delete = FILTER_INPUT(INPUT_POST, "delete", FILTER_SANITIZE_STRING);
$modify = FILTER_INPUT(INPUT_POST, "modify", FILTER_SANITIZE_STRING);

if($delete){
  //Supprimer l'utilisateur sur lequel l'administrateur a cliqué
  DeleteUser($delete);
}
else if($modify){
  //Redirigier vers le formulaire de modification en envoyant en get l'identifiant de l'utilisateur sélectionné
  header('Location: updateUser.php?idUser='.$modify);
  exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet WearTher">
    <meta name="author" content="Myaz Aliya">
    <title>Gestion des utilisateurs</title>
    <!-- CSS Bootstrap -->
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- CSS propre au projet-->
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    <!--Navigation principale-->
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 mainNav">
      <a class="brandName" href="#"><img src="img/logo.png" alt="" class="logo">WearTher</a>
      <span class="pageTitle">Gestion des utilisateurs</span>
    </nav>

    <main role="main" class="meteoMain">
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
                  <!--Création nouvel utilisateur-->
                  <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="signin.php"><img class="mIconButton" src="img/addUser.png"/></a>
                  </li>
                </ul>
            </div>
            </nav>        
        </div>
        </div>

        <form action="manageUsers.php" method="POST" class="listClothes">
          <table class="usersList">
          <?PHP
            //Afficher la liste des utilisateurs
            ShowListUsers();
          ?>
        </table>
      </form>
    </main>     
  </body>
</html>
```

```php+HTML
<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Page de gestion de la garde robe - une liste des vêtements, que l'utilisateur peut modifier peut supprimer
*/

include("backend/autoload.php");
session_start();

//Vérifier que l'utilisateur est connecté
VerifyAccessibility([1]);

DeleteClothesImages();

//Récupérer l'identifiant du vêtement à supprimer
$delete = FILTER_INPUT(INPUT_POST, "delete", FILTER_SANITIZE_STRING);
$update = FILTER_INPUT(INPUT_POST, "update", FILTER_SANITIZE_STRING);

//Supprimer le vêtement sur lequel l'utilisateur a cliqué
if($delete){
  DeleteClothe($delete);
}
//Modifier le vêtement sur lequel l'utilisateur a cliqué
if($update){
  header('Location: updateClothe.php?idClothe='.$update);
  exit;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet WearTher">
    <meta name="author" content="Myaz Aliya">
    <title>Gestion de la garde-robe</title>
    <!-- CSS Bootstrap -->
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- CSS propre au projet-->
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>
    <!--Navigation principale-->
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 mainNav">
      <a class="brandName" href="#"><img src="img/logo.png" alt="" class="logo">WearTher</a>
      <span class="pageTitle">Garde-robe</span>
    </nav>

    <main role="main" class="meteoMain">
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
                  <li class="nav-item">
                    <a class="nav-link" href="addClothe.php"><img class="mIconButton" src="img/plus.png"/></a>
                  </li>
                </ul>
            </div>
            </nav>        
        </div>
        </div>

        <form action="manageClothes.php" method="POST" class="listClothes">
        <?PHP
          //Afficher la liste des vêtements
          DisplayClothesList();
         ?>
        </form>
    </main>
  </body>
</html>
```

```php+HTML
<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Formulaire qui gère l'ajout de vêtements à la garde-robe de l'utilisateur
*/

session_start();

include("backend/autoload.php");

//Vérifier qu'un utilisateur est connecté
VerifyAccessibility([1]);

//Récupérer les types de vêtements dans la BD (pantalon, veste, etc...)
$categories = GetCategories();
//Récupérer les catégories météo prédéfinies dans la BD (pluie, neige, etc...)
$weathers = GetWeathers();

//récupérer les champs du formulaire
$name = FILTER_INPUT(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$idCategory = FILTER_INPUT(INPUT_POST, "categoryClothe", FILTER_VALIDATE_INT);
$idWeather = FILTER_INPUT(INPUT_POST, "groupWeather", FILTER_VALIDATE_INT);
$minTemp = FILTER_INPUT(INPUT_POST, "minTemp", FILTER_VALIDATE_INT);
$maxTemp = FILTER_INPUT(INPUT_POST, "maxTemp", FILTER_VALIDATE_INT);
$color = FILTER_INPUT(INPUT_POST, "color", FILTER_SANITIZE_STRING);
$validate = FILTER_INPUT(INPUT_POST, "validate", FILTER_SANITIZE_STRING);

//Lorsque le formulaire est envoyé
if($validate){
  //Enregistrer le vêtement dans la BD
  SaveClothe($name, $idCategory, $idWeather, $color, $minTemp, $maxTemp);

  //Rediriger vers la garde-robe
  header('Location: manageClothes.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet WearTher">
    <meta name="author" content="Myaz Aliya">
    <title>Nouveau vêtement</title>
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

      <form class="formAdd" action="" method="POST" class="listClothes">
        <table class="formClothes">
          <tr>
            <td colspan="2"> <label>Entrez un nom distinctif</label> </td>
          </tr>  
          <tr>
            <td colspan="2"><input type="text" name="name" value="<?php echo $name;?>" placeholder="Nom (ex : pull vert préféré)" required><?php echo $name;?></input</td>
          </tr>
          <tr>
            <td colspan="2"> <label>Sélectionner une couleur</label> </td>
          </tr>  
          <tr>
            <td colspan="2"> <input type="color" name="color" value="<?php echo $color;?>" required> </td>
          </tr>   
          <tr>
            <td colspan="2"> <label>Température minimum</label> </td>
          </tr>        
          <tr>
            <td colspan="2"> <input type="number" name="minTemp" value="<?php echo $minTemp;?>" required> </td>
          </tr>
          <tr>
            <td colspan="2"> <label>Température maximum</label> </td>
          </tr>          
          <tr>
            <td colspan="2"> <input type="number" name="maxTemp" value="<?php echo $maxTemp;?>" required> </td>
          </tr>
          <tr>
            <td colspan="2"> <label>Type de vêtement</label> </td>
          </tr>
          <tr>
            <td colspan="2"> <?php CategoriesToSelect($categories, $idCategory) ?> </td>
          </tr>
          <tr>
            <td colspan="2"> <label>Météo correpsondante</label> </td>
          </tr>
          <tr>
            <td colspan="2"> <?php WeathersToSelect($weathers, $idWeather) ?> </td>
          </tr>
          <tr>
            <td colspan="2"><button class="btnCreateIdea" type="submit" name="validate" value="enregistrer">Enregistrer</button></td>
          </tr>
        </table>
      </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>
```

```php+HTML
<?php
/*
  Projet     : Suggestion de tenues en fonction de la météo
  Auteur     : Aliya Myaz
  Date       : Mai 2021
  Sujet      : Page "semainier", où s'affiche le semainier, avec les évènements qui y sont inscrits
*/

session_start();

include("backend/autoload.php");

//Vérifier que l'utilisateur est connecté
VerifyAccessibility([1]);

//Récupérer l'identifiant de l'évènement à supprimer
$delete = FILTER_INPUT(INPUT_POST, "delete", FILTER_SANITIZE_STRING);

//Supprimer l'évènement sur lequel l'utilisateur a cliqué
if($delete){
	DeleteEvent($delete);
}
?>

<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet WearTher">
    <meta name="author" content="Myaz Aliya">
    <title>Semainier</title>
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

    <main class="mainCalendar">
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

      <!--Affichage du semainier-->
      <form class="calendarForm weekPlanner" action="weeklyPlanner.php" method="POST">			
        <?php
          DisplayWeekPlanner();
        ?>
      </form>
     </main>     
  </body>
</html>
```

```php+HTML
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

//Récupérer le mois et l'année à afficher
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

//Récupérer et enregistrer les informations météo
ExecuteMeteoProgram();
?>

<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projet WearTher">
    <meta name="author" content="Myaz Aliya">
    <title>Calendrier</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- CSS propre au projet-->
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>
    <!--Navigation principale-->
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 navCalendar">
      <a class="brandName" href="#"><img src="img/logo.png" alt="" class="logo">WearTher</a>
      <!--Navigation entre les mois du calendrier-->		
      <ul class="navbar-nav justify-content-center daysNav">
        <!--Reculer d'un mois-->		
        <li class="nav-item">
          <a class="nav-link" href="<?php echo "calendar.php?month=".GetLastMonth($month, $year)."&year=".GetLastMonthsYear($month, $year)?>"><img class="smallIconButton" src="/img/back.png"/></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo GetMonthName(intval($month), true)." ".$year ?></a>
        </li>
        <!--Avancer d'un mois-->				
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
                    <a class="nav-link " aria-current="page" href="index.php"><img class="mIconButton" src="img/home.png"/></a>
                  </li>
                  <li class="nav-item">
                    <!--Ajouter évènement-->
					          <a class="nav-link" href="newEventCalendar.php"><img class="mIconButton" src="/img/addReminder.png"/>Nouvel évènement</a>
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
  </body>
</html>
```

```php+HTML
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
```

```php+HTML
<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Page de déconnexion
*/

include("backend/autoload.php");

session_start();

//Détruire la session
session_destroy();
$_SESSION = array();

//Rediriger vers la page d'accueil
header('Location: index.php');
exit;
```

```php
<?PHP
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Fonctions du projet
*/

//Gestion des utilisateurs - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//Message d'erreur de connexion
define("ERROR_MESSAGE", "Votre pseudo ou mot de passe est erroné");


//Retourner l'identifiant de l'utilisateur connecté
function GetIdUser(){
  //Si l'utilsiateur est définit dans la session
  if(isset($_SESSION["idUser"])){
    //Retourner son identifiant
    return $_SESSION["idUser"];
  }
  else{
    return false;
  }  
}

//Définit l'utilisateur connecté
function SetIdUser($idUser){
  $_SESSION["idUser"] = $idUser;
}

//Retourner l'identifiant de l'utilisateur sélectionné par l'administrateur et envoyé en GET
function GetIdUserToUpdate($idUser){
  $user = "";
  //Récupérer l'utilisateur envoyé en paramètre
  if(isset($idUser)){
    if(GetUser($idUser)!=null){
      $user = $idUser;
    }
    //Si le paramètre est erroné, quitter
    else{
      header('Location: manageUsers.php');
      exit;
    }
  }
  //Si le paramètre n'existe pas, quitter
  else{
    header('Location: manageUsers.php');
    exit;
  }
  return $user;
}

//Retourner l'utilisateur sélectionné par l'administrateur et envoyé en GET
function GetUserToUpdate($idUser){
  return readUserById(GetIdUserToUpdate($idUser));
}

//Retourner l'identifiant du rôle de l'utilisateur
function GetUserRole(){
  //Si l'utilisateur est définti dans la session
  if(isset($_SESSION["idUser"])){
    //Récupérer l'utilisateur pour récupérer son rôle
    return ReadUserById($_SESSION["idUser"])["idRole"];
  }
  else{
    return 0;
  }
}

//Retourner toutes les informations de l'utilisateur
function GetUser(){
  return readUserById(GetIdUser());
}

//Vérifier que l'utilisateur (déconnecté, utilisateur ou administrateur) a le droit d'accéder à la page
function VerifyAccessibility($acceptedRoles){
  //Si l'un des rôles envoyés en paramètre est connecté, rester sur la page
  $accepted = false;
  foreach($acceptedRoles as $acceptedRole){
    if(GetUserRole()==$acceptedRole){
      $accepted = true;
    }
  }
  if(!$accepted){
    header('Location: index.php');
    exit;
  }
}

//Vérifier que l'utilisateur existe et que son mot de passe est correct pour le connecter
function ConnectUser($login, $password){
  //Vérifier qu'un utilisateur avec ce pseudo existe
  if(ReadUserByUsername($login)){
    //Récupérer l'utilisateur
    $user = ReadUserByUsername($login);

    //Vérifier le mot de passe crypté avec le mot de passe entré
    if(password_verify($password, $user["password"])){

      //enregister l'utilisateur dans la session
      SetIdUser($user["idUser"]);

      //rediriger vers la page d'accueil
      header('Location: index.php');
      exit;
    }
    else{
      //Message d'erreur
      echo ERROR_MESSAGE;
    }
  }
  else{
    //Message d'erreur
    echo ERROR_MESSAGE;
  }
}

//Inscrire l'utilisateur, en l'ajoutant dans la BD avec son mot de passe hashé
function SignUserIn($login, $firstName, $lastName, $eMail, $password){
  //hasher le mot de passe
  $password = password_hash($password, PASSWORD_DEFAULT);

  //ajouter l'utilisateur dans la BD
  createUser($login, $firstName, $lastName, $eMail, $password);

  //Si c'est un administrateur, rediriger vers la gestion des utilisateurs
  if(GetUserRole()==2){
    header('Location: manageUsers.php');
    exit;
  }
  //rediriger vers la page d'accueil
  header('Location: index.php');
  exit;
}

//Afficher une barre de navigation pour la page principale, contenant les liens adaptés au rôle de l'utilisateur
function ShowNavByRole(){
  //Si l'utilisateur est déconnecté, afficher le lien pour se connecter
  if(GetUserRole()==0){
    echo '<ul class="nav flex-column">';
    //Connexion
    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"login.php\">Connexion</a></li>";
    //Inscription
    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"signin.php\">Inscription</li>";
    echo '</ul>';
  }
  //Si c'est un utilisateur connecté, afficher les liens vers le parties calendrier, garde-robe et compte, et la déconnexion
  else if(GetUserRole()==1){
  echo '<ul class="nav flex-column">';
  //Modifier les informations du compte
  echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"updateUser.php\"><img class=\"smallIconButton\" src=\"img/account.png\"/></a></li>";
  //Déconnexion
  echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"logout.php\"><img class=\"smallIconButton\" src=\"img/logout.png\"/></a></li>";
  echo '</ul>';
  //Gestion des vêtements
  echo'<h6 class="sidebar-heading d-flex justify-content-start align-items-center px-3 mt-4 mb-1 text-muted marginElements">
        <span><img src="img/clothe.png" alt="" class="mIconButton"></span> <span>Garde-robe</span>
       </h6>
       <ul class="nav flex-column mb-2">
        <li class="nav-item"><a class="nav-link" href="manageClothes.php">Voir ma garde-robe</a></li>
        <li class="nav-item"><a class="nav-link" href="addClothe.php">Ajouter un vêtement</a></li>
       </ul>';
  echo'<h6 class="sidebar-heading d-flex justify-content-start align-items-center px-3 mt-4 mb-1 text-muted marginElements">
        <span><img src="img/calendar.png" alt="" class="mIconButton"></span> <span>Calendrier</span>
       </h6>
       <ul class="nav flex-column mb-2">
        <li class="nav-item"><a class="nav-link" href="calendar.php">Calendrier</a></li>
        <li class="nav-item"><a class="nav-link" href="weeklyPlanner.php">Semainier</a></li>
       </ul>';
  }
  //Si c'est un administrateur, afficher le lien vers la gestion des utilisateurs et la déconnexion
  else if(GetUserRole()==2){
    echo '<ul class="nav flex-column">';
    //Déconnexion
    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"logout.php\"><img class=\"smallIconButton\" src=\"img/logout.png\"/></a></li>";
    //Gestion des utilisateurs
    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"manageUsers.php\">Gestion des utilisateurs</li>";
    echo '</ul>';
  }
}

//Afficher une liste des utilisateurs, avec un bouton supprimer et modifier pour chacun
function ShowListUsers(){
  //Récupérer tous les utilisateurs dont le rôle est "utilisateur"
  $users = readUsers();
  //Afficher chaque utilisateur
  foreach($users as $user){
    echo "<tr>";     
    echo "<td> <div class=\"userBubble eventBubble\">";
    //Informations sur l'utilisateur
    echo "<div><p class=\"bubbleTitle\">".$user["login"]."</p><p>".$user["firstName"]." ".$user["lastName"]."</p></div>";    

    //Boutons supprimer et modifier
    echo "<div class=\"bubbleButtons\"><button type=\"submit\" name=\"delete\" value=\"".$user["idUser"]."\"/><img src=\"img/delete.png\"></button>
          <button type=\"submit\" name=\"modify\" value=\"".$user["idUser"]."\"/><img src=\"img/update.png\"></button></div>
    </div></td>";

    echo "</tr>";
  }
}

//Supprime un utilisateur de la base de données en fonction de son identifiant
function DeleteUser($idUser){
  DeleteUserById($idUser);
}

//Met à jour les informations de l'utilisateur en appelant le CRUD
function UpdateUser($login, $firstName, $lastName, $eMail, $password, $idUserToUpdate){
  //Si l'utilisateur a changé son mot de passer
  if(strlen($password) > 0){
    //Hasher le nouveau mot de passe
    $password = password_hash($password, PASSWORD_DEFAULT);

    //Envoyer les informations modifiées à la base de données
    if(GetUserRole()==1){
      UpdateUserByIdWithPassword(GetIdUser(), $login, $firstName, $lastName, $eMail, $password);
    }
    else{
      UpdateUserByIdWithPassword($idUserToUpdate, $login, $firstName, $lastName, $eMail, $password);
    }

    echo $password;
  }
  //Sinon, juste envoyer les nouvelles informations à la base de données
  else{
    if(GetUserRole()==1){
      UpdateUserById(GetIdUser(), $login, $firstName, $lastName, $eMail);
    }
    else{
      UpdateUserById($idUserToUpdate, $login, $firstName, $lastName, $eMail);
    }
  }
}






//Gestion du calendrier- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//Générer le calendrier et semainier ____________________________________________________________________________

//Retourner le numéro du jour dont les détails doivent être affichés
function GetDay($idDay){
  $day = "";
  //Récupérer le jour envoyé en paramètre
  if(isset($idDay)){
    if(intval($idDay) <= 6 && intval($idDay) >= 0){
      $day = $idDay;
    }
    //Si le paramètre est erroné, quitter
    else{
      header('Location: weeklyPlanner.php');
      exit;
    }
  }
  //Si le paramètre n'existe pas, quitter
  else{
    header('Location: weeklyPlanner.php');
      exit;
  }
  return $day;
}

//Retourner le numéro de l'heure du jour dont plus de détails doivent être affichés
function GetHour($idHour){
  $hour = "";
  //Récupérer le mois envoyé en paramètre
  if(isset($idHour)){
    if(intval($idHour) <= 20 && intval($idHour) >= 6){
      $hour = intval($idHour);
      if($hour<10){
        $hour = "0".$hour;
      }
    }
    //Si le paramètre est erroné, quitter
    else{
      header('Location: weeklyPlanner.php');
      exit;
    }
  }
  //Si le paramètre n'existe pas, quitter
  else{
    header('Location: weeklyPlanner.php');
    exit;
  }
  return $hour;
}

//Retourner l'année du mois à affiche dans le calendrier
function GetYear($idYear){
  $year = "";
  //Récupérer l'année envoyée en paramètre
  if(isset($idYear)){
    if(intval($idYear) <= 2050 && intval($idYear) >= 1970){
      $year = intval($idYear);
    }
    //Si le paramètre est erroné, afficher l'année actuelle
    else{
      $year=date("Y");
    }
  }
  //Si le paramètre n'existe pas, l'année affichée est l'année actuelle
  else{
    $year=date("Y");
  }
  return $year;
}

//Retourner le mois à affiche dans le calendrier
function GetMonth($idMonth){
  $month = "";
  //Récupérer le mois envoyé en paramètre
  if(isset($idMonth)){
    if(intval($idMonth) <= 12 && intval($idMonth) >= 1){
      $month = intval($idMonth);
      if($month<10){
        $month = "0".$month;
      }
    }
    //Si le paramètre est erroné, le mois affiché est le mois actuel
    else{
      $month=date("m");
    }
  }
  //Si le paramètre n'existe pas, le mois affiché est le mois actuel
  else{
    $month=date("m");
  }
  return $month;
}

//Calculer le mois précédent
function GetLastMonth($theMonth, $theYear){
  //Si l'année en paramètre est suppérieure à la limite
  if(intval($theYear) >= 1970){
    //Si on est au premier mois de l'année
    if(intval($theMonth) <= 1){
      //Passer au dernier mois
      $theMonth = 12;
    }
    else{
      //Sinon, passer au mois précédent
      $theMonth -= 1;
    }
  }  
  return $theMonth;
}

//Calculer le mois suivant
function GetNextMonth($theMonth, $theYear){
  //Si l'année est inférieure à la limite
  if(intval($theYear) <= 2050){
    //Si on est au dernier mois de l'année
    if(intval($theMonth) >= 12){
      //Passer au premier
      $theMonth = 1;
    }
    else{
      //Sinon, avancer d'un mois
      $theMonth += 1;
    }
  }  
  return $theMonth;
}

//Calculer l'année du mois précédent
function GetLastMonthsYear($theMonth, $theYear){
  if(intval($theMonth) == 1 && intval($theYear) > 1970){
    $theYear = intval($theYear) - 1;
  }
  return $theYear;
}

//Calculer l'année du mois suivant
function GetNextMonthsYear($theMonth, $theYear){
  if(intval($theMonth) == 12 && intval($theYear) <= 2050){
    $theYear = intval($theYear) + 1;
  }
  return $theYear;
}

//Générer un tableau à deux dimensions contenant tous les jours à afficher dans le calendrier pour le mois X de l'année X
function GetCalendarDays($month, $year){
  $days = [];

  //Créer la date du 1er du mois donné en paramètre
  $timeZone = 'Europe/Zurich';
  date_default_timezone_set($timeZone);
  $dateSrc = $year."-".$month."-01 00:00";

  //Déterminer quel jour de la semaine est à cette date
  $date = date('Y-m-d', strtotime($dateSrc));
  $date = new DateTime($date);
  $weekDay = $date->format("w");

  //Déterminer la date du début du calendrier pour que la semaine de départ soit complète
  $daysToAdd = $weekDay-1;
  //Recommencer la semaine depuis la fin
  if($daysToAdd == -1){
    $daysToAdd = 6;
  }
  //Créer la date en soustrayant ces jours à la date actuelle
  $dateStart = date_create($year.'-'.$month.'-01');
  date_sub($dateStart, date_interval_create_from_date_string($daysToAdd.' days'));

  //Parcourir tous les jours pour classer leurs dates dans un tableau de semaines
  //Pour chaque semainer
  for($w = 0; $w < 6; $w++){
    $week = [];
    //Pour chaque jour
    for($d = 0; $d < 7; $d++){
      //Ajouter un jour à la date
      $day = $dateStart;
      if(!($w==$d && $w==0))
        date_add($day, date_interval_create_from_date_string('1 days'));

        //Ajouter le jour à la semaine
      array_push($week, date_format($day, 'Y-m-d'));
    }
    //Ajouter la semaine au mois
    array_push($days, $week);
  }
  return $days;
}

//Générer un tableau à deux dimensions contenant toutes les heures à afficher dans le semainier
function GetWeekHours(){
  $hours = [];
  //Pour chaque jour
  for($d = 0; $d < 7; $d++){
    $day = [];
    //Ajouter chaque heure de 6h à 20h
    for($h = 6; $h <= 20; $h++){
      array_push($day, $h);
    }
    array_push($hours, $day);
  }
  return $hours;
}

//Gestion des évènements_________________________________________________________________________________________

//Récupérer tous les évènements ajoutés au calendrier, compris dans les jours du mois actuellement affiché
function GetEventsBetween($dateStart, $dateEnd){
  //Transformer les dates de début et de fin en timestamp dans le format de la base de données
  $timestampStart = DateToTimestamp($dateStart);
  $timestampEnd = DateToTimestamp($dateEnd);

  //Rechercher dans la base de données
  $events = readEventsByTime($timestampStart, $timestampEnd, GetIdUser());

  //Placer les évènements dans un tableau dont les clés sont les dates
  $dates = [];
  foreach($events as $event){
    array_push($dates, $event["theDate"]);
  }
  $classifiedEvents = array_fill_keys($dates, []);
  $countEvents = 0;
  foreach($classifiedEvents as $date => $classifiedEvent){
    array_push($classifiedEvents[$date], $events[$countEvents]);
    $countEvents += 1;
  }

  return $classifiedEvents;
}

//Récupérer tous les évènements ajoutés au semainier
function GetEventsWeekPlanner(){  
  //Rechercher dans la base de données les évènements réccurents (hebdomadaires)
  $events = readWeekPlannerEvents(GetIdUser());

  //Placer les évènements dans un tableau dont les clés sont l'heure plus le jour de la semaine
  $hours = [];
  foreach($events as $event){
    array_push($hours, (intval(explode(":",$event["theHour"])[0]).":".intval(explode(".",$event["theDate"])[0])));
  }
  $classifiedEvents = array_fill_keys($hours, []);
  $countEvents = 0;
  foreach($classifiedEvents as $hour => $classifiedEvent){
    $classifiedEvents[$hour] = $events[$countEvents];
    $countEvents += 1;
  }

  return $classifiedEvents;
}

//Enregistrer un évènement dans la base de données
function SaveEvent($isReccurent, $description, $dateStart, $dateEnd, $hour, $day){
  //Si c'est un évènement unique
  if($isReccurent == 0){
    //Formater les dates en timestamp
    $dateStart = DateToTimestamp($dateStart);
    $dateEnd = DateToTimestamp($dateEnd);
  }
  //Si c'est une activité hebdomadaire
  else{
    //Formater les dates en timestamp
    $dateStart = HourToTimestamp($hour, $day);
    $dateEnd = $dateStart;

    //Supprimer l'activité qui occupe déjà cet horaire, s'il y en a une
    DeleteEventByTime($dateStart, GetIdUser());
  }

  //Ajouter l'évènement
  createEvent($description, $dateStart, $dateEnd, $isReccurent, GetIdUser());
}

//Supprimer un évènement
function DeleteEvent($idEvent){
  //Appelle la fonction du CRUD
  DeleteEventById($idEvent);
}

//Formater la date pour la convertir en timestant mySql pour les évènements uniques
function DateToTimestamp($date){
  //Récupérer les élémente de la date
  $hour = date('H', strtotime($date));
  $minute = date('i', strtotime($date));
  $month = date('m', strtotime($date));
  $day = date('d', strtotime($date));
  $year = date('Y', strtotime($date));

  //Transformer les dates en timestamp mySQL
  $timestamp = date ('Y-m-d H:i:s', mktime ($hour, $minute, 0, $month, $day, $year));

  return $timestamp;
}

//Formater la date pour la convertir en un timestamp mySql pour les évènements hebdomadaires
function HourToTimestamp($hour, $day){
  //Transformer les dates en timestamp mySQL, avec pour seuls paramètres l'heure et le jour de la semaine, mis à la place du jour du mois
  $timestamp = date ('Y-m-d H:i:s', mktime (intval($hour), 0, 0, 1, intval($day), 2000));
  return $timestamp;
}

//Gérer l'affichage______________________________________________________________________________________________

//Afficher le calendrier sous forme de tableau
function DisplayMonthCalendar($month, $year){
  //Récupérer les jours et les évènements à afficher pour ce mois
  $days = GetCalendarDays($month, $year);
  $events = GetEventsBetween($days[0][0], $days[count($days)-1][count($days[0])-1]);

  //Afficher le tableau représentant le calendrier
  echo "<table class=\"table table-bordered table-light calendarTable\">";
  echo "<thead><tr>
          <th scope=\"col\">Lun.</th> <th scope=\"col\">Mar.</th> <th scope=\"col\">Mer.</th> <th scope=\"col\">Jeu.</th> <th scope=\"col\">Ven</th> <th scope=\"col\">Sam.</th> <th scope=\"col\">Dim.</th>
          </tr></thead>";
  //Afficher les jours
  echo "<tbody>";
  $lastDay = "";
  for($w = 0; $w < 6; $w++){
    echo "<tr>";

    for($d = 0; $d < 7; $d++){
      //Récupérer la date du jour qui correspond à la case
      $day = $days[$w][$d];

      //Griser la case si elle n'appartient pas au mois en cours
      if(explode("-", $day)[1]!=$month){
        echo "<td class=\"inactiveDay\">";
      }
      else{
        echo "<td class=\"activeDay\">";
      }

      //Afficher le jour du mois
      echo explode("-", $day)[2];

      //Afficher le nouveau mois
      if($lastDay != ""){
        if(explode("-", $day)[1]!=explode("-", $lastDay)[1]){
          echo " ".GetMonthName(intval(explode("-", $day)[1]), false);
        }
      }      

      //Si le jour est le jour actuel ou l'un des deux jours suivants, afficher la météo
      $actualDate = date_create(date('Y-m-d'));     
      if($day == date_add($actualDate, date_interval_create_from_date_string('0 days'))->format('Y-m-d')){
        DisplayMeteoSummary(0);
      }
      else if($day == date_add($actualDate, date_interval_create_from_date_string('1 days'))->format('Y-m-d')){
        DisplayMeteoSummary(1);
      }
      else if($day == date_add($actualDate, date_interval_create_from_date_string('1 days'))->format('Y-m-d')){
        DisplayMeteoSummary(2);
      }
      else if($day == date_add($actualDate, date_interval_create_from_date_string('1 days'))->format('Y-m-d')){
        DisplayMeteoSummary(3);
      }

      //Si des évènements existent à cette date, les afficher
      echo "<div class=\"eventsCase\">";
      if(array_key_exists($day, $events)){
        foreach($events[$day] as $event)
        DisplayEvent($event, true);
      }
      echo "</div>";

      echo "</td>";
      $lastDay = $day;
    }

    echo "</tr>";    
  }
  echo "</tbody>";
  echo "</table>";
}

//Afficher le semainier sous forme de tableau
function DisplayWeekPlanner(){
  //Récupérer les informations à afficher
  $hours = GetWeekHours();
  $events = GetEventsWeekPlanner();

  //Afficher le tableau du semainier
  echo "<table class=\"table table-bordered table-light calendarTable\">";
  echo "<thead><tr>
        <th scope=\"col\" class=\"rowTitle\">Heure</th><th scope=\"col\">Lun.</th> <th scope=\"col\">Mar.</th> <th scope=\"col\">Mer.</th> <th scope=\"col\">Jeu.</th> <th scope=\"col\">Ven</th> <th scope=\"col\">Sam.</th> <th scope=\"col\">Dim.</th>
        </tr></thead>";

  echo "<tbody>";
  for($row = 0; $row < count($hours[0]); $row++){
    //Afficher les heures
    echo "<tr>";
    $hour = $hours[0][$row];
    echo "<td class=\"rowTitle\">".$hour."h</td>";
    for($col = 0; $col < count($hours); $col++){
      echo "<td>";
      //Bouton ajouter une activité à cette heure
      echo '<a href="newEventWeekly.php?day='.($col+1).'&hour='.$hours[$col][$row].'" class="addEventHour"><img class="smallIconButton" src="/img/addReminder.png"/></a>';

      //Si des évènements existent à cette date, les afficher
      //créer un identifiant avec l'heure et le jour de la semaine
      $indexCase=$hours[$col][$row].":".($col+1);
      echo "<div class=\"eventsCase\">";
      if(array_key_exists($indexCase, $events)){
        DisplayEvent($events[$indexCase], false);
      }
      echo "</div>";
      echo "</td>";
    }
    echo "</tr>";    
  }

  echo "</tbody>";
  echo "</table>";
}

//Renvoyer le nom du mois en français grâce à son numéro
function GetMonthName($idMonth, $long){
  $monthLongNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
  $monthShortNames = ["Janv.", "Févr.", "Mars", "Avr.", "Mai.", "Juin", "Juill.", "Août", "Sept.", "Oct.", "Nov.", "Déc."];

  if($long){
    return $monthLongNames[$idMonth-1];
  }
  else{
    return $monthShortNames[$idMonth-1];
  }
}

//Afficher un évènement donnée
function DisplayEvent($event, $calendar){
  //Afficher les évènements, avec un bouton supprimer
  echo "<div class=\"eventBubble\">";
    if($calendar){
      echo $event["theHour"]. " ";
    }
    echo $event["description"]
        ."<button type=\"submit\" name=\"delete\" value=\"".$event["idEvent"]."\"/><img src=\"img/delete.png\"></button>
        </div>";
}






//Gestion garde-robe - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//Définir les groupes de vêtements pour pouvoir les assembler en tenues
DEFINE("CLOTHES_GROUPS", ["Haut", "Bas", "Ensemble", "Exterieur", "Chaussures"]);

//Gestion du formulaire___________________________________________________________________________________________

//Retourner l'identifiant du vêtement à modifier
function GetClothe($idClothe){
  $id = 0;
  //Récupérer le jour envoyé en paramètre
  if(isset($idClothe)){
    $id = $idClothe;
  }
  //Si le paramètre n'existe pas, quitter
  else{
    header('Location: manageClothes.php');
    exit;
  }
  //Récupérer le vêtement correspondant à l'identifiant
  $clothe = ReadClotheById($id);
  //Si le vêtement n'existe pas, quitter
  if(!array_key_exists("idClothe", $clothe)){
    header('Location: manageClothes.php');
    exit;    
  }
  //Si le vêtement n'appartient pas à l'utilisateur, quitter
  else{
    if($clothe["idUser"]!=GetIdUser()){
     // header('Location: index.php');
      //exit;
    }
  }
  return $clothe;
}

//Retourner la liste des catégories de vêtements
function GetCategories(){
  return readCategories();
}

//Retourner la catégorie correspondant à l'id
function GetCategory($idCategory){
  return readCategoryById($idCategory);
}

//Retourner la liste des catégories météo
function GetWeathers(){
  return readWeathers();
}

//Afficher les type de vêtements de la BD dans une liste déroulante
function CategoriesToSelect($categories, $categorySelected){
  echo "<select name=\"categoryClothe\">";
  //parcourir les types de la BD et les afficher
  foreach($categories as $category){
    //si le type est celui sélecionnée précédemment (sticky), le re-sélectionner
    if($category["idCategory"] == $categorySelected){
      echo "<option value=\"".$category["idCategory"]."\" selected>".$category["name"]."</option>";
    }
    else{
      echo "<option value=\"".$category["idCategory"]."\">".$category["name"]."</option>";
    }
  }
  echo "</select>";
}

//Afficher les catégories météo de la BD dans une liste déroulante
function WeathersToSelect($weathers, $weatherSelected){
  echo "<select name=\"groupWeather\">";
  //Parcourir les catégories de la BD et les afficher
  foreach($weathers as $weather){
    //si la catégorie est celle sélecionnée précédemment (sticky), la re-sélectionner
    if($weather["idWeather"] == $weatherSelected){
      echo "<option value=\"".$weather["idWeather"]."\" selected>".$weather["name"]."</option>";
    }
    else{
      echo "<option value=\"".$weather["idWeather"]."\">".$weather["name"]."</option>";
    }
  }
  echo "</select>";
}

//Enregistrer un vêtement dans la BD
function SaveClothe($name, $idCategory, $idWeather, $color, $tempMin, $tempsMax){
   //Insert dans la BD
   CreateClothe($name, $idCategory, $idWeather, $color, $tempMin, $tempsMax, GetIdUser());
}

//Supprimer le vêtement correspondant à un identifiant
function DeleteClothe($idClothe){
  DeleteClotheById($idClothe);
}

//Création de tenues______________________________________________________________________________________________

//Messages d'erreur pour les tenues incomplètes
DEFINE("MAIN_ERROR", "Vous feriez bien d'obtenir des vêtements");
DEFINE("COAT_ERROR", "Vous feriez bien d'obtenir un manteau");
DEFINE("SHOES_ERROR", "Vous feriez bien d'obtenir des chaussures");

//Générer une tenue complète en fonction de la météo
function GenerateDress($temperatures, $weathers){
  //Récupérer un tableau de listes pour chaque groupe de vêtement, correspondant à la météo du jour
  $clothesForMeteo = GetClothesForMeteo($temperatures, $weathers);

  $dress = [];

  //Sélectionner aléatoirement un haut+bas ou un ensemble (Chance de tomber sur un haut par rapport à un ensemble égale à la proportionnalité de hauts dans l'ensemble des hauts et des ensembles)
  if(count($clothesForMeteo["Ensemble"])!=0 && count($clothesForMeteo["Haut"])!=0 && count($clothesForMeteo["Bas"])!=0){
    //S'il y a des hauts et des ensemble qui correspondent à la météo
    if(rand(0, count($clothesForMeteo["Haut"])+count($clothesForMeteo["Ensemble"]))<count($clothesForMeteo["Ensemble"])){
      //Sélectionner un haut et un bas
      $top = $clothesForMeteo["Haut"][rand(0, count($clothesForMeteo["Haut"])-1)]["idClothe"];
      $bottom = $clothesForMeteo["Bas"][rand(0, count($clothesForMeteo["Bas"])-1)]["idClothe"];
      array_push($dress, $top);
      array_push($dress, $bottom);     
    }
    else{
      //Sélectionner un ensemble
      $both = $clothesForMeteo["Ensemble"][rand(0, count($clothesForMeteo["Ensemble"])-1)]["idClothe"];
      array_push($dress, $both);
    }
  }
  ///S'il y a uniquement des hauts qui correspondent, et qu'il y a aussi des bas, sélectionner un haut et un bas
  else if(count($clothesForMeteo["Haut"])!=0 && count($clothesForMeteo["Bas"])!=0){
    $top = $clothesForMeteo["Haut"][rand(0, count($clothesForMeteo["Haut"])-1)]["idClothe"];
    $bottom = $clothesForMeteo["Bas"][rand(0, count($clothesForMeteo["Bas"])-1)]["idClothe"];
    array_push($dress, $top);
    array_push($dress, $bottom);
  }
  //S'il y a uniquement des ensembles qui correspondent
  else if(count($clothesForMeteo["Ensemble"])!=0){    
    //Si seul un vêtement existe dans cette catégorie, le prendre
    if(count($clothesForMeteo["Ensemble"]) == 1){
      $both = $clothesForMeteo["Ensemble"][0]["idClothe"];
      array_push($dress, $both);
    }
    //Sinon, choisir aléatoirement
    else{
      $both = $clothesForMeteo["Ensemble"][rand(0, count($clothesForMeteo["Ensemble"])-1)]["idClothe"];
      array_push($dress, $both);
    }
  }
  //Si aucun ne correspond, erreur
  else{
    array_push($dress, MAIN_ERROR);
  }

  //Vérifier s'il y a des chaussures, si oui en sélectionner une paire au hasard
  if(count($clothesForMeteo["Chaussures"])!=0){
    $shoes = $clothesForMeteo["Chaussures"][rand(0, count($clothesForMeteo["Chaussures"])-1)]["idClothe"];
    array_push($dress, $shoes);
  }
  else{
    array_push($dress, SHOES_ERROR);
  }

  //Vérifier s'il y a des vestes/manteaux, si oui en sélectionner un au hasard
  if(count($clothesForMeteo["Exterieur"])!=0){
    $outwear = $clothesForMeteo["Exterieur"][rand(0, count($clothesForMeteo["Exterieur"])-1)]["idClothe"];
    array_push($dress, $outwear);
  }
  //Si n'y en a pas
  else{
    //Si le matin est passé et qu'il fait froid maintenant, erreur
    if(count($temperatures)<5){
      if($temperatures[0]<=10){
        array_push($dress, COAT_ERROR);
      }
    }
    //Sinon, s'il fait froid le matin, erreur
    else{
      if($temperatures[2]<=8 && $temperatures[3]<=10){
        array_push($dress, COAT_ERROR);
      }
    }    
  }

  //Retourner l'ensemble des vêtements de la tenue générée sous forme de tableau
  return $dress;
}

//Retourner, pour chaque groupe de vêtements (haut, bas...) une liste des vêtements adaptés à la météo
function GetClothesForMeteo($temperatures, $weathers){
  //Traiter les information météo de toute la journée pour récupérer ce qui est important à la création de la tenue

  //Faire la moyenne des température de la journée
  $minTemp = $temperatures[0];
  $maxTemp = $temperatures[0];
  $sum = 0;
  foreach($temperatures as $temperature){
    $sum += $temperature;
  }
  $temperature = round($sum / count($temperatures));

  //Récupérer les temps particuliers de la journée (neige, pluie, normal)
  $weatherPriority = false;
  foreach($weathers as $weather){
    //Il neige
    if($weather == "Snow"){
      $weatherPriority = "Neige";
    }
    //Il pleut
    else if($weather == "Rain" || $weather == "Thuderstorm"){
      if($weatherPriority != "Neige"){
        $weatherPriority = "Pluie";
      }      
    }
    //Il y a du soleil ou des nuages
    else{
      if($weatherPriority != "Neige" && $weatherPriority != "Pluie"){
        $weatherPriority = "Normal";
      }
    }
  }

  //Créer un tableau avec tous les vêtements possibles pour cette météo, classés par groupes
  $clothesForMeteo = [
    CLOTHES_GROUPS[0] => ReadClothesByMeteoAndCategorie($temperature, $weatherPriority, CLOTHES_GROUPS[0], GetIdUser()),
    CLOTHES_GROUPS[1] => ReadClothesByMeteoAndCategorie($temperature, $weatherPriority, CLOTHES_GROUPS[1], GetIdUser()),
    CLOTHES_GROUPS[2] => ReadClothesByMeteoAndCategorie($temperature, $weatherPriority, CLOTHES_GROUPS[2], GetIdUser()),
    CLOTHES_GROUPS[3] => ReadClothesByMeteoAndCategorie($temperature, $weatherPriority, CLOTHES_GROUPS[3], GetIdUser()),
    CLOTHES_GROUPS[4] => ReadClothesByMeteoAndCategorie($temperature, $weatherPriority, CLOTHES_GROUPS[4], GetIdUser())
  ];

  return $clothesForMeteo;
}

//Affichage_______________________________________________________________________________________________________

//Créer fichier à partir de vêtement BD (couleur et script SVG) avec nom correspondant à idVetement
function CreateClotheImage($idCategory, $color){
  //Créer un fichier SVG dans le dossier img
  $path = "img/clothesImg/".GenerateRandomString(10).".svg";
  $file = fopen($path, "c+b");

  //Récupérer le script du fichier dans la BD
  $script = GetCategory($idCategory)["isTemplate"];

  //Modifier la couleur par celle choisie par l'utilisateur
  $aModifier = "PLACE_COLOR";
  $script = str_replace($aModifier, $color, $script);

  //Ecrire le script créé dans le fichier
  fwrite($file, $script);

  //Fermer le fichier
  fclose($file);

  //Retourner l'adresse du fichier
  return $path;
}

//Supprimer toutes les images crées
function DeleteClothesImages(){
  $files = glob('img/clothesImg/*');
  //Parcourir tous les fichiers du répertoire et le supprimer
  foreach($files as $file){
    if(is_file($file))
      unlink($file);
  }
}

//Afficher une tenue complète adaptée à la météo
function DisplayDress($temperature, $weather){
  //Récupérer une tenue adaptée à la météo
  $dress = GenerateDress($temperature, $weather);

  //Afficher chaque élément de la tenue
  foreach($dress as $idClothe){
    //Si un vêtement a été trouvé pour ce groupe, l'afficher
    if(is_numeric($idClothe))
      DisplayClothe(GetClothe($idClothe));
    //Sinon, afficher un message d'erreur
    else
      DisplayEmptyClothe($idClothe);
  }
}

//Afficher tous les vêtements de l'utilisateur
function DisplayClothesList(){
  //Récupérer les vêtements de l'utilisateur
  $clothes = ReadClothesByUser(GetIdUser());

  //Tous les afficher
  foreach($clothes as $clothe){
    DisplayClotheWithControls($clothe);
  }
}

//Afficher un vêtement
function DisplayClothe($clothe){
  //Créer une l'image correspondant à la catégorie et à la couleur du vêtement, et récupérer son chemin
  $imagePath = CreateClotheImage($clothe["idCategory"], $clothe["color"]);

  //Afficher le nom et l'image du vêtement
  echo "<div class=\"eventBubble clothesBubble\">"
        ."<div class=\"displayClothe\">"
        .$clothe["name"]
        ."<img class=\"clotheImage\" src=\"".$imagePath."\"/>
        </div>
        </div>";
}

//Afficher un vêtement avec les contrôles (modifier et supprimer)
function DisplayClotheWithControls($clothe){
  //Créer une l'image correspondant à la catégorie et à la couleur du vêtement, et récupérer son chemin
  $imagePath = CreateClotheImage($clothe["idCategory"], $clothe["color"]);

  //Afficher le nome t l'image du vêtements, ainsi que les boutons qui permettent de le supprimer ou de le modifier
  echo "<div class=\"eventBubble clothesBubble\">"
        ."<div class=\"displayClothe\">"
        .$clothe["name"]
        ."<img class=\"clotheImage\" src=\"".$imagePath."\"/>
        </div>
        <div class=\"displayButtons\"><button type=\"submit\" name=\"delete\" value=\"".$clothe["idClothe"]."\"/><img src=\"img/delete.png\"></button>
        <button type=\"submit\" name=\"update\" value=\"".$clothe["idClothe"]."\"/><img src=\"img/update.png\"></button></div>
        </div>";
}

//Afficher une case vide avec un message d'erreur pour un vêtement nécessaire non existant
function DisplayEmptyClothe($error){
  echo "<div class=\"eventBubble clothesBubble text-center\">"
        ."<div class=\"displayClothe\">"
        .$error
        ."</div>
        </div>";
}

//Générer un string aléatoire pour nommer l'image du vêtement
function GenerateRandomString($length) {
  //Caractères pouvant être utilisés dans le string
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);

  //Générer un string aléatoire d'une longueur définie
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}






//Gestion de la météo- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
define("KEY_IP", "d4fb62a10090dc46eff900d5da5eeca7");

//Fonctions pour récupérer et stocker les informations________________________________________________________________

//Vérifier si la météo a déjà été récupérée grâce à l'API
function IsSetMeteo(){
  return $_SESSION["meteo"];
}

//Enregistrer les information météo organisées dans la session
function SetMeteo($meteo){
  $_SESSION["meteo"] = $meteo;
}

//Récupérer les information météo enregsitrées dans la session
function GetMeteo(){
  return $_SESSION["meteo"];
}

//Récupérer, trier, organiser et enregistrer les informations météo récupérées grâce à l'API
function ExecuteMeteoProgram(){
    //Récupérer les informations météo des 5 jours à venir
    $meteoInfos = GetMeteoInfos();

    //Les classer pour pouvoir les enregistrer
    $ClassedInfos = ClassifyMeteoInfos($meteoInfos);

    //Ranger les informations dans des jours
    $ClassedInfos = ClassifyInfosByDay($ClassedInfos);

    //Les enregistrer dans un objet
    $week = new week($ClassedInfos);

    //Sauvegarder l'objet dans la session
    SetMeteo($week);
}

//Récupérer les informations météo des 5 jours à venir grâce à l'API
function GetMeteoInfos(){
    //Appel de l'API
    $url = "http://api.openweathermap.org/data/2.5/forecast?q=Geneve&appid=".KEY_IP."&lang=fr";
    $result = file_get_contents($url);

    //Récupérer les informations json en php
    $meteoInfos = json_decode($result, true);

    return $meteoInfos;
}

//Trier les information météo nécessaires
function ClassifyMeteoInfos($meteoInfos){
  //Nombre de jours de la prévision
  $nbDays = 5;
  //Nombre d'enregistrements par jour
  $nbDayRecording = 8;

  $recordingsInfos = [];

  //Parcourir tous les enregistrements météo de la semaine
  for($i = 0; $i < ($nbDayRecording * $nbDays); $i++){
      //Enregistrer sous forme de dictionnaire les informations météo récupérées par l'API
      $recordingInfos = $array = [
          //Date de l'enregistrement
          "date" => explode(" ",$meteoInfos["list"][$i]["dt_txt"])[0],
          //Heure de l'enregistrement
          "heure" => explode(":", explode(" ",$meteoInfos["list"][$i]["dt_txt"])[1])[0],            
          //Récupérer la temperature
          "temperature" => round($meteoInfos["list"][$i]["main"]["temp"]-273.15),
          //Le groupe météorologique(pluie, neige...)
          "groupeMeteorologique" => $meteoInfos["list"][$i]["weather"][0]["main"],
          //La description de la météo
          "descriptionMeteo" => $meteoInfos["list"][$i]["weather"][0]["description"],
          //l'icone météo
          "icone" => $meteoInfos["list"][$i]["weather"][0]["icon"],
          //L'humidité
          "humidite" => $meteoInfos["list"][$i]["main"]["humidity"],
          //La vitesse du vent
          "vitesseVent" => ($meteoInfos["list"][$i]["wind"]["speed"]*10),
          //La probabilité de pécipitations
          "probPrecipitations" => ($meteoInfos["list"][$i]["pop"]*100),
      ];

      //Ajouter le relevé météo au tableau général
      array_push($recordingsInfos, $recordingInfos);
  }

  return $recordingsInfos;
}

//Organiser les informations météo par jours dans une classe "semaine"
function ClassifyInfosByDay($meteoInfos){
    //Nombre d'heures entre chaque enregistrement
    $intervalEnreg = 3;

    $daysInfos = [];

    //Récupérer la première heure disponible de la journée (les heures déjà passées ne sont pas données)
    $firstHour = $meteoInfos[0]["heure"];

    //Calculer le nombre d'enregistrements météo restants pour la journée (une journée commence à minuit)
    $lastingHours = ((24-$firstHour)/$intervalEnreg);

    //Supprimer les enregistrements du 6ème jour incomplet
    $lastDayHours = 8-$lastingHours;
    if($lastDayHours<8){
        $a = (count($meteoInfos) - $lastDayHours);
        for($i = count($meteoInfos)-1; $i >= $a; $i--){
            unset($meteoInfos[$i]);
        }
    }

    //Créer un tableau contenant les jours, contenant eux-mêmes les enregistrements
    $countRecordings = 0;
    //parcourir les jours
    for($i = 0; $i < 5; $i++){
        $dayRecording = [];
        //Tant que l'enregistrement suivant a la même date que le précédent
        do{
            //L'ajouter dans le jour actuel
            array_push($dayRecording, $meteoInfos[$countRecordings]);
            //Incrémenter le compteur d'enregistrements
            $countRecordings += 1;
        }
        while($meteoInfos[$countRecordings-1]["date"] == $meteoInfos[$countRecordings]["date"] && $countRecordings < count($meteoInfos)-1);

        //ajouter la journée dans le tableau des journées
        array_push($daysInfos, $dayRecording);
    }

    return $daysInfos;
}

//Fonctions d'affichage - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//Afficher les liens vers les 5 jours à venir
function ShowDaysNav(){
  //Si un utilisateur est connecté
  if(GetUserRole()==1){
    //Afficher les liens vers les informations de chacun des cinq jours à venir
    for($i = 0; $i < 5; $i++){
      //Mettre en évidence le jour actuellement affiché
      if($i == GetDayToDisplay()){
        echo '<li class="nav-item">
            <a class="nav-link active displayBlock activeDay" aria-current="page" href="index.php?numDay='.$i.'">'.GetWeekDayName($i).'</a>
            </li>';
      }
      else{
        echo '<li class="nav-item">
            <a class="nav-link displayBlock inactiveDay" href="index.php?numDay='.$i.'">'.GetWeekDayName($i).'</a>
            </li>';
      }    
    }
  }  
}

//Retourner le jour dont les informations doivent être affichée, parmi les cinq jours à venir
function GetDayToDisplay(){
  //Récupérer le jour envoyé en paramètre
  if(isset($_GET["numDay"])){
    $dayToDisplay = $_GET["numDay"];
  }
  //Si le paramètre n'existe pas, aller par défaut au jour actuel
  else{
    $dayToDisplay = 0;
  }
  //Si le paramètre est erroné, aller par défaut au jour actuel
  if(($dayToDisplay < 0) || ($dayToDisplay > 4)){
    $dayToDisplay = 0;
  }
  return $dayToDisplay;
}

function GetHourToDisplay(){
  //Récupérer le jour envoyé en paramètre
  if(isset($_GET["numHour"])){
    $hourToDisplay = $_GET["numHour"];
  }
  //Si le paramètre n'existe pas, aller par défaut au jour actuel
  else{
    $hourToDisplay = 0;
  }
  //Si le paramètre est erroné, aller par défaut à l'heure actuele
  if(($hourToDisplay < 0) || ($hourToDisplay > 7)){
    $hourToDisplay = 0;
  }
  return $hourToDisplay;
}

//Afficher les informations détaillées pour la journée sélectionnée
function DisplayDayMeteo($numDay, $numHour){
    //Récupérer les informations météo du jour sélectionné
    $day = GetMeteo()->GetDay($numDay);

    echo "</div>";
    echo "<div class=\"meteoTable\">";1

    //Températures
    echo "<div class=\"meteoBubble\" id=".$day->GetDate()."> ";   
    $hours = [];
    $temperatures = [];
    $weathers = [];
    //Parcourir les informations de touts les enregistrements de la journée, et récupérer les heures et les températures correspondantes
    for($i = 0; $i < count($day->GetHours()); $i++){
        $hour = $day->GetHour($i);
        array_push($hours, $hour->GetHour());
        array_push($temperatures, $hour->GetTemperature());    
        array_push($weathers, $hour->GetMeteoGroup());           
    }       
    echo "</div>";

    //Liste des des liens vers les heures de la journée, pour obtenir plus de détails
    echo "<div class=\"hoursBubble\" id=".$day->GetDate()."> ";
    for($i = 0; $i < count($hours); $i++){
      $hour = $hours[$i];
      //mettre en évidence l'heure sélectionnàe
      if($i == $numHour){
        echo '<a class="selectedLink" href="index.php?numDay='.$numDay.'&numHour='.$i.'">'.$hour.'h</a> ';   
      }
      else{
        echo '<a href="index.php?numDay='.$numDay.'&numHour='.$i.'">'.$hour.'h</a> ';   
      }
    }
    echo "</div>";

    //Détails météo par heure
    echo "<div class=\"detailsBubble\" id=".$day->GetDate()."> ";   
    DisplayRecordingsDetails($day, $numHour);
    echo "</div>";

    //Tenue recommandée en fonction de la météo
    echo "<div class=\"dressBubble\">";
    DisplayDress($temperatures, $weathers);
    echo "</div>";

    //Activités et évènements du jour
    echo "<div class=\"eventsBubble\">";
    DisplayDaysEvents($numDay);
    echo "</div>";

    echo "</div>";

    //Afficher les températures avec un graphique javascript
    DisplayTemperatureGraphic($hours, $temperatures, $day->GetDate());
}

//Afficher de la température au cours de la journée grâce à un graphique js
function DisplayTemperatureGraphic($hours, $temperatures, $date){
  //Créer un string avec le format tableau en javascript pour pouvoir envoyer les données à la fonction d'affichage
  $temperaturesJSArray = "[['Heure', 'Température'],";
  for($i = 0; $i < count($hours); $i++){
    $temperaturesJSArray .= "[";
    $temperaturesJSArray .= '"'.$hours[$i].'"' . "," . $temperatures[$i];
    $temperaturesJSArray .= "]";
    if($i!=(count($hours)-1)){
      $temperaturesJSArray .= ",";
    }
  }
  $temperaturesJSArray .= "]";

  //appel de la fonction qui affiche le graphique des températures
  echo "<script>DisplayTemperatures($temperaturesJSArray,\"$date\")</script>";
}

//Afficher les informations détaillées pour une heure en particulier de la journée
function DisplayRecordingsDetails($day, $idRecording){
  //Récupérer l'enregistrement à afficher
  $recording = $day->GetHour($idRecording);

  //Afficher les informations détaillées de l'enregistrements
  echo '<img src="http://openweathermap.org/img/wn/'.$recording->GetIcon().'.png"/>';
  echo "<p>".$recording->GetMeteoDescription()."</p>";
  echo "<p> Précipitations : ".$recording->GetProbPrecipitations()."% </p>";
  echo "<p> Humidité : ".$recording->GetHumidity()."% </p>";
  echo "<p> Vent : ".$recording->GetWindSpeed()." km/h</p>";
}

//Récupérer tous les évènements de la journée, qu'ils proviennent du calendrier ou du semainier, et les afficher
function DisplayDaysEvents($numDay){
  //Récupérer les évènements du semainier de ce jour de la semaine
  $weeklyEvents = GetEventsWeekPlanner();  
  $events = [];  

  //Les ajouter à la liste des évènements du jour, si leur jour correspond
  foreach($weeklyEvents as $key => $event){
      if(intval(explode(".",$event["theDate"])[0]) == GetWeekDay($numDay)){
        array_push($events, $event);        
      }
  }

  //Récupérer le début et la fin de la journée actuelle
  $timeZone = 'Europe/Zurich';
  date_default_timezone_set($timeZone);
  $dateStart = date_create(date("Y")."-".date("m")."-".date("d")." 00:00");
  $dateEnd = date_create(date("Y")."-".date("m")."-".date("d")." 23:59");

  //Calculer le début et la fin du jour affiché
  date_add($dateStart, date_interval_create_from_date_string($numDay.' days'))->format('d.m.Y H:i:s');
  date_add($dateEnd, date_interval_create_from_date_string($numDay.' days'))->format('d.m.Y H:i:s');

  //Transformer les dates dans le bon format pour les envoyer à la requête sql
  $dateStart = date('d.m.Y H:i:s', strtotime(date_format($dateStart, 'd.m.Y H:i:s')));
  $dateEnd = date('d.m.Y H:i:s', strtotime(date_format($dateEnd, 'd.m.Y H:i:s')));

  //Récupérer les évènements du calendrier à cette date
  $todaysEvents = GetEventsBetween($dateStart, $dateEnd);

  //Ajouter les évènements du calendrier aux évènements précédemment récupérés du semainier
  foreach($todaysEvents as $day){
    foreach($day as $event){
      array_push($events, $event);
    }
  }

  //Les trier par ordre chronologique
  $events = SortEventsByTime($events);

  //Les afficher
  foreach($events as $event){
    DisplayEvent($event, true);
  }
}

//Trier les évènements (d'une journée) par ordre croissant des heures
function SortEventsByTime($events){
  $sortedEvents = [];
  $sorted = true;
  //Parcourir tous les évènements de la liste
  for($i = 0; $i < (count($events) - 1); $i++){
    //Si l'heure de l'évènement actuel est suppérieur à celle de l'évènement suivant
    if(intval($events[$i]["theHour"])>intval($events[$i+1]["theHour"])){
      //Echanger de position les deux évènements
      $event = $events[$i];
      $events[$i] = $events[$i+1];
      $events[$i+1] = $event;
      $sorted = false;    
    }
    else{
    }
  }
  //Si le tableau n'était toujours pas trié durant la dernière boucle, rappeler la fonction
  if(!$sorted){
    SortEventsByTime($events);
  }
  return $events;
}

//Afficher la météo résumée pour le calendrier
function DisplayMeteoSummary($numDay){
  //Récupérer les informations météo du jour sélectionné
  $day = GetMeteo()->GetDay($numDay);

  //Indexs des heures auxquelles récupérer les information du matin et du soir
  $indexMorning = 2;
  $indexEvening = 5;

  //Si la journée n'est plus complète, et que l'heure du soir est passée
  if(count($day->GetHours())<=2){
    $tempMorning = $day->GetHour(0)->GetTemperature();
    $tempEvening = $day->GetHour($indexEvening-(8-count($day->GetHours())))->GetTemperature();
    $iconMorning = $day->GetHour(0)->GetIcon();
    $iconEvening = $day->GetHour($indexEvening-(8-count($day->GetHours())))->GetIcon();

    echo '<div class="summaryBubble">';
    //Afficher les icones des groupes météo du matin et du soir (9h/18h)
    echo '<div class="summaryLeftBox"><p>'.$tempMorning.'°C </p><img src="http://openweathermap.org/img/wn/'.$iconMorning.'.png"/></div>';
    //Afficher la température le matin et le soir (9h/18h)
    echo '<div><p>'.$tempEvening.'°C </p><img src="http://openweathermap.org/img/wn/'.$iconEvening.'.png"/></div>';
    echo '</div>';
  }
  //Si la journée n'est plus complète, et que l'heure du matin est passée
  else if(count($day->GetHours())<=5){
    $tempMorning = $day->GetHour(0)->GetTemperature();
    $tempEvening = $day->GetHour($indexEvening-(8-count($day->GetHours())))->GetTemperature();
    $iconMorning = $day->GetHour(0)->GetIcon();
    $iconEvening = $day->GetHour($indexEvening-(8-count($day->GetHours())))->GetIcon();

    echo '<div class="summaryBubble">';
    //Afficher les icones des groupes météo du matin et du soir (9h/18h)
    echo '<div class="summaryLeftBox"><p>'.$tempMorning.'°C </p><img src="http://openweathermap.org/img/wn/'.$iconMorning.'.png"/></div>';
    //Afficher la température le matin et le soir (9h/18h)
    echo '<div><p>'.$tempEvening.'°C </p><img src="http://openweathermap.org/img/wn/'.$iconEvening.'.png"/></div>';
    echo '</div>';
  }
  //Si l'heure du matin n'est pas encore passée
  else{
    $tempMorning = $day->GetHour($indexMorning)->GetTemperature();
    $tempEvening = $day->GetHour($indexEvening)->GetTemperature();
    $iconMorning = $day->GetHour($indexMorning)->GetIcon();
    $iconEvening = $day->GetHour($indexEvening)->GetIcon();

    echo '<div class="summaryBubble">';
    //Afficher les icones des groupes météo du matin et du soir (9h/18h)
    echo '<div class="summaryLeftBox"><p>'.$tempMorning.'°C </p><img src="http://openweathermap.org/img/wn/'.$iconMorning.'.png"/></div>';
    //Afficher la température le matin et le soir (9h/18h)
    echo '<div><p>'.$tempEvening.'°C </p><img src="http://openweathermap.org/img/wn/'.$iconEvening.'.png"/></div>';
    echo '</div>';
  }
}

//Retourner, pour dans X jours, le nom du jour de la semaine en français
function GetWeekDayName($numDay){
    $days = array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi');

    //récupérer l'index du jour actuel et ajouter le nombre de jours indiqué en paramètre
    $index = date('w', date_timestamp_get(new DateTime('now'))) + $numDay;
    if($index > 6){
        $index = ($index % 6) - 1;
    }

    return $days[$index];
}

//Retourner, pour dans X jours, le nom du jour de la semaine en français
function GetWeekDayNameAbsolute($numDay){
  $days = array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi');

  return $days[intval($numDay)];
}

//Retourner, pour dans X jours, le numéro du jour de la semaine (0-6 pour dimanche-samedi)
function GetWeekDay($numDay){
  //Récupérer l'index du jour actuel et ajouter le nombre de jours indiqué en paramètre
  $index = date('w', date_timestamp_get(new DateTime('now'))) + $numDay;
  if($index > 6){
      $index = ($index % 6) - 1;
  }
  return $index;
}
```

```php
<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : classe Semaine, sauvegarde les 5 jours à venirs
*/

class Week{
    //Champs
    private $_days;

    //Constructeur
    public function __construct($infosMeteo){
        //Créer tous les jours et les ajouter à la liste _jours
        $this->_days = [];
        for($i = 0; $i < count($infosMeteo); $i++){
            $day = new day($infosMeteo[$i]);
            array_push($this->_days, $day);
        }
    }

    //Méthodes

    //Retourner la liste des jours de la semaine
    public function GetDays(){
        return $this->_days;
    }

    //Retourner le jour de la semaine à la position $numDay
    public function GetDay($numDay){
        return $this->_days[$numDay];
    }
}
```

```php
<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : classe Semaine, stocke les 8 heures de la journée possédant des informations meteo
*/

class Day{
    //Champs
    private $_recordings;
    private $_date;

    //Constructeur
    function __construct($infosMeteo){
        $this->_date = $infosMeteo[0]["date"];
        //Créer toutes les heures et les ajouter à la liste _heure
        $this->_recordings = [];
        for($i = 0; $i < count($infosMeteo); $i++){
            $recording = new MeteoRecord($infosMeteo[$i]);
            array_push($this->_recordings, $recording);
        }
    }

    //Méthodes

    //Retourner la date du jour
    public function GetDate(){
        return $this->_date;
    }

    //Retourner la liste des enregistrements du jours
    public function GetHours(){
        return $this->_recordings;
    }

    //Retourner l'enregistrement à la position $numHour
    public function GetHour($numHour){
        return $this->_recordings[$numHour];
    }
}
```

```php
<?php
/*
  Projet     : Suggestion de tenues en fonction de la météo
  Auteur     : Aliya Myaz
  Date       : Mai 2021
  Sujet      : Classe "enregistrement météo", stocke les informations météorologiques d'une heure précise
*/

class MeteoRecord{
    //Champs
    private $_hour;
    private $_temperature;   
    private $_meteoGroup;
    private $_meteoDescription;
    private $_icon;
    private $_humidity;
    private $_windSpeed;
    private $_probPrecipitations;

    //Constructeur
    function __construct($infosMeteo){
        //Enregistrer toutes informations de l'enreistrement dans les champs       
        $this->_hour = $infosMeteo["heure"];
        $this->_temperature = $infosMeteo["temperature"];;
        $this->_meteoGroup = $infosMeteo["groupeMeteorologique"];
        $this->_meteoDescription = $infosMeteo["descriptionMeteo"];
        $this->_icon = $infosMeteo["icone"];
        $this->_humidity = $infosMeteo["humidite"];
        $this->_windSpeed = $infosMeteo["vitesseVent"];
        $this->_probPrecipitations = $infosMeteo["probPrecipitations"];
    }


    //Méthodes

    //Retourner l'heure de l'enregistrement
    public function GetHour(){
        return $this->_hour;
    }

    //Retourner la température
    public function GetTemperature(){
        return $this->_temperature;
    }

    //Retourner le groupe météo (pluie, neige...)
    public function GetMeteoGroup(){
        return $this->_meteoGroup;
    }

    //Retourner la secription détaillée de la météo
    public function GetMeteoDescription(){
        return $this->_meteoDescription;
    }

    //Retourner l'icone météo
    public function GetIcon(){
        return $this->_icon;
    }

    //Retourner l'humidité
    public function GetHumidity(){
        return $this->_humidity;
    }

    //Retourner la vitesse du vent
    public function GetWindSpeed(){
        return $this->_windSpeed;
    }

    //Retourner la probabilité de précipitations
    public function GetProbPrecipitations(){
        return $this->_probPrecipitations;
    }
}
```

```php
<?php
/*
  Projet     : Suggestion de tenues en fonction de la météo
  Auteur     : Aliya Myaz
  Date       : Mai 2021
  Sujet      : Récupération de tous les scripts php
*/

require_once('database/constantes.inc.php');
require_once('database/connect.php');
require_once("database/user.php");
require_once("database/clothe.php");
require_once("database/category.php");
require_once("database/weather.php");
require_once("database/event.php");
require_once("functions.php");
require_once("meteoRecord.php");
require_once("week.php");
require_once("day.php");
```

```php
<?php
/*
  Projet     : Suggestion de tenues en fonction de la météo
  Date       : Mai 2021
  Auteur     : Aliya Myaz
  Sujet      : Constantes de connexion à la base de données clothes_recommendation_db
 */

define("HOST", "127.0.0.1");
define("DBNAME", "clothes_recommendation_db");
define("DBUSER", "clothesAdvisor");
define("DBPWD", "meteo");

```

```php
<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2020
  Auteur      : Aliya Myaz
  Description : Contient la fonction de connexion à la base de données
 */

//Connexion à la base de donnée
function db() {
  static $myDb = null;

  //Si la connexion n'a pas encore été faite, connecter
  if ( $myDb == null ) {
    try{
      $myDb = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, DBUSER, DBPWD, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8;",
        PDO::ATTR_PERSISTENT => true
      ));
    }
    catch(Exception $e){
      //Afficher erreurs
      echo 'Erreur : ' . $e->getMessage() . '<br />';
      echo 'N° : ' . $e->getCode();
      // Quitte le script et meurt
      die('Could not connect to MySQL');
    }    
  }

  //Retourner un connecteur
  return $myDb;
}
```

```php
<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Gestion de la table "user"
*/

//Retourner les informations de l'utilisateur correspondant au nom d'utilisateur envoyé
function ReadUserByUsername($login){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT * FROM user WHERE login = :login";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':login', $login, PDO::PARAM_STR);

    if($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

//Retourner les informations de l'utilisateur correspondant à l'identifiant envoyé
function ReadUserById($idUser){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT * FROM user WHERE idUser LIKE :idUser";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);

    if($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

//Retourner la liste des utilisateurs de rôle "utilisateur"
function ReadUsers(){
  //initaliser le prepare statement
  static $ps = null;

  //requête
  $sql = "SELECT * FROM user WHERE idRole = 1";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{

    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

//Ajouter un utilisateur dans la base de données
function CreateUser($login, $firstName, $lastName, $eMail, $myPassword){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "INSERT INTO `user` (`login`, `firstName`, `lastName`, `eMail`, `password`, `idRole`) VALUES ( :login, :firstName, :lastName, :eMail, :myPassword, 1)";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':login', $login, PDO::PARAM_STR);
    $ps->bindParam(':eMail', $eMail, PDO::PARAM_STR);
    $ps->bindParam(':firstName', $firstName, PDO::PARAM_STR);
    $ps->bindParam(':lastName', $lastName, PDO::PARAM_STR);
    $ps->bindParam(':myPassword', $myPassword, PDO::PARAM_STR);

    $answer = $ps->execute();
    if($answer){
    }
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}

//Modifier les informations d'un utilisateur dans la base de données grâce à son identifiant
function UpdateUserById($idUser, $login, $firstName, $lastName, $eMail){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = 'UPDATE user SET login = :login, firstName = :firstName, lastName = :lastName, eMail = :eMail WHERE idUser = :idUser';

  //si le prépare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $ps->bindParam(':login', $login, PDO::PARAM_STR);
    $ps->bindParam(':firstName', $firstName, PDO::PARAM_STR);
    $ps->bindParam(':lastName', $lastName, PDO::PARAM_STR);
    $ps->bindParam(':eMail', $eMail, PDO::PARAM_STR);

    $answer = $ps->execute();
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}

//Modifier les informations + mot de passe d'un utilisateur dans la base de données grâce à son identifiant
function UpdateUserByIdWithPassword($idUser, $login, $firstName, $lastName, $eMail, $myPassword){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = 'UPDATE user SET login = :login, firstName = :firstName, lastName = :lastName, eMail = :eMail, password = :myPassword WHERE idUser = :idUser';

  //si le prépare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $ps->bindParam(':login', $login, PDO::PARAM_STR);
    $ps->bindParam(':firstName', $firstName, PDO::PARAM_STR);
    $ps->bindParam(':lastName', $lastName, PDO::PARAM_STR);
    $ps->bindParam(':eMail', $eMail, PDO::PARAM_STR);
    $ps->bindParam(':myPassword', $myPassword, PDO::PARAM_STR);

    $answer = $ps->execute();
    if($answer){
      echo "La note ".$idUser." a été modifiée";
    }    
  }
  catch(PDOException $e){
    echo $e->getMessage();
    echo "Un problème est survenu lors de la modification de la note ".$idUser;
  }

  return $answer;
}

//Supprimer l'utilisateur dont l'identifiant est récupéré en paramètre
function DeleteUserById($idUser){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "DELETE FROM user WHERE idUser LIKE :idUser";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);

    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}
```

```php
<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Gestion de la table "event"
*/

//Retourner les évènements du calendrier enregistrés pour une date située dans l'intervalle donné en paramètre, pour un utilisateur donné
function readEventsByTime($dateStart, $dateEnd, $idUser){
  //initaliser le prepare statement
  static $ps = null;

  //requête  
  $sql = "SELECT *, DATE_FORMAT(`dateStart`, '%Y-%m-%d') AS theDate, DATE_FORMAT(`dateStart`, '%H:%i') AS theHour, DATE_FORMAT(`dateStart`, '%w') AS theWeekDay from `event`
  WHERE reccurent LIKE 0
  AND idUser = :idUser
  AND ((dateStart BETWEEN :dateStart AND :dateEnd) OR (dateEnd BETWEEN :dateStart AND :dateEnd))";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre de la requête avec la variable
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $ps->bindParam(':dateStart', $dateStart, PDO::PARAM_STR);
    $ps->bindParam(':dateEnd', $dateEnd, PDO::PARAM_STR);

    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}

//Retourner les évènements du semainier d'un utilisateur donné
function readWeekPlannerEvents($idUser){
  //initaliser le prepare statement
  static $ps = null;

  //requête
  $sql = "SELECT *, DATE_FORMAT(`dateStart`, '%d.%m.%Y') as theDate, DATE_FORMAT(`dateStart`, '%H:%i') as theHour, DATE_FORMAT(`dateStart`, '%w') as theWeekDay from `event` WHERE idUser = :idUser AND reccurent LIKE 1";
  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);

    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}

//Retourner l'évènement correspondant à un identifiant donné
function readEventById($idEvent, $idUser){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT * from `event` WHERE idUser = :idUser AND idEvent LIKE :idEvent";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $ps->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);

    if($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

//Ajouter un évènement dans la base de données
function createEvent($description, $dateStart, $dateEnd, $isReccurent, $idUser){
  echo $dateStart;
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "INSERT INTO `event` (`description`, `dateStart`, `dateEnd`, `reccurent`, `idUser`) VALUES ( :description, :dateStart, :dateEnd, :isReccurent, :idUser)";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':description', $description, PDO::PARAM_STR);
    $ps->bindParam(':dateStart', $dateStart, PDO::PARAM_STR);
    $ps->bindParam(':dateEnd', $dateEnd, PDO::PARAM_STR);
    $ps->bindParam(':isReccurent', $isReccurent, PDO::PARAM_INT);
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);

    $answer = $ps->execute();
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}

//Supprimer l'évènement correspondant à un identifiant donné
function DeleteEventById($idEvent){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "DELETE FROM event WHERE idEvent LIKE :idEvent";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);

    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

//Supprimer un évènement enregistré à une date donnée
function DeleteEventByTime($dateStart, $idUser){
  //initaliser le prepare statement
  static $ps = null;

  echo $dateStart. " ".$idUser;
  //requête  
  $sql = "DELETE FROM `event`
  WHERE reccurent LIKE 1
  AND idUser = :idUser
  AND dateStart BETWEEN :dateStart AND :dateStart";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre de la requête avec la variable
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $ps->bindParam(':dateStart', $dateStart, PDO::PARAM_STR);

    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}
```

```php
<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Gestion de la table "clothe" - en cours
*/

//Rechercher les vêtements appartenant à une certaine catégorie (haut, bas, ensemble, exterieur, chaussures), qui correspondent à la météo, appartenant à un utilisateur donné
function ReadClothesByMeteoAndCategorie($temperature, $weather, $categoryGroup, $idUser){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT idClothe FROM category c join clothe on c.idCategory = clothe.idCategory JOIN weather w on W.idWeather = clothe.idWeather WHERE c.typeClothe = :categoryGroup AND w.name = :weather AND tempMin <= :temperature AND tempMax >= :temperature AND idUser LIKE :idUser GROUP BY idClothe";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable   
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $ps->bindParam(':temperature', $temperature, PDO::PARAM_INT);
    $ps->bindParam(':weather', $weather, PDO::PARAM_STR);
    $ps->bindParam(':categoryGroup', $categoryGroup, PDO::PARAM_STR);

    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

//Récupérer le vêtement correspondant à l'identifiant
function ReadClotheById($idClothe){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT * FROM clothe WHERE idClothe LIKE :idClothe";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idClothe', $idClothe, PDO::PARAM_INT);

    if($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

//Récupérer les vêtements appartenant à l'utilisateur
function ReadClothesByUser($idUser){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT * FROM clothe WHERE idUser LIKE :idUser";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);

    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

//Créer un vêtement grâce à des propriétés données
function CreateClothe($name, $idCategory, $idWeather, $color, $tempMin, $tempMax, $idUser){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "INSERT INTO `clothe` (`name`, `idCategory`, `idWeather`, `color`, `tempMin`, `tempMax`, `idUser`) VALUES ( :name, :idCategory, :idWeather, :color, :tempMin, :tempMax, :idUser)";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':name', $name, PDO::PARAM_STR);
    $ps->bindParam(':idCategory', $idCategory, PDO::PARAM_INT);
    $ps->bindParam(':idWeather', $idWeather, PDO::PARAM_INT);
    $ps->bindParam(':color', $color, PDO::PARAM_STR);
    $ps->bindParam(':tempMin', $tempMin, PDO::PARAM_INT);
    $ps->bindParam(':tempMax', $tempMax, PDO::PARAM_INT);
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);

    $answer = $ps->execute();
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}

//Modifier les caractéristiques d'un vêtement en fonction de son identifant
function UpdateClotheById($idClothe, $name, $idCategory, $idWeather, $color, $tempMin, $tempMax){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = 'UPDATE clothe SET name = :name, idCategory = :idCategory, color = :color, idWeather = :idWeather, tempMin = :tempMin, tempMax = :tempMax WHERE idClothe = :idClothe';

  //si le prépare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idClothe', $idClothe, PDO::PARAM_INT);
    $ps->bindParam(':name', $name, PDO::PARAM_STR);
    $ps->bindParam(':idCategory', $idCategory, PDO::PARAM_INT);
    $ps->bindParam(':color', $color, PDO::PARAM_STR);
    $ps->bindParam(':idWeather', $idWeather, PDO::PARAM_INT);
    $ps->bindParam(':tempMin', $tempMin, PDO::PARAM_INT);
    $ps->bindParam(':tempMax', $tempMax, PDO::PARAM_INT);

    $answer = $ps->execute();
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

//Supprimer le vêtement correspondant à l'identifiant donné
function DeleteClotheById($idClothe){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "DELETE FROM clothe WHERE idClothe LIKE :idClothe";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idClothe', $idClothe, PDO::PARAM_INT);

    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}
```

```php
<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Gestion de la table "category"
*/

//Retourner les catégories prédéfinies enregsitrées dans la base de données
function readCategories(){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT * FROM category";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}

//Retourner la catégorie correspondant à un identifiant donné
function readCategoryById($idCategory){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT * FROM category WHERE idCategory LIKE :idCategory";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }

  $answer = false;
  try{
    $ps->bindParam(':idCategory', $idCategory, PDO::PARAM_INT);
    if($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}
```

```php
<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Gestion de la table "weather"
*/

//Retourner les groupes météo prdéfinis enregistrés dans la base de données
function readWeathers(){
  static $ps = null;

  //Requête
  $sql = "SELECT * FROM weather";

  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}
```

```javascript
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Fonctions javascript pour l'affichage de graphiques météo
*/

//Télécharger la libraire google charts
google.charts.load('current', {packages: ['corechart', 'bar']});

//Données du tableau
var preparedData;

//Identifiant de l'emplacement HTML où il faut afficher le graphique
var id;

//Récupérer les informations du graphique et appeler la fonction de dessin
function DisplayTemperatures(temperatures, date){
  id = date;

	//Formater les données de températures par heure
	preparedData = temperatures;
  
  //Créer et afficher le graphique
  google.charts.setOnLoadCallback(DrawGraphic);
}

//Dessiner le graphique grâce à la libraire google charts
function DrawGraphic(){
  //Traiter les données
  var data = google.visualization.arrayToDataTable(preparedData)

  //Paramétrer le graphique
  var materialOptions = { 
    bars: 'vertical',
    'width':500,
    'height':180,
    colors: ['#D2EEFF']
  };

  //Afficher le graphique
  var materialChart = new google.charts.Bar(document.getElementById(id));
  materialChart.draw(data, materialOptions);
}
```

