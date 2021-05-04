<?PHP
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Fonction du projet
*/

//Gestion des utilisateurs - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

function GetIdUser(){
  if(isset($_SESSION["idUtilisateur"])){
    return $_SESSION["idUtilisateur"];
  }
  else{
    return false;
  }  
}

//Vérifie qu'un utilisateur est connecté
function VerifyAccessibility($connecte){
  //si la page est réservée aux utilisateurs connectés, vérifier qu'un utilisateur est connecté, sinon renvoyer à l'accueil
  if($connecte){
    if(!isset(GetIdUser())){
      header('Location: index.php');
      exit;
    }
  }
  //si elle est réservée aux déconnectés, vérifier que l'utilisateur n'est pas connecté, sinon renvoyer à l'accueil
  else{
    //tester si on doit pouvoir accéder à cette page
    if(isset(GetIdUser())){
      header('Location: index.php');
      exit;
    }
  }
}




//Gestion garde-robe - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

//Gestion du formulaire_________________________________________________________
function GetCategories(){

  return [];
}

function GetWeathers(){

  return [];
}

//Afficher les type de vêtements de la BD dans une liste déroulante
function CategoriesToSelect($categorySelected){
  $categories = GetCategories();

  echo "<select name=\"category\">";
  //parcourir les types de la BD et les afficher
  foreach($categories as $category){
    //si le type est celui sélecionnée précédemment (sticky), le re-sélectionner
    if($category["idCategory"] == $categorySelected){
      echo "<option value=\"".$category["idCategory"]."\" selected>".$category["name"]."</option>";
    }
    else{
      echo "<option value=\"".$category["idCategory"]."\">".$category["name"]."</option>";
    }
  }
  echo "</select>";
}

//Afficher les catégories météo de la BD dans une liste déroulante
function WeathersToSelect($weatherSelected){
  $weathers = GetWeathers();
  echo "<select name=\"categorieVetement\">";
  //parcourir les catégories de la BD et les afficher
  foreach($weathers as $weather){
    //si la catégorie est celle sélecionnée précédemment (sticky), la re-sélectionner
    if($weather["idWeather"] == $weatherSelected){
      echo "<option value=\"".$weather["idWeather"]."\" selected>".$weather["name"]."</option>";
    }
    else{
      echo "<option value=\"".$weather["idWeather"]."\">".$weather["name"]."</option>";
    }
  }
  echo "</select>";
}

//Enregistrer un vêtement dans la BD
function EnregistrerVetement($name, $idCategory, $color, $idWeather, $tempMin, $tempsMax){
   //Insert dans la BD
   CreateClothe($name, $idCategory, $color, $idWeather, $tempMin, $tempsMax, GetIdUser());
}

/*A FAIRE*/
function GenererNomRandom(){
  return "abc";
}


//Création de tenues_____________________________________________________________

//Définir les groupes de vêtements pour pouvoir les assembler en tenues
$groups = [
  "hauts" => [],
  "bas" => [],
  "combinaisons" => [],
  "vestes et manteaux" => [],
  "chaussures" => []
];

function GenerateDress($temperature, $weather){
  //Recherche les vêtements appartenant à un groupe (hauts, bas ou combinaisons)


  //Retourner l'ensemble des vêtements de la tenue générée
  return [];
}


//Affichage______________________________________________________________________

//Créer fichier à partir de vêtement BD (couleur et script SVG) avec nom correspondant à idVetement - en cours
function CreateClotheImage($idCategory, $color){
  //Créer un fichier SVG en reprenant le modèle pour ce type de vêtement dans la base de données
  $chemin = GenererNomRandom().".svg";
  $fichier = fopen($chemin, "c+b");

  //Récupérer le script du fichier dans la BD
  $script = GetCategories($idType)["is_template"];
  
  //Modifier la couleur par celle choisie par l'utilisateur
  $aModifier = "";
  $script = preg_replace($aModifier, $couleur, $fichier);

  //Retourner l'adresse du fichier
  return $chemin;
}

/*A FAIRE*/
//Afficher svg correspondant à idVetement
function DisplayClotheImage($cheminFichier){
  echo "<img src=\"$cheminFichier\" alt=\"icône du vêtement enregistré\"/>";
}

//Afficher une tenue complète, avec le résumé des vêtements
function DisplayDress($dress){
}





//Gestion du calendrier- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//Générer le calendrier et semainier _____________________________________________

//Générer un tableau à deux dimensions contenant tous les jours à afficher dans le calendrier pour le mois X de l'année X
function GetCalendarDays($month, $year){
  $days = [];

  return $days;
}

