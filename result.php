<?php
session_start();

// Rediriger si on accède directement à cette page
if (!isset($_SESSION['user_guess'])) {
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeGuessr - Résultat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #result-map {
            width: 100%;
            height: 500px;
            border-radius: 12px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }
    </style>
    <style>
        .result-perfect { color: #10b981; }
        .result-excellent { color: #3b82f6; }
        .result-good { color: #8b5cf6; }
        .result-ok { color: #f59e0b; }
        .result-medium { color: #f97316; }
        .result-bad { color: #ef4444; }
    </style>
</head>
<body>
    <header class="header">
        <a href="home.php" style="text-decoration: none;">
            <div class="logo">⏰ TimeGuessr</div>
        </a>
        <p class="subtitle">Résultat de votre estimation</p>
    </header>

    <div class="container">
        <div class="result-container">
            <h1 class="result-title <?php echo $message_class; ?>">
                <?php echo $message; ?>
            </h1>

            <div class="image-container" style="margin-bottom: 30px;">
                <img src="<?php echo htmlspecialchars($image_url); ?>" alt="Image historique" onerror="this.style.display='none';">
            </div>

            <!-- CARTE DES RÉSULTATS -->
            <div id="result-map"></div>

            <!-- SCORES -->
            <div class="result-grid" style="margin-top: 30px;">
                <div class="result-card">
                    <div class="result-label">📅 Score Année</div>
                    <div class="result-value"><?php echo number_format($year_score); ?></div>
                    <div style="color: #94a3b8; margin-top: 10px;">
                        Différence : <?php echo $year_difference; ?> <?php echo $year_difference <= 1 ? 'an' : 'ans'; ?>
                    </div>
                </div>

                <div class="result-card">
                    <div class="result-label">🗺️ Score Distance</div>
                    <div class="result-value"><?php echo number_format($distance_score); ?></div>
                    <div style="color: #94a3b8; margin-top: 10px;">
                        Distance : <?php echo number_format($distance_km); ?> km
                    </div>
                </div>

                <div class="result-card result-correct">
                    <div class="result-label">🏆 Score Total</div>
                    <div class="result-value"><?php echo number_format($score); ?></div>
                    <div style="color: #94a3b8; margin-top: 10px;">
                        / 10,000 points
                    </div>
                </div>
            </div>

            <div class="result-grid" style="margin-top: 20px;">
                <div class="result-card">
                    <div class="result-label">Votre estimation année</div>
                    <div class="result-value"><?php echo $user_guess_year; ?></div>
                </div>

                <div class="result-card result-correct">
                    <div class="result-label">Année correcte</div>
                    <div class="result-value"><?php echo $correct_year; ?></div>
                </div>
            </div>

            <div class="result-card" style="margin-top: 30px; text-align: left;">
                <div class="result-label">À propos de cette image</div>
                <div style="margin-top: 15px; color: var(--text-primary);">
                    <p style="font-size: 1.2em; margin-bottom: 10px;">
                        <strong>📍 <?php echo htmlspecialchars($image_location); ?></strong>
                    </p>
                    <p style="font-size: 1em; color: var(--text-secondary);">
                        <?php echo htmlspecialchars($image_description); ?>
                    </p>
                </div>
            </div>

            <div class="result-card" style="margin-top: 20px;">
                <div class="score-display" style="justify-content: center;">
                    <div class="score-item">
                        <div class="score-label">Score Total</div>
                        <div class="score-value"><?php echo number_format($total_score); ?></div>
                    </div>
                    <div class="score-item">
                        <div class="score-label">Rounds Joués</div>
                        <div class="score-value"><?php echo $rounds_played; ?></div>
                    </div>
                    <div class="score-item">
                        <div class="score-label">Moyenne</div>
                        <div class="score-value">
                            <?php echo $rounds_played > 0 ? number_format($total_score / $rounds_played) : 0; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn-container">
                <a href="game.php" class="btn btn-primary">
                    ▶️ Image Suivante
                </a>
                <a href="reset_game.php" class="btn btn-success">
                    🔄 Recommencer le jeu
                </a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>TimeGuessr - Testez vos connaissances en histoire</p>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
        // Coordonnées
        const userLat = <?php echo $user_guess_lat; ?>;
        const userLng = <?php echo $user_guess_lng; ?>;
        const correctLat = <?php echo $correct_lat; ?>;
        const correctLng = <?php echo $correct_lng; ?>;

        // Créer la carte centrée entre les deux points
        const centerLat = (userLat + correctLat) / 2;
        const centerLng = (userLng + correctLng) / 2;

        const resultMap = L.map('result-map').setView([centerLat, centerLng], 4);

        // Ajouter les tuiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(resultMap);

        // Marqueur de votre estimation (rouge)
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
          .bindPopup('<b>Votre estimation</b><br><?php echo number_format($distance_km); ?> km de distance');

        // Marqueur du lieu correct (vert)
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
          .bindPopup('<b>Lieu correct</b><br><?php echo htmlspecialchars($image_location); ?>');

        // Ligne entre les deux points
        L.polyline(
            [[userLat, userLng], [correctLat, correctLng]],
            {
                color: '#ef4444',
                weight: 3,
                opacity: 0.7,
                dashArray: '10, 10'
            }
        ).addTo(resultMap);

        // Ajuster la vue pour voir les deux marqueurs
        resultMap.fitBounds([
            [userLat, userLng],
            [correctLat, correctLng]
        ], { padding: [50, 50] });
    </script>
</body>
</html>
