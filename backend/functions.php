<?PHP
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Fonctions du projet
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

function GetIdUserToUpdate($idUser){
  $user = "";
  //Récupérer le mois envoyé en paramètre
  if(isset($idUser)){
    if(GetUser($idUser)!=null){
      $user = $idUser;
    }
    //Si le paramètre est erroné, quitter
    else{
      header('Location: manageUsers.php');
      exit;
    }
  }
  //Si le paramètre n'existe pas, quitter
  else{
    //header('Location: manageUsers.php');
    //exit;
  }
  return $user;
}

function GetUserToUpdate($idUser){
  return readUserById(GetIdUserToUpdate($idUser));
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
function VerifyAccessibility($acceptedRoles){
  //Si l'un des rôles envoyés en paramètre est connecté, rester sur la page
  $accepted = false;
  foreach($acceptedRoles as $acceptedRole){
    if(GetUserRole()==$acceptedRole){
      $accepted = true;
    }
  } 
  if(!$accepted){
    //header('Location: index.php');
    exit;
  }
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

  //Si c'est un administrateur, rediriger vers la gestion des utilisateurs
  if(GetUserRole()==2){
    header('Location: manageUsers.php');
    exit;
  }
  //rediriger vers la page d'accueil
  header('Location: index.php');
  exit;
}

//Affiche une barre de navigation pour la page principale, contenant les liens adaptés au rôle de l'utilisateur
function ShowNavByRole(){
  //Si l'utilisateur est déconnecté, afficher le lien pour se connecter
  if(GetUserRole()==0){
    echo '<ul class="nav flex-column">';
    //Connexion
    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"login.php\">Connexion</a></li>";
    //Inscription
    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"signin.php\">Inscription</li>";
    echo '</ul>';
  }
  //Si c'est un utilisateur connecté, afficher les liens vers le parties calendrier, garde-robe et compte, et la déconnexion
  else if(GetUserRole()==1){
  echo '<ul class="nav flex-column">';
  //Modifier les informations du compte
  echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"updateUser.php\"><img class=\"smallIconButton\" src=\"img/account.png\"/></a></li>";
  //Déconnexion
  echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"logout.php\"><img class=\"smallIconButton\" src=\"img/logout.png\"/></a></li>";
  echo '</ul>';
  //Gestion des vêtements
  echo'<h6 class="sidebar-heading d-flex justify-content-start align-items-center px-3 mt-4 mb-1 text-muted marginElements">
        <span><img src="img/clothe.png" alt="" class="mIconButton"></span> <span>Garde-robe</span>
       </h6>
       <ul class="nav flex-column mb-2">
        <li class="nav-item"><a class="nav-link" href="manageClothes.php">Voir ma garde-robe</a></li>
        <li class="nav-item"><a class="nav-link" href="addClothe.php">Ajouter un vêtement</a></li>
       </ul>';
  echo'<h6 class="sidebar-heading d-flex justify-content-start align-items-center px-3 mt-4 mb-1 text-muted marginElements">
        <span><img src="img/calendar.png" alt="" class="mIconButton"></span> <span>Calendrier</span>
       </h6>
       <ul class="nav flex-column mb-2">
        <li class="nav-item"><a class="nav-link" href="calendar.php">Calendrier</a></li>
        <li class="nav-item"><a class="nav-link" href="weeklyPlanner.php">Semainier</a></li>
       </ul>';
  }
  //Si c'est un administrateur, afficher le lien vers la gestion des utilisateurs et la déconnexion
  else if(GetUserRole()==2){
    echo '<ul class="nav flex-column">';
    //Dénnexion
    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"logout.php\"><img class=\"smallIconButton\" src=\"img/logout.png\"/></a></li>";
    //Gestion des utilisateurs
    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"manageUsers.php\">Gestion des utilisateurs</li>";
    echo '</ul>';
  }
}

//Affiche une liste des utilisateurs, avec un bouton supprimer
function ShowListUsers(){
  //Récupérer tous les utilisateurs dont le rôle est "utilisateur"
  $users = readUsers();

  foreach($users as $user){
    echo "<tr>";
     
    echo "<td> <div class=\"userBubble eventBubble\">";
    //Informations sur l'utilisateur
    echo "<div><p class=\"bubbleTitle\">".$user["login"]."</p><p>".$user["firstName"]." ".$user["lastName"]."</p></div>";    
    //Bouton supprimer
    echo "<div class=\"bubbleButtons\"><button type=\"submit\" name=\"delete\" value=\"".$user["idUser"]."\"/><img src=\"img/delete.png\"></button>
          <button type=\"submit\" name=\"modify\" value=\"".$user["idUser"]."\"/><img src=\"img/update.png\"></button></div>
    </div></td>";
    
    echo "</tr>";
  }
}

//Supprime un utilisateur en fonction de son indentifiant
function DeleteUser($idUser){
  DeleteUserById($idUser);
}

//Met à jour les informations de l'utilisateur en appelant le CRUD
function UpdateUser($login, $firstName, $lastName, $eMail, $password, $idUserToUpdate){
  //Si l'utilisateur a changé son mot de passe, hasher le nouveau mot de passe
  if(strlen($password) > 0){
    $password = password_hash($password, PASSWORD_DEFAULT);
    if(GetUserRole()==1){
      UpdateUserByIdWithPassword(GetIdUser(), $login, $firstName, $lastName, $eMail, $password);
    }
    else{
      UpdateUserByIdWithPassword($idUserToUpdate, $login, $firstName, $lastName, $eMail, $password);
    }
    
    echo $password;
  }
  else{
    if(GetUserRole()==1){
      UpdateUserById(GetIdUser(), $login, $firstName, $lastName, $eMail);
    }
    else{
      UpdateUserById($idUserToUpdate, $login, $firstName, $lastName, $eMail);
    }
  }
}






//Gestion du calendrier- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//Générer le calendrier et semainier ____________________________________________________________________________

function GetDay($idDay){
  $day = "";
  //Récupérer le mois envoyé en paramètre
  if(isset($idDay)){
    if(intval($idDay) <= 6 && intval($idDay) >= 0){
      $day = $idDay;
    }
    //Si le paramètre est erroné, quitter
    else{
      header('Location: weeklyPlanner.php');
      exit;
    }
  }
  //Si le paramètre n'existe pas, quitter
  else{
    header('Location: weeklyPlanner.php');
      exit;
  }
  return $day;
}

function GetHour($idHour){
  $hour = "";
  //Récupérer le mois envoyé en paramètre
  if(isset($idHour)){
    if(intval($idHour) <= 20 && intval($idHour) >= 6){
      $hour = intval($idHour);
      if($hour<10){
        $hour = "0".$hour;
      }
    }
    //Si le paramètre est erroné, quitter
    else{
      header('Location: weeklyPlanner.php');
      exit;
    }
  }
  //Si le paramètre n'existe pas, quitter
  else{
    header('Location: weeklyPlanner.php');
    exit;
  }
  return $hour;
}

function GetYear($idYear){
  $year = "";
  //Récupérer l'année envoyée en paramètre
  if(isset($idYear)){
    if(intval($idYear) <= 2050 && intval($idYear) >= 1970){
      $year = intval($idYear);
    }
    //Si le paramètre est erroné, afficher l'année actuelle
    else{
      $year=date("Y");
    }
  }
  //Si le paramètre n'existe pas, l'année affichée est l'année actuelle
  else{
    $year=date("Y");
  }
  return $year;
}

function GetMonth($idMonth){
  $month = "";
  //Récupérer le mois envoyé en paramètre
  if(isset($idMonth)){
    if(intval($idMonth) <= 12 && intval($idMonth) >= 1){
      $month = intval($idMonth);
      if($month<10){
        $month = "0".$month;
      }
    }
    //Si le paramètre est erroné, le mois affiché est le mois actuel
    else{
      $month=date("m");
    }
  }
  //Si le paramètre n'existe pas, le mois affiché est le mois actuel
  else{
    $month=date("m");
  }
  return $month;
}

function GetLastMonth($theMonth, $theYear){
  if(intval($theYear) >= 1970){
    if(intval($theMonth) <= 1){
      $theMonth = 12;
    }
    else{
      $theMonth -= 1;
    }
  }  
  return $theMonth;
}

function GetNextMonth($theMonth, $theYear){
  if(intval($theYear) <= 2050){
    if(intval($theMonth) >= 12){
      $theMonth = 1;
    }
    else{
      $theMonth += 1;
    }
  }  
  return $theMonth;
}

function GetLastMonthsYear($theMonth, $theYear){
  if(intval($theMonth) == 1 && intval($theYear) > 1970){
    $theYear = intval($theYear) - 1;
  }
  return $theYear;
}

function GetNextMonthsYear($theMonth, $theYear){
  if(intval($theMonth) == 12 && intval($theYear) <= 2050){
    $theYear = intval($theYear) + 1;
  }
  return $theYear;
}

//Générer un tableau à deux dimensions contenant tous les jours à afficher dans le calendrier pour le mois X de l'année X
function GetCalendarDays($month, $year){
  $days = [];

  //Créer la date du 1er du mois donné en paramètre
  $timeZone = 'Europe/Zurich';
  date_default_timezone_set($timeZone);

  $dateSrc = $year."-".$month."-01 00:00";
  //$dateTime = new DateTime($dateSrc);  
  //$dateFirstOfMonth = date('d.m.Y H:i:s', strtotime($dateSrc));

  //Déterminer quel jour de la semaine est à cette date
  $date = date('Y-m-d', strtotime($dateSrc));
  $date = new DateTime($date);
  $weekDay = $date->format("w");

  //Déterminer la date du début du calendrier pour que la semaine de départ soit complète
  $daysToAdd = $weekDay-1;
  //Recommencer la semaine depuis la fin
  if($daysToAdd == -1){
    $daysToAdd = 6;
  }

  $dateStart = date_create($year.'-'.$month.'-01');
  //Soustraction
  date_sub($dateStart, date_interval_create_from_date_string($daysToAdd.' days'));
  
  //Parcourir tous les jours pour classer leurs dates dans un tableau de semaines
  for($w = 0; $w < 6; $w++){
    $week = [];
    for($d = 0; $d < 7; $d++){
      $day = $dateStart;
      if(!($w==$d && $w==0))
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
    for($h = 6; $h <= 20; $h++){
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
  $events = readEventsByTime($timestampStart, $timestampEnd, GetIdUser());

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

  //var_dump($classifiedEvents);


  return $classifiedEvents;
}

//Récupérer tous les évènements ajoutés au semainier
function GetEventsWeekPlanner(){  
  //Rechercher dans la base de données les évènements réccurents (hebdomadaires)
  $events = readWeekPlannerEvents(GetIdUser());

  //Placer les évènements dans un tableau dont les clés sont l'heure plus le jour de la semaine
  $hours = [];
  foreach($events as $event){
    array_push($hours, (intval(explode(":",$event["theHour"])[0]).":".intval(explode(".",$event["theDate"])[0])));
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
function SaveEvent($isReccurent, $description, $dateStart, $dateEnd, $hour, $day){
  //Formater les dates pour les envoyer à la requête sous forme de TimeStamps
  //Evènement unique
  if($isReccurent == 0){
    $dateStart = DateToTimestamp($dateStart);
    $dateEnd = DateToTimestamp($dateEnd);
  }
  //Activité hebdomadaire
  else{
    $dateStart = HourToTimestamp($hour, $day);
    $dateEnd = $dateStart;

    //Supprimer l'activité qui occupe déjà cet horaire, s'il existe
    DeleteEventByTime($dateStart, GetIdUser());
  }
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
  $hour = date('H', strtotime($date));
  $minute = date('i', strtotime($date));
  $month = date('m', strtotime($date));
  $day = date('d', strtotime($date));
  $year = date('Y', strtotime($date));

  //Transformer les dates en timestamp mySQL
  $timestamp = date ('Y-m-d H:i:s', mktime ($hour, $minute, 0, $month, $day, $year));

  return $timestamp;
}

//Formater la date pour la convertir en un timestamp mySql qui ne contient que l'heure et le jour (0-6 pour les jours de la semaine)
function HourToTimestamp($hour, $day){
  //Transformer les dates en timestamp mySQL
  $timestamp = date ('Y-m-d H:i:s', mktime (intval($hour), 0, 0, 1, intval($day), 2000));
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

      //Griser la case si elle n'appartient pas au mois en cours
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

      //Si le jour est le jour actuel ou l'un des deux jours suivants, afficher la météo
      $actualDate = date_create(date('Y-m-d'));     
      //echo $day . " == ".$actualDate->format('Y-m-d'). " ; ";

      if($day == date_add($actualDate, date_interval_create_from_date_string('0 days'))->format('Y-m-d')){
        DisplayMeteoSummary(0);
      }
      else if($day == date_add($actualDate, date_interval_create_from_date_string('1 days'))->format('Y-m-d')){
        DisplayMeteoSummary(1);
      }
      else if($day == date_add($actualDate, date_interval_create_from_date_string('1 days'))->format('Y-m-d')){
        DisplayMeteoSummary(2);
      }
      else if($day == date_add($actualDate, date_interval_create_from_date_string('1 days'))->format('Y-m-d')){
        DisplayMeteoSummary(3);
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

//Afficher le semainier sous forme de tableau
function DisplayWeekPlanner(){
  $hours = GetWeekHours();
  $events = GetEventsWeekPlanner();
  //Afficher le tableau du semainier
  echo "<table class=\"table table-bordered table-light calendarTable\">";
  echo "<thead><tr>
        <th scope=\"col\" class=\"rowTitle\">Heure</th><th scope=\"col\">Lun.</th> <th scope=\"col\">Mar.</th> <th scope=\"col\">Mer.</th> <th scope=\"col\">Jeu.</th> <th scope=\"col\">Ven</th> <th scope=\"col\">Sam.</th> <th scope=\"col\">Dim.</th>
        </tr></thead>";
        
  echo "<tbody>";
  for($row = 0; $row < count($hours[0]); $row++){
    //Afficher les heures
    echo "<tr>";
    $hour = $hours[0][$row];
    echo "<td class=\"rowTitle\">".$hour."h</td>";
    for($col = 0; $col < count($hours); $col++){
      echo "<td>";
      //Bouton ajouter une activité à cette heure
      echo '<a href="newEventWeekly.php?day='.($col+1).'&hour='.$hours[$col][$row].'" class="addEventHour"><img class="smallIconButton" src="/img/addReminder.png"/></a>';

      //Si des évènements existent à cette date, les afficher
      //créer un identifiant avec l'heure et le jour de la semaine
      $indexCase=$hours[$col][$row].":".($col+1);
      echo "<div class=\"eventsCase\">";
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
    return $monthLongNames[$idMonth-1];
  }
  else{
    return $monthShortNames[$idMonth-1];
  }
}

//Affichage d'un évènement donnée
function DisplayEvent($event, $calendar){
  //Afficher les évènements, avec un bouton supprimer
  echo "<div class=\"eventBubble\">";
    if($calendar){
      echo $event["theHour"]. " ";
    }
    echo $event["description"]
        ."<button type=\"submit\" name=\"delete\" value=\"".$event["idEvent"]."\"/><img src=\"img/delete.png\"></button>
        </div>";
}






//Gestion garde-robe - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

//Définir les groupes de vêtements pour pouvoir les assembler en tenues
DEFINE("CLOTHES_GROUPS", ["Haut", "Bas", "Ensemble", "Exterieur", "Chaussures"]);

//Gestion du formulaire___________________________________________________________________________________________

//Retourne l'identifiant du vêtement à modifier
function GetClothe($idClothe){
  $id = 0;
  //Récupérer le jour envoyé en paramètre
  if(isset($idClothe)){
    $id = $idClothe;
  }
  //Si le paramètre n'existe pas, quitter
  else{
    header('Location: manageClothes.php');
    exit;
  }
  //Récupérer le vêtement correspondant à l'identifiant
  $clothe = ReadClotheById($id);
  //Si le vêtement n'existe pas, quitter
  if(!array_key_exists("idClothe", $clothe)){
    header('Location: manageClothes.php');
    exit;    
  }
  //Si le vêtement n'appartient pas à l'utilisateur, quitter
  else{
    if($clothe["idUser"]!=GetIdUser()){
      header('Location: manageClothes.php');
      exit;
    }
  }
  return $clothe;
}

//Retourne la liste des catégories de vêtements
function GetCategories(){
  return readCategories();
}

//Retourne la catégorie correspondant à l'id
function GetCategory($idCategory){
  return readCategoryById($idCategory);
}

//Retourne la liste des catégories météo
function GetWeathers(){
  return readWeathers();
}

//Afficher les type de vêtements de la BD dans une liste déroulante
function CategoriesToSelect($categories, $categorySelected){
  echo "<select name=\"categoryClothe\">";
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
function WeathersToSelect($weathers, $weatherSelected){
  echo "<select name=\"groupWeather\">";
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
function SaveClothe($name, $idCategory, $idWeather, $color, $tempMin, $tempsMax){
   //Insert dans la BD
   CreateClothe($name, $idCategory, $idWeather, $color, $tempMin, $tempsMax, GetIdUser());
   echo $name . " ". $idCategory. " " .$idWeather. " " .$color. " " .$tempMin. " " .$tempsMax. " " .GetIdUser();
}

//Supprime le vêtement correspondant à l'ID en appelant le CRUD
function DeleteClothe($idClothe){
  DeleteClotheById($idClothe);
}

//Création de tenues______________________________________________________________________________________________

DEFINE("MAIN_ERROR", "Vous feriez bien d'obtenir des vêtements");
DEFINE("COAT_ERROR", "Vous feriez bien d'obtenir un manteau");
DEFINE("SHOES_ERROR", "Vous feriez bien d'obtenir des chaussures");

//Génère une tenue complète en fonction de la météo
function GenerateDress($temperatures, $weathers){
  //Récupérer un tableau de listes pour chaque groupe de vêtement, correspondant à la météo du jour
  $clothesForMeteo = GetClothesForMeteo($temperatures, $weathers);
  
  $dress = [];
  //Sélectionner aléoirement un haut+bas ou un ensemble (Chance de tomber sur un haut par rapport à un ensemble égale à la proportionnalité de hauts dans l'ensemble des hauts et des ensembles)
  if(count($clothesForMeteo["Exterieur"])!=0 && count($clothesForMeteo["Bas"])!=0 && $clothesForMeteo["Bas"]){
    //S'il y a des hauts et des ensemble qui correspondent à la météo
    if(rand(0, count($clothesForMeteo["Haut"])+count($clothesForMeteo["Ensemble"]))<count($clothesForMeteo["Ensemble"])){
      //Sélectionner un haut et un bas
      $top = $clothesForMeteo["Haut"][rand(0, count($clothesForMeteo["Haut"])-1)]["idClothe"];
      $bottom = $clothesForMeteo["Bas"][rand(0, count($clothesForMeteo["Bas"])-1)]["idClothe"];
      array_push($dress, $top);
      array_push($dress, $bottom);     
    }
    else{
      //Sélectionner un ensemble
      $both = $clothesForMeteo["Ensemble"][rand(0, count($clothesForMeteo["Ensemble"])-1)]["idClothe"];
      array_push($dress, $both);
    }
  }
  ///S'il y a uniquement des hauts qui correspondent, et qu'il y a aussi des bas, sélectionner un haut et un bas
  else if(count($clothesForMeteo["Haut"])!=0 && count($clothesForMeteo["Bas"])!=0){
    $top = $clothesForMeteo["Haut"][rand(0, count($clothesForMeteo["Haut"])-1)]["idClothe"];
    $bottom = $clothesForMeteo["Bas"][rand(0, count($clothesForMeteo["Bas"])-1)]["idClothe"];
    array_push($dress, $top);
    array_push($dress, $bottom);
  }
  //S'il y a uniquement des ensembles qui correspondent
  else if(count($clothesForMeteo["Ensemble"])!=0){    
    //Si seul un vêtement existe dans cette catégorie, le prendre
    if(count($clothesForMeteo["Ensemble"]) == 1){
      $both = $clothesForMeteo["Ensemble"][0]["idClothe"];
    }
    //Sinon, choisir avec un random
    else{
      $both = $clothesForMeteo["Ensemble"][rand(0, count($clothesForMeteo["Ensemble"])-1)]["idClothe"];
    }
    array_push($dress, $both);
  }
  //Si aucun ne correspond, erreur
  else{
    array_push($dress, MAIN_ERROR);
  }

  //Vérifier s'il y a des chaussures, si oui en sélectionner une paire au hasard
  if(count($clothesForMeteo["Chaussures"])!=0){
    $shoes = $clothesForMeteo["Chaussures"][rand(0, count($clothesForMeteo["Chaussures"])-1)]["idClothe"];
    array_push($dress, $shoes);
  }
  else{
    array_push($dress, SHOES_ERROR);
  }

  //Vérifier s'il y a des vestes/manteaux, si oui en sélectionner un au hasard
  if(count($clothesForMeteo["Exterieur"])!=0){
    $outwear = $clothesForMeteo["Exterieur"][rand(0, count($clothesForMeteo["Exterieur"])-1)]["idClothe"];
    array_push($dress, $outwear);
  }
  //Si n'y en a pas
  else{
    //Si le matin est passé et qu'il fait froid maintenant, erreur
    if(count($temperatures)<5){
      if($temperatures[0]<=10){
        array_push($dress, COAT_ERROR);
      }
    }
    //Sinon, s'il fait froid le matin, erreur
    else{
      if($temperatures[2]<=8 && $temperatures[3]<=10){
        array_push($dress, COAT_ERROR);
      }
    }    
  }

  //Retourner l'ensemble des vêtements de la tenue générée sous forme de tableau
  return $dress;
}

function GetClothesForMeteo($temperatures, $weathers){
  //Traiter les information météo de toute la journée pour récupérer ce qui est important à la création de la tenue
  //Faire la moyenne des température de la journée
  $minTemp = $temperatures[0];
  $maxTemp = $temperatures[0];
  $sum = 0;
  foreach($temperatures as $temperature){
    $sum += $temperature;
  }
  $temperature = round($sum / count($temperatures));

  $weatherPriority = false;
  //Récupérer les temps particuliers de la journée (neige, pluie, normal)
  foreach($weathers as $weather){
    //Il neige
    if($weather == "Snow"){
      $weatherPriority = "Neige";
    }
    //Il pleut
    else if($weather == "Rain" || $weather == "Thuderstorm"){
      if($weatherPriority != "Neige"){
        $weatherPriority = "Pluie";
      }      
    }
    //Il y a du soleil ou des nuages
    else{
      if($weatherPriority != "Neige" && $weatherPriority != "Pluie"){
        $weatherPriority = "Normal";
      }
    }
  }

  //Créer un tableau avec tous les vêtements possibles pour cette météo (neige prioritaire), classés par catégorie
  $clothesForMeteo = [
    CLOTHES_GROUPS[0] => ReadClothesByMeteoAndCategorie($temperature, $weatherPriority, CLOTHES_GROUPS[0]),
    CLOTHES_GROUPS[1] => ReadClothesByMeteoAndCategorie($temperature, $weatherPriority, CLOTHES_GROUPS[1]),
    CLOTHES_GROUPS[2] => ReadClothesByMeteoAndCategorie($temperature, $weatherPriority, CLOTHES_GROUPS[2]),
    CLOTHES_GROUPS[3] => ReadClothesByMeteoAndCategorie($temperature, $weatherPriority, CLOTHES_GROUPS[3]),
    CLOTHES_GROUPS[4] => ReadClothesByMeteoAndCategorie($temperature, $weatherPriority, CLOTHES_GROUPS[4])
  ];

  return $clothesForMeteo;
}

//Affichage_______________________________________________________________________________________________________

//Créer fichier à partir de vêtement BD (couleur et script SVG) avec nom correspondant à idVetement
function CreateClotheImage($idCategory, $color){
  //Créer un fichier SVG dans le dossier img
  $path = "img/clothesImg/".GenerateRandomString(10).".svg";
  $file = fopen($path, "c+b");

  //Récupérer le script du fichier dans la BD
  $script = GetCategory($idCategory)["isTemplate"];

  //Modifier la couleur par celle choisie par l'utilisateur
  $aModifier = "PLACE_COLOR";
  $script = str_replace($aModifier, $color, $script);

  //écrire le script créé dans le fichier
  fwrite($file, $script);

  fclose($file);
  
  //Retourner l'adresse du fichier
  return $path;
}

//Supprimer toutes les images crées
function DeleteClothesImages(){
  $files = glob('img/clothesImg/*'); // get all file names
  foreach($files as $file){
    if(is_file($file))
      unlink($file);
  }
}

//Afficher une tenue complète adaptée à la météo
function DisplayDress($temperature, $weather){
  $dress = GenerateDress($temperature, $weather);
  
  foreach($dress as $idClothe){
    if(is_numeric($idClothe))
    DisplayClothe(GetClothe($idClothe));
    else
    DisplayEmptyClothe($idClothe);
  }
}

//Afficher tous les vêtements de l'utilisateur
function DisplayClothesList(){
  $clothes = ReadClothesByUser(GetIdUser());
  foreach($clothes as $clothe){
    DisplayClotheWithControls($clothe);
  }
}

//Afficher un vêtement
function DisplayClothe($clothe){
  $imagePath = CreateClotheImage($clothe["idCategory"], $clothe["color"]);
  
  echo "<div class=\"eventBubble clothesBubble\">"
        ."<div class=\"displayClothe\">"
        .$clothe["name"]
        ."<img class=\"clotheImage\" src=\"".$imagePath."\"/>
        </div>
        </div>";
}

//Afficher un vêtement avec les contrôles (modifier et supprimer)
function DisplayClotheWithControls($clothe){
  $imagePath = CreateClotheImage($clothe["idCategory"], $clothe["color"]);
  
  echo "<div class=\"eventBubble clothesBubble\">"
        ."<div class=\"displayClothe\">"
        .$clothe["name"]
        ."<img class=\"clotheImage\" src=\"".$imagePath."\"/>
        </div>
        <div class=\"displayButtons\"><button type=\"submit\" name=\"delete\" value=\"".$clothe["idClothe"]."\"/><img src=\"img/delete.png\"></button>
        <button type=\"submit\" name=\"update\" value=\"".$clothe["idClothe"]."\"/><img src=\"img/update.png\"></button></div>
        </div>";
}

//Afficher une case vide avec un message d'erreur pour un vêtement nécessaire non existant
function DisplayEmptyClothe($idClothe){
  echo "<div class=\"eventBubble clothesBubble text-center\">"
        ."<div class=\"displayClothe\">"
        .$idClothe
        ."</div>
        </div>";
}

//Génère un string aléatoire pour nommer l'image du vêtement
function GenerateRandomString($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}






//Gestion de la météo- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
define("KEY_IP", "d4fb62a10090dc46eff900d5da5eeca7");

//Fonctions pour récupérer et stocker les informations________________________________________________________________

//Vérifier si la météo a déjà été récupérée grâce à l'API
function IsSetMeteo(){
  return $_SESSION["meteo"];
}

//Enregistrer les information météo organisées dans la session
function SetMeteo($meteo){
  $_SESSION["meteo"] = $meteo;
}

//Récupérer les information météo enregsitrées dans la session
function GetMeteo(){
  return $_SESSION["meteo"];
}

//Récupérer, trier, organiser et enregistrer les informations météo récupérées grâce à l'API
function ExecuteMeteoProgram(){
    //Récupérer les informations météo des 5 jours à venir
    $meteoInfos = GetMeteoInfos();

    //Les classer pour pouvoir les enregistrer
    $ClassedInfos = ClassifyMeteoInfos($meteoInfos);

    //Ranger les informations dans des jours
    $ClassedInfos = ClassifyInfosByDay($ClassedInfos);

    //Les enregistrer dans un objet
    $week = new week($ClassedInfos);

    //sauvegarder l'objet dans la session
    SetMeteo($week);
}

//Récupérer les informations météo des 5 jours à venir grâce à l'API
function GetMeteoInfos(){
    //Appel de l'API
    $url = "http://api.openweathermap.org/data/2.5/forecast?q=Geneve&appid=".KEY_IP."&lang=fr";
    $result = file_get_contents($url);
    $meteoInfos = json_decode($result, true);

    return $meteoInfos;
}

//Trier les information météo nécessaires
function ClassifyMeteoInfos($meteoInfos){ 
    $nbDays = 5; 
    $nbDayRecording = 8;
    
    $recordingsInfos = [];

    //Parcourir tous les enregistrements météo de la semaine
    for($i = 0; $i < ($nbDayRecording * $nbDays); $i++){
        //enregistrer sous forme de dictionnaire les informations météo récupérées par l'API
        $recordingInfos = $array = [
            //Date de l'enregistrement
            "date" => explode(" ",$meteoInfos["list"][$i]["dt_txt"])[0],
            //Heure de l'enregistrement
            "heure" => explode(":", explode(" ",$meteoInfos["list"][$i]["dt_txt"])[1])[0],            
            //Récupérer la temperature
            "temperature" => round($meteoInfos["list"][$i]["main"]["temp"]-273.15),
            //Le groupe météorologique(pluie, neige...)
            "groupeMeteorologique" => $meteoInfos["list"][$i]["weather"][0]["main"],
            //La description de la météo
            "descriptionMeteo" => $meteoInfos["list"][$i]["weather"][0]["description"],
            //l'icone météo
            "icone" => $meteoInfos["list"][$i]["weather"][0]["icon"],
            //L'humidité
            "humidite" => $meteoInfos["list"][$i]["main"]["humidity"],
            //La vitesse du vent
            "vitesseVent" => ($meteoInfos["list"][$i]["wind"]["speed"]*10),
            //La probabilité de pécipitations
            "probPrecipitations" => ($meteoInfos["list"][$i]["pop"]*100),
        ];

        //Ajouter le relevé météo au tableau général
        array_push($recordingsInfos, $recordingInfos);
    }

    //var_dump($recordingsInfos);
    return $recordingsInfos;
}

//Organiser les informations météo par jours dans une classe "semaine"
function ClassifyInfosByDay($meteoInfos){
    $daysInfos = [];
    $intervalEnreg = 3;

    //Récupérer la première heure disponible de la journée (les heures déjà passées ne sont pas données)
    $firstHour = $meteoInfos[0]["heure"];
    //Calculer le nombre d'enregistrements météo restants pour la journée (une journée commence à minuit)
    $lastingHours = ((24-$firstHour)/$intervalEnreg);

    //Supprimer les enregistrements du 6ème jour incomplet
    $lastDayHours = 8-$lastingHours;
    if($lastDayHours<8){
        $a = (count($meteoInfos) - $lastDayHours);
        for($i = count($meteoInfos)-1; $i >= $a; $i--){
            unset($meteoInfos[$i]);
        }
    }

    //var_dump($meteoInfos);

    //Créer un tableau contenant les jours, contenant eux-mêmes * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    $countRecordings = 0;
    //parcourir tous les jours (les 5 à venir)
    for($i = 0; $i < 5; $i++){
        $dayRecording = [];
        //Tant que l'enregistrement suivant a la même date que le précédent
        do{
            //L'ajouter dans le jour actuel
            array_push($dayRecording, $meteoInfos[$countRecordings]);
            //Incrémenter le compteur d'enregistrements
            $countRecordings += 1;
        }
        while($meteoInfos[$countRecordings-1]["date"] == $meteoInfos[$countRecordings]["date"] && $countRecordings < count($meteoInfos)-1);

        //ajouter la journée dans le tableau des journées
        array_push($daysInfos, $dayRecording);
    }

    //echo GetJourSemaineActuel();

    //var_dump($daysInfos);

    return $daysInfos;
}

//Fonctions d'affichage - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//Afficher les liens vers les 5 jours à venir
function ShowDaysNav(){
  //Si un utilisateur est connecté
  if(GetUserRole()==1){
    //Afficher les liens vers les informations de chacun des cinq jours à venir
    for($i = 0; $i < 5; $i++){
      if($i == GetDayToDisplay()){
        echo '<li class="nav-item">
            <a class="nav-link active displayBlock activeDay" aria-current="page" href="index.php?numDay='.$i.'">'.GetWeekDayName($i).'</a>
            </li>';
      }
      else{
        echo '<li class="nav-item">
            <a class="nav-link displayBlock inactiveDay" href="index.php?numDay='.$i.'">'.GetWeekDayName($i).'</a>
            </li>';
      }    
    }
  }  
}

//Retourner le jour dont les informations doivent être affichée, parmi les cinq jours à venir
function GetDayToDisplay(){
  //Récupérer le jour envoyé en paramètre
  if(isset($_GET["numDay"])){
    $dayToDisplay = $_GET["numDay"];
  }
  //Si le paramètre n'existe pas, aller par défaut au jour actuel
  else{
    $dayToDisplay = 0;
  }
  //Si le paramètre est erroné, aller par défaut au jour actuel
  if(($dayToDisplay < 0) || ($dayToDisplay > 4)){
    $dayToDisplay = 0;
  }
  return $dayToDisplay;
}

function GetHourToDisplay(){
  //Récupérer le jour envoyé en paramètre
  if(isset($_GET["numHour"])){
    $hourToDisplay = $_GET["numHour"];
  }
  //Si le paramètre n'existe pas, aller par défaut au jour actuel
  else{
    $hourToDisplay = 0;
  }
  //Si le paramètre est erroné, aller par défaut à l'heure actuele
  if(($hourToDisplay < 0) || ($hourToDisplay > 7)){
    $hourToDisplay = 0;
  }
  return $hourToDisplay;
}

//Afficher les informations détaillées pour la journée sélectionnée
function DisplayDayMeteo($numDay, $numHour){
    //Récupérer les informations météo du jour sélectionné
    $day = GetMeteo()->GetDay($numDay);
    
    echo "</div>";

    echo "<div class=\"meteoTable\">";

    //Températures
    echo "<div class=\"meteoBubble\" id=".$day->GetDate()."> ";   
    $hours = [];
    $temperatures = [];
    $weathers = [];
    //Parcourir les informations de touts les enregistrements de la journée, et récupérer les heures et les températures correspondantes
    for($i = 0; $i < count($day->GetHours()); $i++){
        $hour = $day->GetHour($i);
        array_push($hours, $hour->GetHour());
        array_push($temperatures, $hour->GetTemperature());    
        array_push($weathers, $hour->GetMeteoGroup());           
    }       
    echo "</div>";

    //Liste des des liens vers les heures de la journée, pour obtenir plus de détails
    echo "<div class=\"hoursBubble\" id=".$day->GetDate()."> "; 
    for($i = 0; $i < count($hours); $i++){
      $hour = $hours[$i];
      //mettre en évidence l'heure sélectionnàe
      if($i == $numHour){
        echo '<a class="selectedLink" href="index.php?numDay='.$numDay.'&numHour='.$i.'">'.$hour.'h</a> ';   
      }
      else{
        echo '<a href="index.php?numDay='.$numDay.'&numHour='.$i.'">'.$hour.'h</a> ';   
      }
    }
    echo "</div>";

    //Détails météo par heure
    echo "<div class=\"detailsBubble\" id=".$day->GetDate()."> ";   
    DisplayRecordingsDetails($day, $numHour);
    echo "</div>";
    
    //Tenue recommandée en fonction de la météo
    echo "<div class=\"dressBubble\">";
    DisplayDress($temperatures, $weathers);
    echo "</div>";

    //Activités et évènements du jour
    echo "<div class=\"eventsBubble\">";
    DisplayDaysEvents($numDay);
    echo "</div>";

    echo "</div>";

    //Afficher les températures avec un graphique javascript
    DisplayTemperatureGraphic($hours, $temperatures, $day->GetDate());
}

//Afficher de la température au cours de la journée grâce à un graphique js
function DisplayTemperatureGraphic($hours, $temperatures, $date){
  //Créer un string avec le format tableau en javascript pour pouvoir envoyer les données à la fonction d'affichage
  $temperaturesJSArray = "[['Heure', 'Température'],";
  for($i = 0; $i < count($hours); $i++){
    $temperaturesJSArray .= "[";
    $temperaturesJSArray .= '"'.$hours[$i].'"' . "," . $temperatures[$i];
    $temperaturesJSArray .= "]";
    if($i!=(count($hours)-1)){
      $temperaturesJSArray .= ",";
    }
  }
  $temperaturesJSArray .= "]";

  //appel de la fonction qui affiche le graphique des températures
  echo "<script>DisplayTemperatures($temperaturesJSArray,\"$date\")</script>";
}

//Afficher les informations détaillées pour une heure en particulier de la journée
function DisplayRecordingsDetails($day, $idRecording){

  //Récupérer l'enregistrement à afficher
  $recording = $day->GetHour($idRecording);

  //Afficher les informations météo de l'enregistrements
  echo '<img src="http://openweathermap.org/img/wn/'.$recording->GetIcon().'.png"/>';
  echo "<p>".$recording->GetMeteoDescription()."</p>";
  echo "<p> Précipitations : ".($recording->GetProbPrecipitations())."% </p>";
  echo "<p> Humidité : ".$recording->GetHumidity()."% </p>";
  echo "<p> Vent : ".$recording->GetWindSpeed()." km/h</p>";
}

//Récupérer tous les évènements de la journée, qu'ils proviennent du calendrier ou du semainier, et les afficher
function DisplayDaysEvents($numDay){
  //Récupérer les évènements du semainier de ce jour de la semaine
  $weeklyEvents = GetEventsWeekPlanner();  
  $events = [];  

  //Les ajouter à la liste des évènements du jour
  foreach($weeklyEvents as $key => $event){
      if(intval(explode(".",$event["theDate"])[0]) == GetWeekDay($numDay)){
        array_push($events, $event);        
      }
  }

  //Récupérer les évènements du calendrier à cette date

  //Récupérer le début et la fin de la journée actuelle
  $timeZone = 'Europe/Zurich';
  date_default_timezone_set($timeZone);
  $dateStart = date_create(date("Y")."-".date("m")."-".date("d")." 00:00");
  $dateEnd = date_create(date("Y")."-".date("m")."-".date("d")." 23:59");

  //Calculer le début et la fin du jour affiché
  date_add($dateStart, date_interval_create_from_date_string($numDay.' days'))->format('d.m.Y H:i:s');
  date_add($dateEnd, date_interval_create_from_date_string($numDay.' days'))->format('d.m.Y H:i:s');

  //Transformer les dates dans le bon format pour les envoyer à la requête sql
  $dateStart = date('d.m.Y H:i:s', strtotime(date_format($dateStart, 'd.m.Y H:i:s')));
  $dateEnd = date('d.m.Y H:i:s', strtotime(date_format($dateEnd, 'd.m.Y H:i:s')));

  //Envoyer la requête
  $todaysEvents = GetEventsBetween($dateStart, $dateEnd);

  //Ajouter les évènements du calendrier aux évènements précédemment récupérés du semainier
  foreach($todaysEvents as $day){
    foreach($day as $event){
      array_push($events, $event);
    }
  }

  //Les trier par ordre chronologique
  $events = SortEventsByTime($events);

  //Les afficher
  foreach($events as $event){
    DisplayEvent($event, true);
  }
}

//Trier les évènements (d'une journée) par ordre croissant des heures
function SortEventsByTime($events){
  $sortedEvents = [];
  $sorted = true;
  //Parcourir tous les évènements de la liste
  for($i = 0; $i < (count($events) - 1); $i++){
    //Si l'heure de l'évènement actuel est suppérieur à celle de l'évènement suivant
    if(intval($events[$i]["theHour"])>intval($events[$i+1]["theHour"])){
      //Echanger de position les deux évènements
      $event = $events[$i];
      $events[$i] = $events[$i+1];
      $events[$i+1] = $event;
      $sorted = false;    
    }
    else{
    }
  }
  //Si le tableau n'était toujours pas trié durant la dernière boucle, rappeler la fonction
  if(!$sorted){
    SortEventsByTime($events);
  }
  return $events;
}

//Affiche la météo résumée pour le calendrier
function DisplayMeteoSummary($numDay){
  //Récupérer les informations météo du jour sélectionné
  $day = GetMeteo()->GetDay($numDay);

  //Indexs des heures auxquelles récupérer les information du matin et du soir
  $indexMorning = 2;
  $indexEvening = 5;
  
  //Si la journée n'est plus complète, et que l'heure du soir est passée
  if(count($day->GetHours())<=2){
    $tempMorning = $day->GetHour(0)->GetTemperature();
    $tempEvening = $day->GetHour($indexEvening-(8-count($day->GetHours())))->GetTemperature();
    $iconMorning = $day->GetHour(0)->GetIcon();
    $iconEvening = $day->GetHour($indexEvening-(8-count($day->GetHours())))->GetIcon();

    echo '<div class="summaryBubble">';
    //Afficher les icones des groupes météo du matin et du soir (9h/18h)
    echo '<div class="summaryLeftBox"><p>'.$tempMorning.'°C </p><img src="http://openweathermap.org/img/wn/'.$iconMorning.'.png"/></div>';
    //Afficher la température le matin et le soir (9h/18h)
    echo '<div><p>'.$tempEvening.'°C </p><img src="http://openweathermap.org/img/wn/'.$iconEvening.'.png"/></div>';
    echo '</div>';
  }
  //Si la journée n'est plus complète, et que l'heure du matin est passée
  else if(count($day->GetHours())<=5){
    $tempMorning = $day->GetHour(0)->GetTemperature();
    $tempEvening = $day->GetHour($indexEvening-(8-count($day->GetHours())))->GetTemperature();
    $iconMorning = $day->GetHour(0)->GetIcon();
    $iconEvening = $day->GetHour($indexEvening-(8-count($day->GetHours())))->GetIcon();

    echo '<div class="summaryBubble">';
    //Afficher les icones des groupes météo du matin et du soir (9h/18h)
    echo '<div class="summaryLeftBox"><p>'.$tempMorning.'°C </p><img src="http://openweathermap.org/img/wn/'.$iconMorning.'.png"/></div>';
    //Afficher la température le matin et le soir (9h/18h)
    echo '<div><p>'.$tempEvening.'°C </p><img src="http://openweathermap.org/img/wn/'.$iconEvening.'.png"/></div>';
    echo '</div>';
  }
  //Si l'heure du matin n'est pas encore passée
  else{
    $tempMorning = $day->GetHour($indexMorning)->GetTemperature();
    $tempEvening = $day->GetHour($indexEvening)->GetTemperature();
    $iconMorning = $day->GetHour($indexMorning)->GetIcon();
    $iconEvening = $day->GetHour($indexEvening)->GetIcon();

    echo '<div class="summaryBubble">';
    //Afficher les icones des groupes météo du matin et du soir (9h/18h)
    echo '<div class="summaryLeftBox"><p>'.$tempMorning.'°C </p><img src="http://openweathermap.org/img/wn/'.$iconMorning.'.png"/></div>';
    //Afficher la température le matin et le soir (9h/18h)
    echo '<div><p>'.$tempEvening.'°C </p><img src="http://openweathermap.org/img/wn/'.$iconEvening.'.png"/></div>';
    echo '</div>';
  }
}

//Retournre, pour dans X jours, le nom du jour de la semaine en français
function GetWeekDayName($numDay){
    $days = array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi');

    //récupérer l'index du jour actuel et ajouter le nombre de jours indiqué en paramètre
    $index = date('w', date_timestamp_get(new DateTime('now'))) + $numDay;
    if($index > 6){
        $index = ($index % 6) - 1;
    }

    return $days[$index];
}

//Retournre, le nom du jour de la semaine en français
function GetWeekDayNameAbsolute($numDay){
  $days = array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi');

  return $days[intval($numDay)];
}

//Retourner, pour dans X jours, le numéro du jour de la semaine (0-6 pour dimanche-samedi)
function GetWeekDay($numDay){
  //récupérer l'index du jour actuel et ajouter le nombre de jours indiqué en paramètre
  $index = date('w', date_timestamp_get(new DateTime('now'))) + $numDay;
  if($index > 6){
      $index = ($index % 6) - 1;
  }

  return $index;
}