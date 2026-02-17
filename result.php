<?php
session_start();
if (!isset($_SESSION['user_guess_year'])) { header('Location: game.php'); exit; }
$gy=$_SESSION['user_guess_year']; $glat=$_SESSION['user_guess_lat']; $glng=$_SESSION['user_guess_lng'];
$cy=$_SESSION['correct_year']; $clat=$_SESSION['correct_lat']; $clng=$_SESSION['correct_lng'];
$ydiff=$_SESSION['year_difference']; $dkm=$_SESSION['distance_km'];
$ys=$_SESSION['year_score']; $ds=$_SESSION['distance_score']; $score=$_SESSION['score'];
$img_url=$_SESSION['image_url']; $img_loc=$_SESSION['image_location']; $img_desc=$_SESSION['image_description'];
$total=$_SESSION['total_score']; $rounds=$_SESSION['rounds_played'];
$pct=($score/10000)*100;
if ($pct>=95) { $msg="Parfait ! Excellent travail !"; $cls="result-perfect"; }
elseif ($pct>=85) { $msg="Tres bien ! Impressionnant !"; $cls="result-excellent"; }
elseif ($pct>=70) { $msg="Bien joue !"; $cls="result-good"; }
elseif ($pct>=50) { $msg="Pas mal, continuez !"; $cls="result-ok"; }
elseif ($pct>=30) { $msg="Moyen, il faut reviser !"; $cls="result-medium"; }
else { $msg="Oups, c'etait loin !"; $cls="result-bad"; }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>TimeGuessr - Resultat</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>#result-map{width:100%;height:400px;border:1px solid #ccc;margin:15px 0}</style>
</head>
<body>
<div class="header"><a href="home.php"><div class="logo">TimeGuessr</div></a><p class="subtitle">Resultat</p></div>
<div class="container">
<div class="result-container">
<h1 class="result-title <?php echo $cls; ?>"><?php echo $msg; ?></h1>
<div class="image-container"><img src="<?php echo htmlspecialchars($img_url); ?>" alt="Photo"></div>
<div id="result-map"></div>
<h3>Resultats</h3>
<div class="result-grid">
<div class="result-card"><div class="result-label">Votre annee</div><div class="result-value"><?php echo $gy; ?></div></div>
<div class="result-card result-correct"><div class="result-label">Annee correcte</div><div class="result-value"><?php echo $cy; ?></div></div>
<div class="result-card"><div class="result-label">Difference</div><div class="result-value"><?php echo $ydiff; ?> ans</div></div>
</div>
<div class="result-grid">
<div class="result-card"><div class="result-label">Score annee</div><div class="result-value"><?php echo $ys; ?></div></div>
<div class="result-card"><div class="result-label">Score distance (<?php echo $dkm; ?> km)</div><div class="result-value"><?php echo $ds; ?></div></div>
<div class="result-card result-correct"><div class="result-label">Score total</div><div class="result-value"><?php echo $score; ?> / 10000</div></div>
</div>
<div style="border:1px solid #ccc;padding:15px;margin-bottom:20px;background:#f9f9f9">
<strong><?php echo htmlspecialchars($img_loc); ?></strong><br>
<span style="color:#555"><?php echo htmlspecialchars($img_desc); ?></span>
</div>
<div class="btn-container">
<a href="game.php" class="btn btn-primary">Image suivante</a>
<a href="reset_game.php" class="btn btn-success">Recommencer</a>
</div>
</div>
</div>
<div class="footer"><p>TimeGuessr - projet scolaire</p></div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const uLat=<?php echo $glat; ?>,uLng=<?php echo $glng; ?>,cLat=<?php echo $clat; ?>,cLng=<?php echo $clng; ?>;
const m=L.map('result-map').setView([(uLat+cLat)/2,(uLng+cLng)/2],4);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap contributors'}).addTo(m);
L.marker([uLat,uLng]).addTo(m).bindPopup('Votre estimation - <?php echo $dkm; ?> km');
L.marker([cLat,cLng]).addTo(m).bindPopup('Lieu correct - <?php echo htmlspecialchars($img_loc); ?>');
L.polyline([[uLat,uLng],[cLat,cLng]],{color:'red',weight:2}).addTo(m);
m.fitBounds([[uLat,uLng],[cLat,cLng]],{padding:[50,50]});
</script>
</body>
</html>
