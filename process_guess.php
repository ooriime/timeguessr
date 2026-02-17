<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: game.php'); exit; }

$annee_joueur = (int)$_POST['year_guess'];
$lat_joueur = (float)$_POST['lat_guess'];
$lng_joueur = (float)$_POST['lng_guess'];

$annee_correcte = (int)$_SESSION['correct_year'];
$lat_correcte = (float)$_SESSION['correct_lat'];
$lng_correcte = (float)$_SESSION['correct_lng'];

$diff_annee = abs($annee_joueur - $annee_correcte);

if ($diff_annee == 0) $score_annee = 5000;
elseif ($diff_annee == 1) $score_annee = 4950;
elseif ($diff_annee <= 5) $score_annee = 5000 - ($diff_annee * 50);
elseif ($diff_annee <= 10) $score_annee = 4750 - (($diff_annee - 5) * 50);
elseif ($diff_annee <= 25) $score_annee = 4500 - (($diff_annee - 10) * 50);
elseif ($diff_annee <= 50) $score_annee = 3750 - (($diff_annee - 25) * 50);
elseif ($diff_annee <= 100) $score_annee = 2500 - (($diff_annee - 50) * 50);
else $score_annee = 0;

$score_annee = max(0, $score_annee);

function calculer_distance($lat1, $lon1, $lat2, $lon2) {
	$r = 6371;
	$a = sin(deg2rad($lat2 - $lat1) / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin(deg2rad($lon2 - $lon1) / 2) ** 2;
	return $r * 2 * atan2(sqrt($a), sqrt(1 - $a));
}

$distance_km = calculer_distance($lat_joueur, $lng_joueur, $lat_correcte, $lng_correcte);

if ($distance_km <= 10) $score_distance = 5000;
elseif ($distance_km <= 50) $score_distance = 5000 - (($distance_km - 10) * 12.5);
elseif ($distance_km <= 200) $score_distance = 4500 - (($distance_km - 50) * 3.33);
elseif ($distance_km <= 500) $score_distance = 4000 - (($distance_km - 200) * 3.33);
elseif ($distance_km <= 1000) $score_distance = 3000 - (($distance_km - 500) * 2);
elseif ($distance_km <= 5000) $score_distance = 2000 - (($distance_km - 1000) * 0.25);
else $score_distance = max(0, 1000 - ($distance_km - 5000) * 0.05);

$score_distance = max(0, round($score_distance));
$score_round = $score_annee + $score_distance;

$_SESSION['user_guess_year'] = $annee_joueur;
$_SESSION['user_guess_lat'] = $lat_joueur;
$_SESSION['user_guess_lng'] = $lng_joueur;
$_SESSION['year_difference'] = $diff_annee;
$_SESSION['distance_km'] = round($distance_km);
$_SESSION['year_score'] = $score_annee;
$_SESSION['distance_score'] = $score_distance;
$_SESSION['score'] = $score_round;
$_SESSION['score_total'] += $score_round;
$_SESSION['nb_rounds'] += 1;

require_once 'includes/db.php';
$images = Database::getInstance()->getAllImages();
$_SESSION['index_image'] = ($_SESSION['index_image'] + 1) % count($images);

header('Location: result.php');
exit;
?>
