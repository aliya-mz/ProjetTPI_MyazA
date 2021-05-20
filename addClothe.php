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
