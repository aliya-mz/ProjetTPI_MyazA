<?PHP
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Fonction du projet
*/

//Gestion des utilisateurs - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

define("ERROR_MESSAGE", "Votre pseudo ou mot de passe est erroné");

//Retourne l'identifiant de l'utilisateur connecté
function GetIdUser(){
  if(isset($_SESSION["idUser"])){
    return $_SESSION["idUser"];
  }
  else{
    return false;
  }  
}

//Définit l'utilisateur connecté
function SetIdUser($idUser){
  $_SESSION["idUser"] = $idUser;
}

//Retourne l'indentifiant du rôle de l'utilisateur
function GetUserRole(){
  if(isset($_SESSION["idUser"])){
    //Récupérer l'utilisateur pour récupérer son rôle
    return ReadUserById($_SESSION["idUser"])["idRole"];
  }
  else{
    return 0;
  }
}

//Retourne toutes les informations de l'utilisateur
function GetUser(){
  return readUserById(GetIdUser());
}

//Vérifie que l'utilisateur (déconnecté, utilisateur ou administrateur) a le droit d'accéder à la page
function VerifyAccessibility($acceptedRole){
  if(!(GetUserRole()==$acceptedRole)){
    header('Location: index.php');
    exit;
  }

  /*
  //si elle est réservée aux déconnectés, vérifier que l'utilisateur n'est pas connecté
  if($acceptedRole = 0){
    //tester si on doit pouvoir accéder à cette page
    if(!GetIdUser()){
      header('Location: index.php');
      exit;
    }
  }
  //si la page est réservée aux utilisateurs connectés, vérifier que l'utilisateur connecté a le bon rôle (utilisateur ou adminisatrateur)
  else{
    if(GetIdUser()){
      if(!ReadUserById(GetIdUser())["idRole"]==$acceptedRole){
        header('Location: index.php');
        exit;
      }
    }
    else{
      header('Location: index.php');
      exit;
    }
  }
  */
}

//Vérifier que l'utilisateur existe et que son mot de passe est correct pour le connecter
function ConnectUser($login, $password){
  //Vérifier qu'un utilisateur avec ce pseudo existe
  if(ReadUserByUsername($login)){
    $user = ReadUserByUsername($login);

    //Vérifier le mot de passe
    if(password_verify($password, $user["password"])){     
      //enregister l'utilisateur dans la session
      SetIdUser($user["idUser"]);
      //rediriger vers la page d'accueil
      header('Location: index.php');
      exit;
    }
    else{
      //Message d'erreur
      echo ERROR_MESSAGE;
    }
  }
  else{
    //Message d'erreur
    echo ERROR_MESSAGE;
  }
}

//Inscrire l'utilisateur, en l'ajoutant dans la BD avec son mot de passe hashé
function SignUserIn($login, $firstName, $lastName, $eMail, $password){
  //hasher le mot de passe
  $password = password_hash($password, PASSWORD_DEFAULT);

  //ajouter l'utilisateur dans la BD
  createUser($login, $firstName, $lastName, $eMail, $password);

  //rediriger vers la page d'accueil
  header('Location: index.php');
  exit;
}

function ShowNavByRole(){
  //Si l'utilisateur est déconnecté, afficher le lien pour se connecter
  if(GetUserRole()==0){
    //Connexion
		echo "<li class=\"nav-item\">";
		echo "<a class=\"nav-link\" href=\"login.php\">Connexion</a>";
		echo "</li>";
    //Inscription
		echo "<li class=\"nav-item\">";
		echo "<a class=\"nav-link\" href=\"signin.php\">Inscription</a>";
		echo "</li>";
  }
  //Si c'est un utilisateur connecté, afficher les liens vers le parties calendrier, garde-robe et compte, et la déconnexion
  else if(GetUserRole()==1){
    //Lien calendrier
    echo "<li class=\"nav-item\">";
		echo "<a class=\"nav-link\" href=\"calendar.php\">Calendrier</a>";
		echo "</li>";
    
    //Liste déroulante gestion de la garde-robe
		echo "<li class=\"nav-item dropdown\">";
		echo "<a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDarkDropdownMenuLink\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">	Garde-robe </a>
          <ul class=\"dropdown-menu dropdown-menu-light\" aria-labelledby=\"navbarLightDropdownMenuLink\">
          <li><a class=\"dropdown-item\" href=\"ajouterVetement.php\">Ajouter des vêtements</a></li>
          <li><a class=\"dropdown-item\" href=\"voirMesVetements.phpm\">Voir mes vêtements</a></li>
          <li><a class=\"dropdown-item\" href=\"voirTenues\">Tenues de la semaine</a></li>
          </ul>";
		echo "</li>";

    //Modifier les informations du compte
		echo "<li class=\"nav-item\">";
		echo "<a class=\"nav-link\" href=\"updateUser.php\">Mon compte</a>";
		echo "</li>";

    //Déconnexion
		echo "<li class=\"nav-item\">";
		echo "<a class=\"nav-link\" href=\"logout.php\">Deconnexion</a>";
		echo "</li>";
  }
  //Si c'est un administrateur, afficher le lien vers la gestion des utilisateurs et la déconnexion
  else if(GetUserRole()==2){
    //Gestion des utilisateurs
    echo "<li class=\"nav-item\">";
		echo "<a class=\"nav-link\" href=\"manageUsers.php\">Gestion des utilisateurs</a>";
		echo "</li>";

    //Déconnexion
		echo "<li class=\"nav-item\">";
		echo "<a class=\"nav-link\" href=\"logout.php\">Deconnexion</a>";
		echo "</li>";
  }
}

