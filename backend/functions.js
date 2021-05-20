/*
  Projet      : Suggestion de tenues en fonction de la météo
  Date        : Mai 2021
  Auteur      : Aliya Myaz
  Description : Fonctions javascript pour l'affichage de graphiques météo
*/

//Télécharger la libraire google charts
google.charts.load('current', {packages: ['corechart', 'bar']});

//Données du tableau
var preparedData;

//Identifiant de l'emplacement HTML où il faut afficher le graphique
var id;

//Récupérer les informations du graphique et appeler la fonction de dessin
function DisplayTemperatures(temperatures, date){
  id = date;

	//Formater les données de températures par heure
	preparedData = temperatures;
  
  //Créer et afficher le graphique
  google.charts.setOnLoadCallback(DrawGraphic);
}

//Dessiner le graphique grâce à la libraire google charts
function DrawGraphic(){
  //Traiter les données
  var data = google.visualization.arrayToDataTable(preparedData)

  //Paramétrer le graphique
  var materialOptions = { 
    bars: 'vertical',
    'width':500,
    'height':180,
    colors: ['#D2EEFF']
  };

  //Afficher le graphique
  var materialChart = new google.charts.Bar(document.getElementById(id));
  materialChart.draw(data, materialOptions);
}