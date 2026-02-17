<?php
session_start();

if (!isset($_SESSION['annee_joueur'])) {
	header('Location: game.php');
	exit;
}

$annee_joueur = $_SESSION['annee_joueur'];
$annee_correcte = $_SESSION['annee_correcte'];
$difference = $_SESSION['difference'];
$distance_km = $_SESSION['distance_km'];
$score_annee = $_SESSION['score_annee'];
$score_distance = $_SESSION['score_distance'];
$score_round = $_SESSION['score_round'];
$score_total = $_SESSION['score_total'];
$nb_rounds = $_SESSION['nb_rounds'];
$image_url = $_SESSION['image_url'];
$image_lieu = $_SESSION['image_lieu'];
$image_description = $_SESSION['image_description'];
$lat_joueur = $_SESSION['lat_joueur'];
$lng_joueur = $_SESSION['lng_joueur'];
$lat_correcte = $_SESSION['lat_correcte'];
$lng_correcte = $_SESSION['lng_correcte'];

if ($score_round >= 8000) {
	$message = "Parfait ! Excellent !";
	$couleur = "green";
} elseif ($score_round >= 5000) {
	$message = "Bien joue !";
	$couleur = "blue";
} elseif ($score_round >= 2000) {
	$message = "Pas mal !";
	$couleur = "orange";
} else {
	$message = "Dommage, essayez encore !";
	$couleur = "red";
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

<h2 style="color:<?php echo $couleur; ?>"><?php echo $message; ?></h2>

<img src="<?php echo $image_url; ?>" alt="photo" style="width:100%; max-height:400px;">

<br><br>

<h3>Resultats :</h3>

<table border="1" cellpadding="10" style="border-collapse:collapse;">
	<tr style="background-color:#f0f0f0;">
		<td><b>Votre annee</b></td>
		<td><?php echo $annee_joueur; ?></td>
	</tr>
	<tr>
		<td><b>Annee correcte</b></td>
		<td style="color:green;"><b><?php echo $annee_correcte; ?></b></td>
	</tr>
	<tr style="background-color:#f0f0f0;">
		<td><b>Difference</b></td>
		<td><?php echo $difference; ?> ans</td>
	</tr>
	<tr>
		<td><b>Distance</b></td>
		<td><?php echo $distance_km; ?> km</td>
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
		<td><b style="color:navy; font-size:18px;"><?php echo $score_round; ?> / 10000</b></td>
	</tr>
</table>

<br>

<p><b>Lieu :</b> <?php echo $image_lieu; ?></p>
<p><?php echo $image_description; ?></p>

<br>

<h3>Carte :</h3>
<div id="carte" style="width:600px; height:350px; border:1px solid black;"></div>

<br>

<p>Score total : <b><?php echo $score_total; ?></b> pts en <b><?php echo $nb_rounds; ?></b> rounds</p>

<br>
<a href="game.php" class="btn">Image suivante</a>
&nbsp;&nbsp;
<a href="reset_game.php" class="btn-success">Recommencer</a>

<br><br>

<div class="footer"><p>TimeGuessr</p></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var carte = L.map('carte').setView([<?php echo $lat_joueur; ?>, <?php echo $lng_joueur; ?>], 3);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: '© OpenStreetMap'}).addTo(carte);

L.marker([<?php echo $lat_joueur; ?>, <?php echo $lng_joueur; ?>]).addTo(carte).bindPopup('Votre reponse');
L.marker([<?php echo $lat_correcte; ?>, <?php echo $lng_correcte; ?>]).addTo(carte).bindPopup('Lieu correct : <?php echo $image_lieu; ?>');
L.polyline([[<?php echo $lat_joueur; ?>, <?php echo $lng_joueur; ?>], [<?php echo $lat_correcte; ?>, <?php echo $lng_correcte; ?>]], {color: 'red'}).addTo(carte);

carte.fitBounds([[<?php echo $lat_joueur; ?>, <?php echo $lng_joueur; ?>], [<?php echo $lat_correcte; ?>, <?php echo $lng_correcte; ?>]], {padding: [40, 40]});
</script>

</body>
</html>
