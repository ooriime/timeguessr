<?php
session_start();
require_once 'includes/db.php';

$result = mysqli_query($connexion, "SELECT * FROM images");
$liste_images = array();
while ($ligne = mysqli_fetch_assoc($result)) {
	$liste_images[] = $ligne;
}

if (!isset($_SESSION['score_total'])) {
	$_SESSION['score_total'] = 0;
}
if (!isset($_SESSION['nb_rounds'])) {
	$_SESSION['nb_rounds'] = 0;
}

if (!isset($_SESSION['images_melangees'])) {
	shuffle($liste_images);
	$_SESSION['images_melangees'] = $liste_images;
	$_SESSION['index_image'] = 0;
} else {
	$liste_images = $_SESSION['images_melangees'];
}

$index = $_SESSION['index_image'];

if ($index >= count($liste_images)) {
	$index = 0;
	$_SESSION['index_image'] = 0;
}

$image = $liste_images[$index];

$_SESSION['annee_correcte'] = $image['year'];
$_SESSION['image_url'] = $image['url'];
$_SESSION['image_lieu'] = $image['location'];
$_SESSION['image_description'] = $image['description'];
$_SESSION['image_indice'] = $image['hint'];

$coordonnees = array(
	1906 => array(37.7749, -122.4194),
	1929 => array(40.7067, -74.0089),
	1945 => array(51.5074, -0.1278),
	1963 => array(38.8899, -77.0091),
	1968 => array(50.0755, 14.4378),
	1986 => array(51.3890, 30.0994),
	1989 => array(52.5200, 13.4050),
	2001 => array(40.7128, -74.0060),
	2011 => array(30.0444, 31.2357)
);

$_SESSION['lat_correcte'] = $coordonnees[$image['year']][0];
$_SESSION['lng_correcte'] = $coordonnees[$image['year']][1];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>TimeGuessr - Jeu</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
</head>
<body>

<div class="header">
	<a href="home.php"><h1>TimeGuessr</h1></a>
</div>

<p>Score : <b><?php echo $_SESSION['score_total']; ?></b> &nbsp;&nbsp; Rounds : <b><?php echo $_SESSION['nb_rounds']; ?></b> &nbsp;&nbsp; Image : <b><?php echo $index + 1; ?>/<?php echo count($liste_images); ?></b></p>

<hr>

<h2>Devinez l'annee et le lieu de cette photo :</h2>

<div class="image-container">
	<img src="<?php echo $image['url']; ?>" alt="photo historique">
</div>

<p><b>Indice :</b> <?php echo $image['hint']; ?></p>

<hr>

<h3>Votre annee :</h3>
<input type="number" id="annee" min="1800" max="2024" value="1950" style="font-size:20px; width:100px; padding:5px;">
<br><br>
<input type="range" id="slider_annee" min="1800" max="2024" value="1950" style="width:400px;">

<br><br>

<h3>Votre lieu (cliquez sur la carte) :</h3>
<div id="map" style="width:600px; height:350px; border:1px solid black;"></div>
<br>
<p id="coords_affichage" style="color:blue;">Aucune position choisie</p>

<br>

<form id="formulaire" action="process_guess.php" method="POST">
	<input type="hidden" id="annee_hidden" name="annee_joueur" value="1950">
	<input type="hidden" id="lat_hidden" name="lat_joueur" value="">
	<input type="hidden" id="lng_hidden" name="lng_joueur" value="">
	<button type="submit" id="btn_valider" class="btn" disabled>Valider ma reponse</button>
</form>

<p style="color:red; font-size:13px;">Vous devez cliquer sur la carte avant de valider !</p>

<br>

<div class="footer"><p>TimeGuessr</p></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var map = L.map('map').setView([20, 0], 2);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: '© OpenStreetMap'}).addTo(map);

var marqueur = null;
var lat_choisie = null;
var lng_choisie = null;

map.on('click', function(e) {
	if (marqueur != null) {
		map.removeLayer(marqueur);
	}
	marqueur = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
	lat_choisie = e.latlng.lat.toFixed(4);
	lng_choisie = e.latlng.lng.toFixed(4);
	document.getElementById('coords_affichage').innerHTML = 'Position choisie : ' + lat_choisie + ', ' + lng_choisie;
	document.getElementById('lat_hidden').value = lat_choisie;
	document.getElementById('lng_hidden').value = lng_choisie;
	document.getElementById('btn_valider').disabled = false;
});

document.getElementById('annee').addEventListener('input', function() {
	document.getElementById('slider_annee').value = this.value;
	document.getElementById('annee_hidden').value = this.value;
});

document.getElementById('slider_annee').addEventListener('input', function() {
	document.getElementById('annee').value = this.value;
	document.getElementById('annee_hidden').value = this.value;
});

document.getElementById('formulaire').addEventListener('submit', function(e) {
	if (lat_choisie == null) {
		e.preventDefault();
		alert('Vous devez cliquer sur la carte !');
	}
});
</script>

</body>
</html>
