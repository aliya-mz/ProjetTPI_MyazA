<?php
/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : classe Semaine, stocke les 8 heures de la journée possédant des informations meteo
*/

class Day{
    //Champs
    private $_recordings;
    private $_date;

    //Constructeur
    function __construct($infosMeteo){
        $this->_date = $infosMeteo[0]["date"];
        //Créer toutes les heures et les ajouter à la liste _heure
        $this->_recordings = [];
        for($i = 0; $i < count($infosMeteo); $i++){
            $recording = new MeteoRecord($infosMeteo[$i]);
            array_push($this->_recordings, $recording);
        }
    }

    //Méthodes
    
    //Retourner la date du jour
    public function GetDate(){
        return $this->_date;
    }

    //Retourner la liste des enregistrements du jours
    public function GetHours(){
        return $this->_recordings;
    }

    //Retourner l'enregistrement à la position $numHour
    public function GetHour($numHour){
        return $this->_recordings[$numHour];
    }
}