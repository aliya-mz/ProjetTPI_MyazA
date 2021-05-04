<?PHP
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Fonction du projet
*/

//Gestion des utilisateurs - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

function VerifyAccessibility($connected){
  //$connected = true => permettre aux personnes connectées
  if($connected){
    //tester si on doit pouvoir accéder à cette page
    if(!isset($_SESSION["idUser"])){
      //erreur, utilisateur déconnecté, renvoyer sur la page d'accueil
      header('Location: index.php');
      exit;
    }
  }
  else{
    //tester si on doit pouvoir accéder à cette page
    if(isset($_SESSION["idUser"])){
      //erreur, utilisateur déconnecté, renvoyer sur la page d'accueil
      header('Location: index.php');
      exit;
    }
  }
}

//Gestion garde-robe - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

//Gestion du formulaire_________________________________________________________
function GetCategories(){

  return [];
}

function GetWeathers(){

  return [];
}

//Création de tenues_____________________________________________________________

//Définir les groupes de vêtements pour pouvoir les assembler en tenues
$groups = [
  "hauts" => [],
  "bas" => [],
  "combinaisons" => [],
];

function GenerateDress($temperature, $weather){
  //Recherche les vêtements appartenant à un groupe (hauts, bas ou combinaisons)


  //Retourner l'ensemble des vêtements de la tenue générée
  return [];
}

//Gestion de l'affichage__________________________________________________________

//Afficher l'image d'une tenue
function DisplayClotheImage($category, $color){

}

//Afficher une tenue complète, avec le résumé des vêtements
function DisplayDress($dress){

}

//Afficher les détails d'un vêtement
function DisplayClothe($clothe){
  
}