//Affiche une liste des utilisateurs, avec un bouton supprimer
function ShowListUsers(){
  //Récupérer tous les utilisateurs dont le rôle est "utilisateur"
  $users = readUsers();

  foreach($users as $user){
    echo "<tr>";
     
    echo "<td> <div class=\"bubble\">";
    //Informations sur l'utilisateur
    echo "<div><p class=\"bubbleTitle\">".$user["login"]."</p><p>".$user["firstName"]." ".$user["lastName"]."</p></div>";    
    //Bouton supprimer
    echo "<button type=\"submit\" name=\"delete\" value=\"".$user["idUser"]."\"/><img src=\"img/delete.png\"></button>
    </div></td>";

    echo "</tr>";
  }
}

function DeleteUser($idUser){
  DeleteUserById($idUser);
}

function UpdateUser($login, $firstName, $lastName, $eMail, $password){
  //Si l'utilisateur a changé son mot de passe, hasher le nouveau mot de passe
  if(strlen($password) > 0){
    $password = password_hash($password, PASSWORD_DEFAULT);
    UpdateUserByIdWithPassword(GetIdUser(), $login, $firstName, $lastName, $eMail, $password);
    echo $password;
  }
  else{
    UpdateUserById(GetIdUser(), $login, $firstName, $lastName, $eMail);
  }
}






//Gestion du calendrier- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//Générer le calendrier et semainier ____________________________________________________________________________

//Générer un tableau à deux dimensions contenant tous les jours à afficher dans le calendrier pour le mois X de l'année X
function GetCalendarDays($month, $year){
  $days = [];

  //Créer la date du 1er du mois donné en paramètre
  $timeZone = 'Europe/Zurich';
  date_default_timezone_set($timeZone);

  $dateSrc = $year."-".$month."-01 00:00 UTC";
  $dateTime = new DateTime($dateSrc);
  
  $dateFirstOfMonth = date('d.m.Y H:i:s', strtotime($dateSrc));

  //Déterminer quel jour de la semaine est à cette date
  $date = date('Y-m-d', strtotime($dateSrc));
  $date = new DateTime($date);
  $weekDay = $date->format("w");

  //Déterminer la date du début du calendrier pour que la semaine de départ soit complète
  $daysToAdd = $weekDay-1; //ok
  $dateStart = date_create($year.'-'.$month.'-01');
  //soustraction
  date_sub($dateStart, date_interval_create_from_date_string($daysToAdd.' days'));
  
  //Affichage
  //date_format($dateStart, 'd.m.Y');


  //Parcourir tous les jours pour classer leurs dates dans un tableau de semaines
  for($w = 0; $w < 6; $w++){
    $week = [];
    for($j = 0; $j < 7; $j++){
      $day = $dateStart;
      if(!($w==$j && $w==0))
        date_add($day, date_interval_create_from_date_string('1 days'));
      array_push($week, date_format($day, 'Y-m-d'));
    }  
    array_push($days, $week);
  }
  return $days;
}

//Générer un tableau à deux dimensions contenant toutes les heures à afficher dans le semainier
function GetWeekHours(){
  $hours = [];
  for($d = 0; $d < 7; $d++){
    $day = [];
    for($h = 6; $h <= 22; $h++){
      array_push($day, $h);
    }
    array_push($hours, $day);
  }
  return $hours;
}

//Gestion des évènements_________________________________________________________________________________________

