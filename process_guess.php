<?php
session_start();

$annee_joueur = $_POST['annee_joueur'];
$lat_joueur = $_POST['lat_joueur'];
$lng_joueur = $_POST['lng_joueur'];

$annee_correcte = $_SESSION['annee_correcte'];
$lat_correcte = $_SESSION['lat_correcte'];
$lng_correcte = $_SESSION['lng_correcte'];

$difference = abs($annee_joueur - $annee_correcte);

if ($difference == 0) {
	$score_annee = 5000;
} elseif ($difference <= 5) {
	$score_annee = 5000 - ($difference * 100);
} elseif ($difference <= 10) {
	$score_annee = 4500 - ($difference * 80);
} elseif ($difference <= 25) {
	$score_annee = 3700 - ($difference * 50);
} elseif ($difference <= 50) {
	$score_annee = 2450 - ($difference * 30);
} else {
	$score_annee = 0;
}

if ($score_annee < 0) {
	$score_annee = 0;
}

$r = 6371;
$dlat = deg2rad($lat_correcte - $lat_joueur);
$dlng = deg2rad($lng_correcte - $lng_joueur);
$a = sin($dlat/2) * sin($dlat/2) + cos(deg2rad($lat_joueur)) * cos(deg2rad($lat_correcte)) * sin($dlng/2) * sin($dlng/2);
$distance_km = $r * 2 * atan2(sqrt($a), sqrt(1-$a));
$distance_km = round($distance_km);

if ($distance_km <= 50) {
	$score_distance = 5000;
} elseif ($distance_km <= 500) {
	$score_distance = 5000 - ($distance_km * 5);
} elseif ($distance_km <= 2000) {
	$score_distance = 2500 - ($distance_km * 1);
} else {
	$score_distance = 0;
}

if ($score_distance < 0) {
	$score_distance = 0;
}

$score_total_round = $score_annee + $score_distance;

$_SESSION['annee_joueur'] = $annee_joueur;
$_SESSION['lat_joueur'] = $lat_joueur;
$_SESSION['lng_joueur'] = $lng_joueur;
$_SESSION['difference'] = $difference;
$_SESSION['distance_km'] = $distance_km;
$_SESSION['score_annee'] = $score_annee;
$_SESSION['score_distance'] = $score_distance;
$_SESSION['score_round'] = $score_total_round;
$_SESSION['score_total'] += $score_total_round;
$_SESSION['nb_rounds'] += 1;
$_SESSION['index_image'] += 1;

header('Location: result.php');
exit;
?>
