<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Gestion de la table "user"
*/


function readUserByUsername($username){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT * FROM user WHERE username = :username";

  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    //préparer la requête
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    //lier le paramètre dans la requête avec la variable
    $ps->bindParam(':username', $username, PDO::PARAM_STR);

    if($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

function readUserById($idUser){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT *, name as myRole FROM utilisateur, role WHERE idUser LIKE :idUser";

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

function createUser($login, $firstName, $lastName, $eMail, $myPassword){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "INSERT INTO `utilisateur` (`login`, `firstName`, `lastName`, `eMail`, `password`) VALUES ( :login, :firstName, :lastName, :eMail, :myPassword, 1)";

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
      echo "L'utilisateur' a bien été créé";
    }
  }
  catch(PDOException $e){
    echo $e->getMessage();
    echo "Un problème est survenu lors de la création de l'utilisateur";
  }
  return $answer;
}
