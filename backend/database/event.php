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