<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Gestion de la table "event" - en cours
*/

function readEventsByTime($dateStart, $dateEnd){
  //initaliser le prepare statement
  static $ps = null;

  //requête
  $sql = "SELECT *, DATE_FORMAT(`dateStart`, '%d.%m.%Y') as theDate, DATE_FORMAT(`dateStart`, '%H:%i') as theHour, DATE_FORMAT(`dateStart`, '%w') as theWeekDay from `event` WHERE reccurent LIKE -1";
  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre de la requête avec la variable
    $ps->bindParam(':dateStart', $dateStart, PDO::PARAM_STR);
    $ps->bindParam(':dateEnd', $dateEnd, PDO::PARAM_STR);

    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  echo $answer;
  return $answer;
}

function readWeekPlannerEvents(){
  //initaliser le prepare statement
  static $ps = null;

  //requête
  $sql = "SELECT *, DATE_FORMAT(`dateStart`, '%d.%m.%Y') as theDate, DATE_FORMAT(`dateStart`, '%H:%i') as theHour, DATE_FORMAT(`dateStart`, '%w') as theWeekDay from `event` WHERE reccurent LIKE 1";
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

  echo $answer;
  return $answer;
}

function readEventById($idEvent){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT * from `event` WHERE idEvent LIKE :idEvent";

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
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

function createEvent($description, $dateStart, $dateEnd, $isReccurent, $idUser){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "INSERT INTO `event` (`description`, `dateStart`, `dateEnd`, `isReccurent`, `idUser`) VALUES ( :description, :dateStart, :dateEnd, :isReccurent, :idUser)";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':description', $description, PDO::PARAM_STR);
    $ps->bindParam(':dateStart', $dateStart, PDO::PARAM_INT);
    $ps->bindParam(':dateEnd', $dateEnd, PDO::PARAM_INT);
    $ps->bindParam(':isReccurent', $isReccurent, PDO::PARAM_INT);
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);

    $answer = $ps->execute();
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}

function UpdateEventById($idEvent, $description, $dateStart, $dateEnd, $isReccurent, $idUser){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = 'UPDATE `event` SET name = :name, `description` = :description, dateStart = :dateStart, dateEnd = :dateEnd, isReccurent = :isReccurent WHERE idEvent = :idEvent';

  //si le prépare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
    $ps->bindParam(':description', $description, PDO::PARAM_INT);
    $ps->bindParam(':dateStart', $dateStart, PDO::PARAM_STR);
    $ps->bindParam(':dateEnd', $dateEnd, PDO::PARAM_INT);
    $ps->bindParam(':isReccurent', $isReccurent, PDO::PARAM_INT);

    $answer = $ps->execute();
  }
  catch(PDOException $e){
    echo $e->getMessage();
  } 

  return $answer;
}

function DeleteEventById($idEvent){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "DELETE FROM event, role WHERE idEvent LIKE :idEvent";

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