<?php
session_start();
if (!isset($_SESSION['user_guess_year'])) {
	header('Location: game.php');
	exit;
}

$annee_utilisateur = $_SESSION['user_guess_year'];
$lat_utilisateur = $_SESSION['user_guess_lat'];
$lng_utilisateur = $_SESSION['user_guess_lng'];
$annee_correcte = $_SESSION['correct_year'];
$lat_correcte = $_SESSION['correct_lat'];
$lng_correcte = $_SESSION['correct_lng'];
$difference_annee = $_SESSION['year_difference'];
$distance = $_SESSION['distance_km'];
$score_annee = $_SESSION['year_score'];
$score_distance = $_SESSION['distance_score'];
$score_total_round = $_SESSION['score'];
$image_url = $_SESSION['image_url'];
$image_lieu = $_SESSION['image_location'];
$image_description = $_SESSION['image_description'];
$score_total = $_SESSION['score_total'];
$nb_rounds = $_SESSION['nb_rounds'];

$pourcentage = ($score_total_round / 10000) * 100;

if ($pourcentage >= 95) {
	$message = "Parfait ! Excellent !";
	$couleur_message = "result-perfect";
} elseif ($pourcentage >= 70) {
	$message = "Bien joue !";
	$couleur_message = "result-good";
} elseif ($pourcentage >= 40) {
	$message = "Pas mal !";
	$couleur_message = "result-ok";
} else {
	$message = "Dommage, essayez encore !";
	$couleur_message = "result-bad";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>TimeGuessr - Resultat</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
</head>
<body>

<div class="header">
	<a href="home.php"><h1>TimeGuessr</h1></a>
</div>

<h2 class="<?php echo $couleur_message; ?>"><?php echo $message; ?></h2>

<img src="<?php echo htmlspecialchars($image_url); ?>" alt="photo" style="width:100%; max-height:400px;">

<br><br>

<h3>Resultats :</h3>

<table border="1" cellpadding="10" style="border-collapse:collapse;">
	<tr style="background-color:#f0f0f0;">
		<td><b>Votre annee</b></td>
		<td><?php echo $annee_utilisateur; ?></td>
	</tr>
	<tr>
		<td><b>Annee correcte</b></td>
		<td style="color:green;"><b><?php echo $annee_correcte; ?></b></td>
	</tr>
	<tr style="background-color:#f0f0f0;">
		<td><b>Difference</b></td>
		<td><?php echo $difference_annee; ?> ans</td>
	</tr>
	<tr>
		<td><b>Distance</b></td>
		<td><?php echo $distance; ?> km</td>
	</tr>
	<tr style="background-color:#f0f0f0;">
		<td><b>Score annee</b></td>
		<td><?php echo $score_annee; ?> pts</td>
	</tr>
	<tr>
		<td><b>Score distance</b></td>
		<td><?php echo $score_distance; ?> pts</td>
	</tr>
	<tr style="background-color:lightyellow;">
		<td><b>Score du round</b></td>
		<td><b style="color:navy; font-size:18px;"><?php echo $score_total_round; ?> / 10000</b></td>
	</tr>
</table>

<br>

<p><b>Lieu :</b> <?php echo htmlspecialchars($image_lieu); ?></p>
<p><?php echo htmlspecialchars($image_description); ?></p>

<br>

<h3>Carte :</h3>
<div id="carte_resultat" style="width:600px; height:350px; border:1px solid black;"></div>

<br>

<p>Score total : <b><?php echo $score_total; ?></b> pts en <b><?php echo $nb_rounds; ?></b> rounds</p>

<br>
<a href="game.php" class="btn">Image suivante</a>
&nbsp;&nbsp;
<a href="reset_game.php" class="btn-success">Recommencer</a>

<br><br>

<div class="footer">
	<p>TimeGuessr</p>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var lat_joueur = <?php echo $lat_utilisateur; ?>;
var lng_joueur = <?php echo $lng_utilisateur; ?>;
var lat_correct = <?php echo $lat_correcte; ?>;
var lng_correct = <?php echo $lng_correcte; ?>;

var carte = L.map('carte_resultat').setView([(lat_joueur + lat_correct) / 2, (lng_joueur + lng_correct) / 2], 3);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	attribution: '© OpenStreetMap'
}).addTo(carte);

L.marker([lat_joueur, lng_joueur]).addTo(carte).bindPopup('Votre reponse');
L.marker([lat_correct, lng_correct]).addTo(carte).bindPopup('Lieu correct : <?php echo htmlspecialchars($image_lieu); ?>');

L.polyline([[lat_joueur, lng_joueur], [lat_correct, lng_correct]], {color: 'red'}).addTo(carte);

carte.fitBounds([[lat_joueur, lng_joueur], [lat_correct, lng_correct]], {padding: [40, 40]});
</script>

</body>
</html>
