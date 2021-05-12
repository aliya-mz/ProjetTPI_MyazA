<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Gestion de la table "clothe" - en cours
*/

//Rechercher les vêtements appartenant à une certaine catégorie (haut, bas, ensemble, exterieur, chaussures), qui correspondent à la météo
function ReadClothesByMeteoAndCategorie($temperature, $weather, $categoryGroup){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT idClothe FROM category c join clothe on c.idCategory = clothe.idCategory JOIN weather w on W.idWeather = clothe.idWeather WHERE c.typeClothe = :categoryGroup AND w.name = :weather AND tempMin <= :temperature AND tempMax >= :temperature GROUP BY idClothe";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable    
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

//Supprimer le vêtement correspondant à l'identifiant
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