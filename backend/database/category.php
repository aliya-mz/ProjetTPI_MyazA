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