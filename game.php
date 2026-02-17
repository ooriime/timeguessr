<?php
session_start();

// Charger la base de données
require_once 'includes/db.php';
$db = Database::getInstance();

// Charger toutes les images depuis la BDD
$images = $db->getAllImages();

// Initialiser ou récupérer le score total
if (!isset($_SESSION['total_score'])) {
    $_SESSION['total_score'] = 0;
    $_SESSION['rounds_played'] = 0;
}

// Initialiser l'index de l'image et les images mélangées
if (!isset($_SESSION['image_index']) || !isset($_SESSION['shuffled_images'])) {
    $_SESSION['image_index'] = 0;
    // Mélanger les images pour chaque nouvelle session
    shuffle($images);
    $_SESSION['shuffled_images'] = $images;
} else {
    // Utiliser les images déjà mélangées
    $images = $_SESSION['shuffled_images'];
}

// Récupérer l'image actuelle
$current_image_index = $_SESSION['image_index'];

// Si on a parcouru toutes les images, recommencer
if ($current_image_index >= count($images)) {
    $_SESSION['image_index'] = 0;
    $current_image_index = 0;
    shuffle($images);
    $_SESSION['shuffled_images'] = $images;
}

$image_data = $images[$current_image_index];
$_SESSION['correct_year'] = $image_data['year'];
$_SESSION['image_url'] = $image_data['url'];
$_SESSION['image_location'] = $image_data['location'];
$_SESSION['image_description'] = $image_data['description'];
$_SESSION['image_hint'] = $image_data['hint'];

// Coordonnées réelles des événements (latitude, longitude)
$coordinates = [
    1906 => [37.7749, -122.4194],  // San Francisco
    1929 => [40.7067, -74.0089],   // Wall Street, NY
    1945 => [51.5074, -0.1278],    // Londres
    1963 => [38.8899, -77.0091],   // Washington DC
    1968 => [50.0755, 14.4378],    // Prague
    1969 => [0.6875, 23.4733],     // Lune (approximatif sur Terre)
    1986 => [51.3890, 30.0994],    // Tchernobyl
    1989 => [52.5200, 13.4050],    // Berlin
    2001 => [40.7128, -74.0060],   // New York
    2011 => [30.0444, 31.2357]     // Le Caire
];

$_SESSION['correct_lat'] = $coordinates[$image_data['year']][0];
$_SESSION['correct_lng'] = $coordinates[$image_data['year']][1];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeGuessr - Devinez l'année !</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            width: 100%;
            height: 500px;
            border-radius: 12px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }
        .map-instructions {
            text-align: center;
            color: var(--text-secondary);
            margin-bottom: 20px;
            font-size: 1.1em;
        }
        .coordinates-display {
            background: var(--dark-bg);
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            text-align: center;
            color: var(--primary-color);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="home.php" style="text-decoration: none;">
            <div class="logo">⏰ TimeGuessr</div>
        </a>
        <p class="subtitle">Devinez l'année de ces moments historiques !</p>
    </header>

    <div class="container">
        <div class="game-info">
            <div class="score-display">
                <div class="score-item">
                    <div class="score-label">Score Total</div>
                    <div class="score-value"><?php echo $_SESSION['total_score']; ?></div>
                </div>
                <div class="score-item">
                    <div class="score-label">Rounds Joués</div>
                    <div class="score-value"><?php echo $_SESSION['rounds_played']; ?></div>
                </div>
                <div class="score-item">
                    <div class="score-label">Image</div>
                    <div class="score-value"><?php echo ($current_image_index + 1) . '/' . count($images); ?></div>
                </div>
            </div>
        </div>

        <div class="image-container">
            <img src="<?php echo htmlspecialchars($image_data['url']); ?>" alt="Devinez l'année">
            <div class="image-hint">💡 <?php echo htmlspecialchars($image_data['hint']); ?></div>
        </div>

        <div class="guess-section">
            <h2 class="guess-title">En quelle année et où cette photo a-t-elle été prise ?</h2>

            <!-- ANNÉE -->
            <div style="margin-bottom: 40px;">
                <h3 style="color: var(--text-primary); margin-bottom: 20px; font-size: 1.3em;">📅 Devinez l'année</h3>
                <div class="input-group">
                    <input
                        type="number"
                        id="year-input"
                        class="year-input"
                        min="1800"
                        max="2024"
                        value="1950"
                    >
                </div>
                <input
                    type="range"
                    id="year-slider"
                    class="year-slider"
                    min="1800"
                    max="2024"
                    value="1950"
                    step="1"
                >
            </div>

            <!-- CARTE -->
            <div>
                <h3 style="color: var(--text-primary); margin-bottom: 20px; font-size: 1.3em;">🗺️ Pointez sur la carte</h3>
                <p class="map-instructions">Cliquez sur la carte pour placer votre marqueur</p>
                <div id="map"></div>
                <div class="coordinates-display" id="coords-display">
                    📍 Cliquez sur la carte pour placer votre estimation
                </div>
            </div>

            <!-- FORMULAIRE -->
            <form id="guess-form" action="process_guess.php" method="POST" class="guess-form">
                <input type="hidden" id="year-guess" name="year_guess" value="1950">
                <input type="hidden" id="lat-guess" name="lat_guess" value="">
                <input type="hidden" id="lng-guess" name="lng_guess" value="">

                <button type="submit" class="btn btn-primary" id="submit-btn" disabled>
                    ✓ Valider mes estimations
                </button>
                <p style="color: var(--text-secondary); margin-top: 15px; font-size: 0.9em;">
                    Vous devez placer un marqueur sur la carte avant de valider
                </p>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>TimeGuessr - Un jeu pour tester vos connaissances en histoire</p>
        <p>Images provenant de Wikimedia Commons</p>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
        // Initialiser la carte
        const map = L.map('map').setView([20, 0], 2);

        // Ajouter les tuiles OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(map);

        let marker = null;
        let selectedLat = null;
        let selectedLng = null;

        // Gérer le clic sur la carte
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            // Supprimer l'ancien marqueur
            if (marker) {
                map.removeLayer(marker);
            }

            // Ajouter un nouveau marqueur
            marker = L.marker([lat, lng], {
                icon: L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                })
            }).addTo(map);

            // Sauvegarder les coordonnées
            selectedLat = lat.toFixed(4);
            selectedLng = lng.toFixed(4);

            // Mettre à jour l'affichage
            document.getElementById('coords-display').innerHTML =
                `📍 Position sélectionnée : ${selectedLat}, ${selectedLng}`;

            // Mettre à jour les champs cachés
            document.getElementById('lat-guess').value = selectedLat;
            document.getElementById('lng-guess').value = selectedLng;

            // Activer le bouton de soumission
            document.getElementById('submit-btn').disabled = false;
            document.getElementById('submit-btn').style.opacity = '1';
        });

        // Synchroniser l'année avec le formulaire
        document.getElementById('year-input').addEventListener('input', function() {
            document.getElementById('year-guess').value = this.value;
        });

        document.getElementById('year-slider').addEventListener('input', function() {
            document.getElementById('year-input').value = this.value;
            document.getElementById('year-guess').value = this.value;
        });

        // Validation du formulaire
        document.getElementById('guess-form').addEventListener('submit', function(e) {
            if (!selectedLat || !selectedLng) {
                e.preventDefault();
                alert('Veuillez placer un marqueur sur la carte avant de valider !');
                return false;
            }
        });
    </script>
</body>
</html>
