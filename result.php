<?php
session_start();

// Rediriger si on accède directement à cette page
if (!isset($_SESSION['user_guess_year'])) {
    header('Location: game.php');
    exit;
}

$user_guess_year = $_SESSION['user_guess_year'];
$user_guess_lat = $_SESSION['user_guess_lat'];
$user_guess_lng = $_SESSION['user_guess_lng'];
$correct_year = $_SESSION['correct_year'];
$correct_lat = $_SESSION['correct_lat'];
$correct_lng = $_SESSION['correct_lng'];
$year_difference = $_SESSION['year_difference'];
$distance_km = $_SESSION['distance_km'];
$year_score = $_SESSION['year_score'];
$distance_score = $_SESSION['distance_score'];
$score = $_SESSION['score'];
$image_url = $_SESSION['image_url'];
$image_location = $_SESSION['image_location'];
$image_description = $_SESSION['image_description'];
$total_score = $_SESSION['total_score'];
$rounds_played = $_SESSION['rounds_played'];

// Déterminer le message en fonction du score total
$total_possible = 10000;
$percentage = ($score / $total_possible) * 100;

if ($percentage >= 95) {
    $message = "🏆 PARFAIT ! Vous êtes un génie !";
    $message_class = "result-perfect";
} elseif ($percentage >= 85) {
    $message = "🔥 Excellent ! Très impressionnant !";
    $message_class = "result-excellent";
} elseif ($percentage >= 70) {
    $message = "👍 Très bien ! Belle performance !";
    $message_class = "result-good";
} elseif ($percentage >= 50) {
    $message = "👌 Pas mal ! Continuez !";
    $message_class = "result-ok";
} elseif ($percentage >= 30) {
    $message = "🤔 Moyen... Il faut réviser !";
    $message_class = "result-medium";
} else {
    $message = "😅 Oups ! C'était loin !";
    $message_class = "result-bad";
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TimeGuessr - Resultat</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #result-map { width: 100%; height: 400px; border: 1px solid #ccc; margin: 15px 0; }
    </style>
</head>
<body>

<div class="header">
    <a href="home.php"><div class="logo">TimeGuessr</div></a>
    <p class="subtitle">Resultat de votre estimation</p>
</div>

<div class="container">
    <div class="result-container">

        <h1 class="result-title <?php echo $message_class; ?>">
            <?php echo $message; ?>
        </h1>

        <div class="image-container">
            <img src="<?php echo htmlspecialchars($image_url); ?>" alt="Photo historique">
        </div>

        <div id="result-map"></div>

        <h3>Resultats :</h3>

        <div class="result-grid">
            <div class="result-card">
                <div class="result-label">Votre annee</div>
                <div class="result-value"><?php echo $user_guess_year; ?></div>
            </div>
            <div class="result-card result-correct">
                <div class="result-label">Annee correcte</div>
                <div class="result-value"><?php echo $correct_year; ?></div>
            </div>
            <div class="result-card">
                <div class="result-label">Difference</div>
                <div class="result-value"><?php echo $year_difference; ?> ans</div>
            </div>
        </div>

        <div class="result-grid">
            <div class="result-card">
                <div class="result-label">Score annee</div>
                <div class="result-value"><?php echo number_format($year_score); ?></div>
            </div>
            <div class="result-card">
                <div class="result-label">Score distance (<?php echo number_format($distance_km); ?> km)</div>
                <div class="result-value"><?php echo number_format($distance_score); ?></div>
            </div>
            <div class="result-card result-correct">
                <div class="result-label">Score total</div>
                <div class="result-value"><?php echo number_format($score); ?> / 10 000</div>
            </div>
        </div>

        <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; background: #f9f9f9;">
            <strong>Lieu : <?php echo htmlspecialchars($image_location); ?></strong><br>
            <span style="color: #555;"><?php echo htmlspecialchars($image_description); ?></span>
        </div>

        <div class="btn-container">
            <a href="game.php" class="btn btn-primary">Image suivante</a>
            <a href="reset_game.php" class="btn btn-success">Recommencer</a>
        </div>

    </div>
</div>

<div class="footer">
    <p>TimeGuessr - projet scolaire</p>
</div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
        const userLat = <?php echo $user_guess_lat; ?>;
        const userLng = <?php echo $user_guess_lng; ?>;
        const correctLat = <?php echo $correct_lat; ?>;
        const correctLng = <?php echo $correct_lng; ?>;

        const centerLat = (userLat + correctLat) / 2;
        const centerLng = (userLng + correctLng) / 2;

        const resultMap = L.map('result-map').setView([centerLat, centerLng], 4);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(resultMap);

        L.marker([userLat, userLng], {
            icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            })
        }).addTo(resultMap)
          .bindPopup('Votre estimation - <?php echo number_format($distance_km); ?> km');

        L.marker([correctLat, correctLng], {
            icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            })
        }).addTo(resultMap)
          .bindPopup('Lieu correct - <?php echo htmlspecialchars($image_location); ?>');

        L.polyline(
            [[userLat, userLng], [correctLat, correctLng]],
            { color: 'red', weight: 2 }
        ).addTo(resultMap);

        resultMap.fitBounds([
            [userLat, userLng],
            [correctLat, correctLng]
        ], { padding: [50, 50] });
    </script>
</body>
</html>
