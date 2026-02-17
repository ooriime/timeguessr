<?php
session_start();
require_once 'includes/db.php';
$db = Database::getInstance();
$images = $db->getAllImages();
if (!isset($_SESSION['total_score'])) { $_SESSION['total_score'] = 0; $_SESSION['rounds_played'] = 0; }
if (!isset($_SESSION['image_index']) || !isset($_SESSION['shuffled_images'])) {
    $_SESSION['image_index'] = 0;
    shuffle($images);
    $_SESSION['shuffled_images'] = $images;
} else {
    $images = $_SESSION['shuffled_images'];
}
$idx = $_SESSION['image_index'];
if ($idx >= count($images)) { $_SESSION['image_index'] = 0; $idx = 0; shuffle($images); $_SESSION['shuffled_images'] = $images; }
$img = $images[$idx];
$_SESSION['correct_year'] = $img['year'];
$_SESSION['image_url'] = $img['url'];
$_SESSION['image_location'] = $img['location'];
$_SESSION['image_description'] = $img['description'];
$_SESSION['image_hint'] = $img['hint'];
$coords = [1906=>[37.7749,-122.4194],1929=>[40.7067,-74.0089],1945=>[51.5074,-0.1278],1963=>[38.8899,-77.0091],1968=>[50.0755,14.4378],1986=>[51.3890,30.0994],1989=>[52.5200,13.4050],2001=>[40.7128,-74.0060],2011=>[30.0444,31.2357]];
$_SESSION['correct_lat'] = $coords[$img['year']][0];
$_SESSION['correct_lng'] = $coords[$img['year']][1];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>TimeGuessr</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>#map{width:100%;height:400px;border:1px solid #ccc;margin:10px 0}</style>
</head>
<body>
<div class="header"><a href="home.php"><div class="logo">TimeGuessr</div></a><p class="subtitle">Devinez l'annee et le lieu !</p></div>
<div class="container">
<div class="game-info">
<div class="score-display">
<div class="score-item"><div class="score-label">Score</div><div class="score-value"><?php echo $_SESSION['total_score']; ?></div></div>
<div class="score-item"><div class="score-label">Rounds</div><div class="score-value"><?php echo $_SESSION['rounds_played']; ?></div></div>
<div class="score-item"><div class="score-label">Image</div><div class="score-value"><?php echo ($idx+1).'/'.count($images); ?></div></div>
</div>
</div>
<div class="image-container">
<img src="<?php echo htmlspecialchars($img['url']); ?>" alt="Photo">
<div class="image-hint">Indice : <?php echo htmlspecialchars($img['hint']); ?></div>
</div>
<div class="guess-section">
<h2>En quelle annee et ou cette photo a-t-elle ete prise ?</h2>
<div style="margin-bottom:20px">
<h3>Annee</h3>
<input type="number" id="year-input" class="year-input" min="1800" max="2024" value="1950"><br>
<input type="range" id="year-slider" class="year-slider" min="1800" max="2024" value="1950" step="1">
</div>
<div>
<h3>Lieu</h3>
<p class="map-instructions">Cliquez sur la carte pour placer votre marqueur</p>
<div id="map"></div>
<div class="coordinates-display" id="coords-display">Aucune position selectionnee</div>
</div>
<form id="guess-form" action="process_guess.php" method="POST" style="margin-top:15px">
<input type="hidden" id="year-guess" name="year_guess" value="1950">
<input type="hidden" id="lat-guess" name="lat_guess" value="">
<input type="hidden" id="lng-guess" name="lng_guess" value="">
<button type="submit" class="btn btn-primary" id="submit-btn" disabled>Valider</button>
<p style="font-size:13px;color:#666;margin-top:8px">Vous devez cliquer sur la carte avant de valider.</p>
</form>
</div>
</div>
<div class="footer"><p>TimeGuessr - projet scolaire</p></div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="assets/js/main.js"></script>
<script>
const map = L.map('map').setView([20,0],2);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap contributors'}).addTo(map);
let marker=null,selectedLat=null,selectedLng=null;
map.on('click',function(e){
    if(marker) map.removeLayer(marker);
    marker=L.marker([e.latlng.lat,e.latlng.lng]).addTo(map);
    selectedLat=e.latlng.lat.toFixed(4);
    selectedLng=e.latlng.lng.toFixed(4);
    document.getElementById('coords-display').innerHTML='Position : '+selectedLat+', '+selectedLng;
    document.getElementById('lat-guess').value=selectedLat;
    document.getElementById('lng-guess').value=selectedLng;
    document.getElementById('submit-btn').disabled=false;
});
document.getElementById('year-input').addEventListener('input',function(){document.getElementById('year-guess').value=this.value;});
document.getElementById('year-slider').addEventListener('input',function(){document.getElementById('year-input').value=this.value;document.getElementById('year-guess').value=this.value;});
document.getElementById('guess-form').addEventListener('submit',function(e){if(!selectedLat||!selectedLng){e.preventDefault();alert('Cliquez sur la carte avant de valider !');}});
</script>
</body>
</html>
