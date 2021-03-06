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