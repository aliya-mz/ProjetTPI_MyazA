<?php
/*
projet : 
auteur : ALiya Myaz
version : 1.0
date : Mai 2021
description : classe Semaine, stocke les 5 jours à venirs
*/

class Week{
    //Champs
    private $_days;

    //Constructeurs
    public function __construct($infosMeteo){
        //Créer tous les jours et les ajouter à la liste _jours
        $this->_days = [];
        for($i = 0; $i < count($infosMeteo); $i++){
            $day = new day($infosMeteo[$i]);
            array_push($this->_days, $day);
        }
    }

    public function GetDays(){
        return $this->_days;
    }

    public function GetDay($numDay){
        return $this->_days[$numDay];
    }
}