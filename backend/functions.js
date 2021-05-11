/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Fonctions pour l'affichage de graphiques météo
*/

/*
code utilisé : https://developers.google.com/chart/interactive/docs/gallery/barchart
*/

google.charts.load('current', {packages: ['corechart', 'bar']});

var preparedData;
var id;

function DisplayTemperatures(temperatures, date){
  id = date;
	//Formater les données de températures par heure
	preparedData = temperatures;
  
  //Créer et afficher le graphique
  google.charts.setOnLoadCallback(DrawGraphic);
}

function DrawGraphic(){
  var data = google.visualization.arrayToDataTable(preparedData)

  var materialOptions = { 
    bars: 'vertical',
    'width':500,
    'height':180,
    //'background-color': '#BFD1DE',
    colors: ['#BFD1DE']
  };

  var materialChart = new google.charts.Bar(document.getElementById(id));
  materialChart.draw(data, materialOptions);
}