//Récupérer tous les évènements ajoutés au calendrier, compris dans les jours du mois actuellement affiché
function GetEventsBetween($dateStart, $dateEnd){
  $timestampStart = DateToTimestamp($dateStart);
  $timestampEnd = DateToTimestamp($dateEnd);

  //Rechercher dans la base de données
  $events = readEventsByTime($timestampStart, $timestampEnd);

  //$iso_date = date('c',strtotime($selected_timestamp));

  //Placer les évènements dans un tableau dont les clés sont les dates
  $dates = [];
  foreach($events as $event){
    array_push($dates, $event["theDate"]);
  }

  $classifiedEvents = array_fill_keys($dates, []);
  $countEvents = 0;
  foreach($classifiedEvents as $date => $classifiedEvent){
    array_push($classifiedEvents[$date], $events[$countEvents]);
    $countEvents += 1;
  }

  return $classifiedEvents;
}

//Récupérer tous les évènements ajoutés au semainier
function GetEventsWeekPlanner(){  
  //Rechercher dans la base de données les évènements réccurents (hebdomadaires)
  $events = readWeekPlannerEvents();

  //Placer les évènements dans un tableau dont les clés sont l'heure plus le jour de la semaine
  $hours = [];
  foreach($events as $event){
    array_push($hours, (intval(explode(":",$event["theHour"])[0]).":".intval(explode(".",$event["theDate"])[1])));
  }
 
  $classifiedEvents = array_fill_keys($hours, []);
  $countEvents = 0;
  foreach($classifiedEvents as $hour => $classifiedEvent){
    $classifiedEvents[$hour] = $events[$countEvents];
    $countEvents += 1;
  }
  return $classifiedEvents;
}

//Enregistre un évènement
function SaveEvent($isReccurent, $description, $dateStart, $dateEnd, $day){
  //Formater les dates pour les envoyer à la requête sous forme de TimeStamps
  //Evènement unique
  if($isReccurent == 0){
    $dateStart = DateToTimestamp($dateStart);
    $dateEnd = DateToTimestamp($dateEnd);
  }
  //Activité hebdomadaire
  else{
    $dateStart = HourToTimestamp($dateStart, $day);
    $dateEnd = $dateStart;
  }

  echo $dateStart. "  ";
  echo $dateEnd;
  //Créer l'évènement
  createEvent($description, $dateStart, $dateEnd, $isReccurent, GetIdUser());
}

//Supprime un évènement
function DeleteEvent($idEvent){
  //Appelle la fonction du CRUD
  DeleteEventById($idEvent);
}

//Formater la date pour la convertir en timestant mySql
function DateToTimestamp($date){
  $hour = date('h', strtotime($date));
  $minute = date('i', strtotime($date));
  $month = date('m', strtotime($date));
  $day = date('d', strtotime($date));
  $year = date('Y', strtotime($date));

  //Transformer les dates en timestamp mySQL
  $timestamp = date ('Y-m-d H:i:s', mktime ($hour, $minute, 0, $month, $day, $year));

  return $timestamp;
}

//Formater la date pour la convertir en un timestamp mySql qui ne contient que l'heure et le jour (0-6 pour les jours de la semaine)
function HourToTimestamp($date, $day){
  //Transformer les dates en timestamp mySQL
  $timestamp = date ('Y-m-d H:i:s', mktime (intval($date), 0, 0, 0, intval($day), 0));
  return $timestamp;
}

//Gérer l'affichage______________________________________________________________________________________________

//Afficher le calendrier sous forme de tableau
function DisplayMonthCalendar($month, $year){
  //Récupérer les jours et les évènements à afficher pour ce mois
  $days = GetCalendarDays($month, $year);
  $events = GetEventsBetween($days[0][0], $days[count($days)-1][count($days[0])-1]);

  //Afficher le tableau représentant le calendrier
  echo "<table class=\"table table-bordered table-light calendarTable\">";
  echo "<thead><tr>
          <th scope=\"col\">Lun.</th> <th scope=\"col\">Mar.</th> <th scope=\"col\">Mer.</th> <th scope=\"col\">Jeu.</th> <th scope=\"col\">Ven</th> <th scope=\"col\">Sam.</th> <th scope=\"col\">Dim.</th>
        </tr></thead>";
  //Afficher les jours
  echo "<tbody>";
  $lastDay = "";
  for($w = 0; $w < 6; $w++){
    echo "<tr>";
    
    for($d = 0; $d < 7; $d++){
      //Récupérer la date du jour qui correspond à la case
      $day = $days[$w][$d];

      //Grser la case si elle n'appartient pas au mois en cours
      if(explode("-", $day)[1]!=$month){
        echo "<td class=\"inactiveDay\">";
      }
      else{
        echo "<td class=\"activeDay\">";
      }

      //Afficher le jour du mois
      echo explode("-", $day)[2];

      //Afficher le nouveau mois
      if($lastDay != ""){
        if(explode("-", $day)[1]!=explode("-", $lastDay)[1]){
          echo " ".GetMonthName(intval(explode("-", $day)[1]), false);
        }
      }

      //Si des évènements existent à cette date, les afficher
      echo "<div class=\"eventsCase\">";
      if(array_key_exists($day, $events)){
        foreach($events[$day] as $event)
        DisplayEvent($event, true);
      }
      echo "</div>";

      echo "</td>";
      $lastDay = $day;
    }

    echo "</tr>";    
  }
  echo "</tbody>";
  echo "</table>";
}

