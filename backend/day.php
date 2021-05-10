<?php
/*
projet : 
auteur : ALiya Myaz
version : 1.0
date : Mai 2021
description : classe Semaine, stocke les 8 heures de la journée possédant des informations meteo
*/

class Day{
    //champs
    private $_recordings;
    private $_date;

    function __construct($infosMeteo){
        $this->_date = $infosMeteo[0]["date"];
        //Créer toutes les heures et les ajouter à la liste _heure
        $this->_recordings = [];
        for($i = 0; $i < count($infosMeteo); $i++){
            $recording = new MeteoRecord($infosMeteo[$i]);
            array_push($this->_recordings, $recording);
        }
    }

    public function GetDate(){
        return $this->_date;
    }

    public function GetHours(){
        return $this->_recordings;
    }

    public function GetHour($numHour){
        return $this->_recordings[$numHour];
    }
}