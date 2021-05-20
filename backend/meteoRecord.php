<?php
/*
  Projet     : Suggestion de tenues en fonction de la météo
  Auteur     : Aliya Myaz
  Date       : Mai 2021
  Sujet      : Classe "enregistrement météo", stocke les informations météorologiques d'une heure précise
*/

class MeteoRecord{
    //Champs
    private $_hour;
    private $_temperature;   
    private $_meteoGroup;
    private $_meteoDescription;
    private $_icon;
    private $_humidity;
    private $_windSpeed;
    private $_probPrecipitations;

    //Constructeur
    function __construct($infosMeteo){
        //Enregistrer toutes informations de l'enreistrement dans les champs       
        $this->_hour = $infosMeteo["heure"];
        $this->_temperature = $infosMeteo["temperature"];;
        $this->_meteoGroup = $infosMeteo["groupeMeteorologique"];
        $this->_meteoDescription = $infosMeteo["descriptionMeteo"];
        $this->_icon = $infosMeteo["icone"];
        $this->_humidity = $infosMeteo["humidite"];
        $this->_windSpeed = $infosMeteo["vitesseVent"];
        $this->_probPrecipitations = $infosMeteo["probPrecipitations"];
    }


    //Méthodes 

    //Retourner l'heure de l'enregistrement
    public function GetHour(){
        return $this->_hour;
    }

    //Retourner la température
    public function GetTemperature(){
        return $this->_temperature;
    }

    //Retourner le groupe météo (pluie, neige...)
    public function GetMeteoGroup(){
        return $this->_meteoGroup;
    }

    //Retourner la secription détaillée de la météo
    public function GetMeteoDescription(){
        return $this->_meteoDescription;
    }

    //Retourner l'icone météo
    public function GetIcon(){
        return $this->_icon;
    }

    //Retourner l'humidité
    public function GetHumidity(){
        return $this->_humidity;
    }

    //Retourner la vitesse du vent
    public function GetWindSpeed(){
        return $this->_windSpeed;
    }

    //Retourner la probabilité de précipitations
    public function GetProbPrecipitations(){
        return $this->_probPrecipitations;
    }
}