//A FAIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIREEEEEEEEEEEEEEEEEEEEEEEE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//Afficher le semainier sous forme de tableau
function DisplayWeekPlanner(){
  $hours = GetWeekHours();
  $events = GetEventsWeekPlanner();

  var_dump($events);
  //Afficher le tableau du semainier
  echo "<table class=\"table table-bordered table-light calendarTable\">";
  echo "<thead><tr>
        <th scope=\"col\">Heure</th><th scope=\"col\">Lun.</th> <th scope=\"col\">Mar.</th> <th scope=\"col\">Mer.</th> <th scope=\"col\">Jeu.</th> <th scope=\"col\">Ven</th> <th scope=\"col\">Sam.</th> <th scope=\"col\">Dim.</th>
        </tr></thead>";
        
  echo "<tbody>";
  for($row = 0; $row < count($hours[0]); $row++){
    //Afficher les heures
    echo "<tr>";
    $hour = $hours[0][$row];
    echo "<td>".$hour."h</td>";
    for($col = 0; $col < count($hours); $col++){
      echo "<td>";
      //Si des évènements existent à cette date, les afficher
      //créer un identifiant avec l'heure et le jour de la semaine
      $indexCase=($col+1).":".$hours[$col][$row];
      echo "<div class=\"eventsCase\">";
      echo $indexCase;
      if(array_key_exists($indexCase, $events)){
        DisplayEvent($events[$indexCase], false);
      }
      echo "</div>";
      echo "</td>";
    }

    echo "</tr>";    
  }
  
  echo "</tbody>";
  echo "</table>";
}

//Renvoie le nom du mois en français grâce à son numéro
function GetMonthName($idMonth, $long){
  $monthLongNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
  $monthShortNames = ["Janv.", "Févr.", "Mars", "Avr.", "Mai.", "Juin", "Juill.", "Août", "Sept.", "Oct.", "Nov.", "Déc."];
  
  if($long){
    return $monthLongNames[$idMonth];
  }
  else{
    return $monthShortNames[$idMonth];
  }
}

//Affichage d'un évènement donnée
function DisplayEvent($event, $calendar){
  //Afficher les évènements, avec un bouton supprimer
  echo "<div class=\"eventBubble text-center\">";
    if($calendar){
      echo $event["theHour"]. " ";
    }
    echo $event["description"]
        ."<button type=\"submit\" name=\"delete\" value=\"".$event["idEvent"]."\"/><img src=\"img/delete.png\"></button>
        </div>";
}






//Gestion garde-robe - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

//Gestion du formulaire___________________________________________________________________________________________

//Retourne la liste des catégories de vêtements
function GetCategories(){

  return [];
}

//Retourne la liste des catégories météo
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

function GenerateRandomString($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

//Création de tenues______________________________________________________________________________________________

//Définir les groupes de vêtements pour pouvoir les assembler en tenues
$groups = [
  "Hauts" => [],
  "Bas" => [],
  "Combinaisons" => [],
  "Vestes et manteaux" => [],
  "Chaussures" => []
];

function GenerateDress($temperature, $weather){
  //Recherche les vêtements appartenant à un groupe (hauts, bas ou combinaisons)


  //Retourner l'ensemble des vêtements de la tenue générée
  return [];
}

//Affichage_______________________________________________________________________________________________________

//Créer fichier à partir de vêtement BD (couleur et script SVG) avec nom correspondant à idVetement - en cours
function CreateClotheImage($idCategory, $color){
  //Créer un fichier SVG en reprenant le modèle pour ce type de vêtement dans la base de données
  $path = GenerateRandomString(10).".svg";
  $file = fopen($path, "c+b");

  //Récupérer le script du fichier dans la BD
  $script = GetCategories()[$idCategory]["is_template"];
  
  //Modifier la couleur par celle choisie par l'utilisateur
  $aModifier = "";
  $script = preg_replace($aModifier, $color, $file);

  //Retourner l'adresse du fichier
  return $path;
}

//Afficher svg correspondant à idVetement
function DisplayClotheImage($cheminFichier){
  echo "<img src=\"$cheminFichier\" alt=\"icône du vêtement enregistré\"/>";
}

//Afficher une tenue complète, avec le résumé des vêtements
function DisplayDress($dress){
}






//Gestion de la météo- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
