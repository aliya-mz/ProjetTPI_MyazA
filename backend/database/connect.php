<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2020
  Auteur      : Aliya Myaz
  Description : Contient la fonction de connexion à la base de données
 */

//Connexion à la base de donnée
function db() {
  static $myDb = null;

  //si la connexion n'a pas encore été faite
  if ( $myDb == null ) {
    try{
      $myDb = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, DBUSER, DBPWD, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8;",
        PDO::ATTR_PERSISTENT => true
      ));
    }
    catch(Exception $e){
      //afficher erreurs
      echo 'Erreur : ' . $e->getMessage() . '<br />';
      echo 'N° : ' . $e->getCode();
      // Quitte le script et meurt
      die('Could not connect to MySQL');
    }    
  }

  //retourne un connecteur
  return $myDb;
}