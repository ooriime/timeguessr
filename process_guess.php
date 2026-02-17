<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_guess_year = (int)$_POST['year_guess'];
    $user_guess_lat = (float)$_POST['lat_guess'];
    $user_guess_lng = (float)$_POST['lng_guess'];

    $correct_year = (int)$_SESSION['correct_year'];
    $correct_lat = (float)$_SESSION['correct_lat'];
    $correct_lng = (float)$_SESSION['correct_lng'];

    $year_difference = abs($user_guess_year - $correct_year);

    if ($year_difference == 0) {
        $year_score = 5000;
    } elseif ($year_difference == 1) {
        $year_score = 4950;
    } elseif ($year_difference <= 5) {
        $year_score = 5000 - ($year_difference * 50);
    } elseif ($year_difference <= 10) {
        $year_score = 4750 - (($year_difference - 5) * 50);
    } elseif ($year_difference <= 25) {
        $year_score = 4500 - (($year_difference - 10) * 50);
    } elseif ($year_difference <= 50) {
        $year_score = 3750 - (($year_difference - 25) * 50);
    } elseif ($year_difference <= 100) {
        $year_score = 2500 - (($year_difference - 50) * 50);
    } else {
        $year_score = 0;
    }

    $year_score = max(0, $year_score);

    function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371;

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat/2) * sin($dlat/2) +
             cos($lat1) * cos($lat2) *
             sin($dlon/2) * sin($dlon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;

        return $distance;
    }

    $distance_km = calculateDistance($user_guess_lat, $user_guess_lng, $correct_lat, $correct_lng);

    if ($distance_km <= 10) {
        $distance_score = 5000;
    } elseif ($distance_km <= 50) {
        $distance_score = 5000 - (($distance_km - 10) * 12.5);
    } elseif ($distance_km <= 200) {
        $distance_score = 4500 - (($distance_km - 50) * 3.33);
    } elseif ($distance_km <= 500) {
        $distance_score = 4000 - (($distance_km - 200) * 3.33);
    } elseif ($distance_km <= 1000) {
        $distance_score = 3000 - (($distance_km - 500) * 2);
    } elseif ($distance_km <= 5000) {
        $distance_score = 2000 - (($distance_km - 1000) * 0.25);
    } else {
        $distance_score = max(0, 1000 - ($distance_km - 5000) * 0.05);
    }

    $distance_score = max(0, round($distance_score));

    $total_score = $year_score + $distance_score;

    $_SESSION['user_guess_year'] = $user_guess_year;
    $_SESSION['user_guess_lat'] = $user_guess_lat;
    $_SESSION['user_guess_lng'] = $user_guess_lng;
    $_SESSION['year_difference'] = $year_difference;
    $_SESSION['distance_km'] = round($distance_km);
    $_SESSION['year_score'] = $year_score;
    $_SESSION['distance_score'] = $distance_score;
    $_SESSION['score'] = $total_score;

    $_SESSION['total_score'] += $total_score;
    $_SESSION['rounds_played'] += 1;

    if (!isset($_SESSION['total_year_difference'])) {
        $_SESSION['total_year_difference'] = 0;
    }
    if (!isset($_SESSION['total_distance'])) {
        $_SESSION['total_distance'] = 0;
    }
    $_SESSION['total_year_difference'] += $year_difference;
    $_SESSION['total_distance'] += $distance_km;

    require_once 'includes/db.php';
    $db = Database::getInstance();
    $images = $db->getAllImages();
    $_SESSION['image_index'] = ($_SESSION['image_index'] + 1) % count($images);

    header('Location: result.php');
    exit;
} else {
    header('Location: game.php');
    exit;
}
?>
