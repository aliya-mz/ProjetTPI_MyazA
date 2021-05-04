<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Gestion de la table "category"
*/

function readFavorisByIdea($idIdee, $idUser){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT idIdee FROM mettre_favoris WHERE idIdee = :idIdee AND idUser = :idUser";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $ps->bindParam(':idIdee', $idIdee, PDO::PARAM_INT);


    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  //renvoyer true si l'idée est dans les favoris de l'utilisateur
  return (count($answer)==1);
}

function createFavoris($idIdee, $idUser){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "INSERT INTO `mettre_favoris` (`idIdee`, `idUser`) VALUES ( :idIdee, :idUser)";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idIdee', $idIdee, PDO::PARAM_INT);
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);

    $answer = $ps->execute();
  }
  catch(PDOException $e){
    echo $e->getMessage();
  } 

  return $answer;
}

function deleteFavoris($idIdee, $idUser){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = 'DELETE FROM mettre_favoris WHERE idUser = :idUser AND idIdee = :idIdee';

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idIdee', $idIdee, PDO::PARAM_INT);
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);

    $answer = $ps->execute();
  }
  catch(PDOException $e){
    echo $e->getMessage();
  } 

  return $answer;
}