<?php
/*
  Projet     : Suggestion de tenues en fonction de la météo
  Auteur     : Aliya Myaz
  Date       : Mai 2021
  Sujet      : Classe "enregistrement météo", stocke les informations météorologiques d'une heure précise
*/

class MeteoRecord{
    //champs
    private $_hour;
    private $_temperature;   
    private $_meteoGroup; //pluie, neige, etc...
    private $_meteoDescription;
    private $_icon;
    private $_humidity;
    private $_windSpeed;
    private $_probPrecipitations;

    function __construct($infosMeteo){
        //Traiter les informations pour les classer dans les champs        
        $this->_hour = $infosMeteo["heure"];
        $this->_temperature = $infosMeteo["temperature"];;
        $this->_meteoGroup = $infosMeteo["groupeMeteorologique"];
        $this->_meteoDescription = $infosMeteo["descriptionMeteo"];
        $this->_icon = $infosMeteo["icone"];
        $this->_humidity = $infosMeteo["humidite"];
        $this->_windSpeed = $infosMeteo["vitesseVent"];
        $this->_probPrecipitations = $infosMeteo["probPrecipitations"];
    }
    
    public function GetHour(){
        return $this->_hour;
    }

    public function GetTemperature(){
        return $this->_temperature;
    }

    public function GetMeteoGroup(){
        return $this->_meteoGroup;
    }

    public function GetMeteoDescription(){
        return $this->_meteoDescription;
    }

    public function GetIcon(){
        return $this->_icon;
    }

    public function GetHumidity(){
        return $this->_humidity;
    }

    public function GetWindSpeed(){
        return $this->_windSpeed;
    }

    public function GetProbPrecipitations(){
        return $this->_probPrecipitations;
    }
}