<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : classe Semaine, sauvegarde les 5 jours à venirs
*/

class Week{
    //Champs
    private $_days;

    //Constructeur
    public function __construct($infosMeteo){
        //Créer tous les jours et les ajouter à la liste _jours
        $this->_days = [];
        for($i = 0; $i < count($infosMeteo); $i++){
            $day = new day($infosMeteo[$i]);
            array_push($this->_days, $day);
        }
    }

    //Méthodes
    
    //Retourner la liste des jours de la semaine
    public function GetDays(){
        return $this->_days;
    }

    //Retourner le jour de la semaine à la position $numDay
    public function GetDay($numDay){
        return $this->_days[$numDay];
    }
}