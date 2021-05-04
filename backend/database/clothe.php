<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Gestion de la table "clothe" - en cours
*/

//Recherche les vêtements appartenant à une certaine catégorie (pulls, pantalons...), qui correspondent à la météo
function ReadClotheByMeteoAndCategorie($temperature, $idWeather, $idCategorie){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT * FROM clothe WHERE idWeather = :idWeather AND  idWeather = :idWeather AND tempMin <= :temperature AND tempMax >= :temperature";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idWeather', $idWeather, PDO::PARAM_STR);
    $ps->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $ps->bindParam(':temperature', $temperature, PDO::PARAM_INT);

    if($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

//Récupère le vêtement correspondant à l'identifiant
function ReadClotheById($idClothe){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT * FROM clothe, role WHERE idClothe LIKE :idClothe";

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

//Créer un vêtement grâce à des propriétés données
function CreateClothe($name, $idCategory, $color, $idWeather, $tempMin, $tempMax, $idUser){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "INSERT INTO `clothe` (`name`, `idCategory`, `color`, `idWeather`, `tempMin`, `tempMax`, `idUser`) VALUES ( :name, :idCategory, :color, :idWeather, :tempMin, :tempMax, :idUser)";

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
    $ps->bindParam(':color', $color, PDO::PARAM_STR);
    $ps->bindParam(':idWeather', $idWeather, PDO::PARAM_INT);
    $ps->bindParam(':tempMin', $tempMin, PDO::PARAM_INT);
    $ps->bindParam(':tempMax', $tempMax, PDO::PARAM_INT);
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);


    $answer = $ps->execute();
    if($answer){
      echo "Le vêtement a bien été créé";
    }
  }
  catch(PDOException $e){
    echo $e->getMessage();
    echo "Un problème est survenu lors de la création du vêtement";
  }
  return $answer;
}

function UpdateClotheById($idClothe, $name, $idCategory, $color, $idWeather, $tempMin, $tempMax){
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
    $ps->bindParam(':idCategory', $idCategory, PDO::PARAM_INT);
    $ps->bindParam(':color', $color, PDO::PARAM_STR);
    $ps->bindParam(':idWeather', $idWeather, PDO::PARAM_INT);
    $ps->bindParam(':tempMin', $tempMin, PDO::PARAM_INT);
    $ps->bindParam(':tempMax', $tempMax, PDO::PARAM_INT);

    $answer = $ps->execute();
    if($answer){
      echo "Le vêtement a été modifiée";
    }    
  }
  catch(PDOException $e){
    echo $e->getMessage();
    echo "Un problème est survenu lors de la modification du vêtement";
  } 

  return $answer;
}

function DeleteClotheById($idClothe){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "DELETE FROM clothe, role WHERE idClothe LIKE :idClothe";

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