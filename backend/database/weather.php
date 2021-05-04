<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Gestion de la table "weather"
*/

function readWeathers(){
  static $ps = null;
  $sql = "SELECT * FROM weather";

  if($ps == null){
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
















































/*
function ReadIdees(){
  static $ps = null;
  $sql = "SELECT *, DATE_FORMAT(`dateCreation`, '%d/%m/%Y %H:%i:%s') as dateFormatee FROM idee";
  if($ps == null){
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

//trouver toutes les idées crées par l'utilisateur
function ReadIdeesByAuteur($idAuteur){
  static $ps = null;
  $sql = "SELECT *, DATE_FORMAT(`dateCreation`, '%d/%m/%Y %H:%i:%s') as dateFormatee FROM idee WHERE idAuteur = :idAuteur";
  if($ps == null){
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    $ps->bindParam(':idAuteur', $idAuteur, PDO::PARAM_INT);

    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

//retrouver l'identifiant de l'idée que vient d'ajouter l'utilisateur
function ReadLastIdeeByAuteur($idAuteur){
  static $ps = null;
  $sql = "SELECT idIdee FROM idee t inner join
  (SELECT idAuteur, MAX(dateCreation) AS max_date FROM idee
  WHERE idAuteur = :idAuteur)a
  ON a.idAuteur = t.idAuteur AND a.max_date = dateCreation";
  if($ps == null){
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    $ps->bindParam(':idAuteur', $idAuteur, PDO::PARAM_INT);
    if($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}

//trouver toutes les idées mises en favori par l'utilisateur
function ReadIdeesByFavoriUser($idUser){
  static $ps = null;
  $sql = "SELECT *, DATE_FORMAT(`dateCreation`, '%d/%m/%Y %H:%i:%s') as dateFormatee FROM idee, mettre_favoris WHERE mettre_favoris.idIdee=idee.idIdee AND mettre_favoris.idUser=:idUser";
  if($ps == null){
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

//trouver l'idée correspondant à un indentifiant
function ReadIdeeById($idIdee){
  //initaliser le prepare statement
  static $ps = null;
  //requête
  $sql = "SELECT *, DATE_FORMAT(`dateCreation`, '%d/%m/%Y %H:%i:%s') as dateFormatee FROM idee WHERE idIdee = :idIdee";
  //si le prepare statement n'a encore jamais été fait
  if($ps == null){
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    $ps->bindParam(':idIdee', $idIdee, PDO::PARAM_INT);

    if($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}

//recherche avec mot-clé et/ou catégorie
function readIdeesByCritereExpansion($critere, $idCategorie, $idUser){
  //initaliser le prepare statement
  static $ps = null;
  echo $critere .$idCategorie ."  ".$idUser;
  //requête avec recherche fulltext
  $sql = "SELECT *, DATE_FORMAT(`dateCreation`, '%d/%m/%Y %H:%i:%s') as dateFormatee, MATCH(titre, descriptionIdee) AGAINST(:critere WITH QUERY EXPANSION) AS score FROM idee
  WHERE (publique = 1 OR idAuteur = :idUser)
  AND (idCategorie = :idCategorie  OR MATCH(titre, descriptionIdee) AGAINST(:critere WITH QUERY EXPANSION))
  ORDER BY score DESC;";
  if($ps == null){
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    $ps->bindParam(':critere', $critere, PDO::PARAM_STR);
    $ps->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);

    if($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
  return $answer;
}

//créer une nouvelle idée
function CreateIdee($titre, $descriptionIdee, $idCategorie, $publique, $dateCreation, $idAuteur){
  static $ps = null;
  $sql = "INSERT INTO `idee` (`titre`, `descriptionIdee`, `idCategorie`, `publique`, `dateCreation`, `idAuteur`) VALUES ( :titre, :descriptionIdee, :idCategorie, :publique, CURRENT_TIMESTAMP(), :idAuteur)";
  if($ps == null){
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    $ps->bindParam(':titre', $titre, PDO::PARAM_STR);
    $ps->bindParam(':descriptionIdee', $descriptionIdee, PDO::PARAM_STR);
    $ps->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $ps->bindParam(':publique', $publique, PDO::PARAM_INT);
    //$ps->bindParam(':dateCreation', $dateCreation);
    $ps->bindParam(':idAuteur', $idAuteur, PDO::PARAM_INT);

    $answer = $ps->execute();
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

//modifier les paramètres de l'idée (titre, description, catégorie, accessibilité)
function UpdateIdee($idIdee, $titre, $descriptionIdee, $idCategorie, $prive){
  static $ps = null;
  $sql = 'UPDATE idee SET titre = :titre, descriptionIdee = :descriptionIdee, idCategorie = :idCategorie, prive = :prive WHERE idIdee = :idIdee';
  if($ps == null){
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    $ps->bindParam(':idIdee', $idIdee, PDO::PARAM_INT);
    $ps->bindParam(':titre', $titre, PDO::PARAM_STR);
    $ps->bindParam(':descriptionIdee', $descriptionIdee, PDO::PARAM_STR);
    $ps->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $ps->bindParam(':prive', $prive, PDO::PARAM_INT);

    $answer = $ps->execute();
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}

//supprimer une idée
function deleteIdee($idIdee){
  static $ps = null;

  $sql = 'DELETE FROM idee WHERE idIdee = :idIdee';

  if($ps == null){
    $ps = db()->prepare($sql);
  }
  $answer = false;
  try{
    $ps->bindParam(':idIdee', $idIdee, PDO::PARAM_INT);

    $answer = $ps->execute();
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }

  return $answer;
}
*/