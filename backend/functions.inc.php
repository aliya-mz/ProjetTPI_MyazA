<?PHP
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Fonction du projet
*/

//Gestion des utilisateurs - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

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
  //récupérer l'utilisateur dans la BD avec son Id
  $user = ReadUserByUsername($login);

  //tester le mot de passe
  if(password_verify($password, $user["password"])){
    //enregister l'utilisateur dans la session
    SetIdUser($user["idUser"]);

    //rediriger vers la page d'accueil
    header('Location: index.php');
    exit;
  }
  else{
    //Message d'erreur
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
		echo "<a class=\"nav-link\" href=\"#\">Calendrier</a>";
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

/*A FAIRE*/
//Afficher svg correspondant à idVetement
function DisplayClotheImage($cheminFichier){
  echo "<img src=\"$cheminFichier\" alt=\"icône du vêtement enregistré\"/>";
}

//Afficher une tenue complète, avec le résumé des vêtements
function DisplayDress($dress){
}





//Gestion du calendrier- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//Générer le calendrier et semainier ____________________________________________________________________________

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

//Gestion des évènements_________________________________________________________________________________________

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

//Gérer l'affichage______________________________________________________________________________________________

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




