//Générer un tableau à deux dimensions contenant toutes les heures à afficher dans le semainier
function GetWeekHours(){
  $days = [];

  return $days;
}

//Gestion des évènements__________________________________________________________

//Récupérer tous les évènements ajoutés au calendrier, compris dans les jours du mois actuellement affiché
function GetEventsBetween($dateStart, $dateEnd){
  $timestampStart = DateToTimestamp($dateStart);
  $timestampEnd = DateToTimestamp($dateEnd);

  //Rechercher dans la base de données
  $events = readEventsByTime($timestampStart, $timestampEnd);
  return $events;
}

//Récupérer tous les évènements ajoutés au semainier
function GetEventsWeekPlanner(){  
  //Rechercher dans la base de données les évènements réccurents (hebdomadaires)
  $events = readWeekPlannerEvents();
  return $events;
}

//Affichage des évènements dans un intervalle de temps donnée 
function DisplayEvent($event){
  //Afficher les évènements

  //[echo de HTML]
}

//Affichage des évènements dans un intervalle de temps donnée 
function SaveEvent($isReccurent, $description, $dateStart, $dateEnd){
  //Formater les dates pour les envoyer à la requête sous forme de TimeStamps
  //Si c'est un évènement unique
  if($isReccurent == -1){
    $dateStart = DateToTimestamp($dateStart);
    $dateEnd = DateToTimestamp($dateEnd);
  }
  //Si c'est un évènement hebdomadaire
  else{
    $dateStart = HourToTimestamp($dateStart);
    $dateEnd = HourToTimestamp($dateEnd);
  }

  //Créer l'évènement
  createEvent($description, $dateStart, $dateEnd, $isReccurent, GetIdUser());
}

//Formater la date pour la convertir en timestant mySql
function DateToTimestamp($date){
  $hour = date('h', strtotime($date));
  $minute = date('i', strtotime($date));
  $month = date('m', strtotime($date));
  $day = date('d', strtotime($date));
  $year = date('Y', strtotime($date));

  //Transformer les dates en timestamp mySQL
  $timestamp = date ('Ymd H: i: s', mktime ($hour, $minute, 0, $month, $day, $year));

  return $timestamp;
}

//Formater la date pour la convertir en un timestamp mySql qui ne contient que l'heure et le jour (0-6 pour les jours de la semaine)
function HourToTimestamp($date){
  $hour = date('h', strtotime($date));
  $minute = date('i', strtotime($date));
  $day = date('d', strtotime($date));

  //Transformer les dates en timestamp mySQL
  $timestamp = date ('Ymd H: i: s', mktime ($hour, $minute, 0, 0, $day, 0));
  return $timestamp;
}


//Gérer l'affichage________________________________________________________________

//Afficher le calendrier sous forme de tableau. Chaque jour est une case, chaque ligne une semaine (tableau 6x7)
function DisplayMonthCalendar($month, $year){
  $days = GetCalendarDays($month, $year);
  //Afficher le tableau de jours généré grâce à au mois actuel
  //[...]

  //A chaque fois que dans le tableau, on rencontre une date identique à un évènement, afficher l'évènement dedans
  //[...]
}

//Afficher le semainier sous forme de tableau, contenant 7 jours et différentes heures de la journée, avec les évènements qui y sont inscrits.
function DisplayWeekPlanner(){
  $hours = GetWeekHours();
  $event = GetEventsWeekPlanner();

  //Afficher le tableau du semainier avec les évènements récupérés
  //[...]
}





//Gestion de la météo- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -





































/*
function ideesToHtmlTable($idees, $mesIdees, $favoris){
    $note = "";

    echo "<tbody>";
    //afficher chaque idée, afficher chaque champs de l'idée
    foreach($idees as $idee) {
      //récupérer la note de l'idée
      $note = readNoteByIdeeIdAndUser($idee["idIdee"], $_SESSION["idUser"]);
      echo "<tr>";

          //fabrication du conteneur avec des flexbox
          echo "<td>";
          echo "<div class=\"conteneurIdee\">
          <div class=\"en-teteIdee\"><div>".$idee['titre']."</div><div>".$idee['dateFormatee']."</div></div>
          <div class=\"corpsIdee\">
          <div id=\"categorie\">Catégorie :".readCategorieById($idee['idCategorie'])["nom"]."</div>
          <div id=\"description\">".$idee['descriptionIdee']."</div>
          <div id=\"tags\">";
          //afficher tous les tags
          $tags = getTagsById($idee['idIdee']);
          foreach ($tags as $tag) {
            echo "<label class=\"taglabel\">".$tag["mot"]."</label>";
          }
          echo "</div></div>";      

        echo "</tr>";
      }
    echo "</tbody>";
}
*/