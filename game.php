<?php
// Page de jeu - affiche la photo et recoit la reponse du joueur

require_once 'includes/functions.php';
demarrer_session();

// Si pas de partie en cours, on renvoie a l'accueil
if (empty($_SESSION['id_partie'])) {
    rediriger('/index.php');
}

$id_partie = $_SESSION['id_partie'];
$manche_actuelle = $_SESSION['manche_actuelle'];

// On recupere les infos de la manche
$manche = get_manche($id_partie, $manche_actuelle);

// Si pas de manche, la partie est terminee
if (!$manche) {
    rediriger('/results.php');
}

$scores = null;
$reponse_envoyee = false;

// Traitement de la reponse du joueur
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'repondre') {
    $annee_joueur = (int)$_POST['annee_joueur'];
    $lat_joueur = $_POST['lat_joueur'] != '' ? (float)$_POST['lat_joueur'] : null;
    $lng_joueur = $_POST['lng_joueur'] != '' ? (float)$_POST['lng_joueur'] : null;

    $scores = enregistrer_reponse(
        $manche['id'],
        $manche['image_id'],
        $id_partie,
        $annee_joueur,
        $lat_joueur,
        $lng_joueur,
        $manche['annee_reelle'],
        $manche['lat_reelle'],
        $manche['lng_reelle']
    );

    $reponse_envoyee = true;
}

// Passage a la manche suivante
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'suivant') {
    $_SESSION['manche_actuelle']++;

    if ($_SESSION['manche_actuelle'] > NB_MANCHES) {
        terminer_partie($id_partie);
        rediriger('/results.php');
    }

    rediriger('/game.php');
}

include 'includes/header.php';
?>

<div class="contenu">

    <p class="manche-info">
        Manche <?php echo $manche_actuelle; ?> / <?php echo NB_MANCHES; ?>
    </p>

    <?php if (!$reponse_envoyee): ?>

    <!-- Phase de jeu : le joueur doit repondre -->
    <h2>Devinez l'annee et le lieu de cette photo :</h2>

    <img src="<?php echo h($manche['url']); ?>" alt="photo historique" class="photo-jeu">

    <form method="POST" action="/game.php" id="formulaire">
        <input type="hidden" name="action" value="repondre">

        <!-- Curseur pour l'annee -->
        <p class="label-annee">Annee estimee :</p>
        <p class="valeur-annee" id="affichage_annee">1960</p>
        <input type="range" name="annee_joueur" id="curseur_annee" min="1800" max="2024" value="1960" class="slider-annee"
               oninput="document.getElementById('affichage_annee').textContent = this.value">

        <!-- Carte pour le lieu -->
        <p class="label-annee" style="margin-top:20px;">Lieu (cliquez sur la carte) :</p>
        <div id="carte" class="carte"></div>
        <p class="info-carte" id="info_epingle">Aucune epingle placee (optionnel)</p>
        <input type="hidden" name="lat_joueur" id="lat_joueur" value="">
        <input type="hidden" name="lng_joueur" id="lng_joueur" value="">

        <button type="submit" class="btn btn-orange" style="margin-top:15px;">Valider ma reponse</button>
    </form>

    <?php else: ?>

    <!-- Phase de resultat de la manche -->
    <div class="resultat-manche">
        <h2><?php echo h($manche['title']); ?></h2>
        <p>Lieu reel : <strong><?php echo h($manche['location']); ?></strong></p>

        <p class="score-total-manche"><?php echo $scores['total']; ?> points</p>

        <div class="detail-score">
            <div class="bloc-score">
                <span>Score annee</span>
                <strong><?php echo $scores['score_annee']; ?> / <?php echo MAX_SCORE_ANNEE; ?></strong>
                <p>Votre reponse : <?php echo h($_POST['annee_joueur']); ?> &nbsp; Reelle : <?php echo h($manche['annee_reelle']); ?></p>
                <p>Ecart : <?php echo abs($_POST['annee_joueur'] - $manche['annee_reelle']); ?> ans</p>
            </div>
            <div class="bloc-score">
                <span>Score lieu</span>
                <strong><?php echo $scores['score_geo']; ?> / <?php echo MAX_SCORE_GEO; ?></strong>
                <?php if ($_POST['lat_joueur'] != ''): ?>
                    <p>Distance : <?php echo round(calculer_distance($_POST['lat_joueur'], $_POST['lng_joueur'], $manche['lat_reelle'], $manche['lng_reelle'])); ?> km</p>
                <?php else: ?>
                    <p>Lieu non indique</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Carte de correction -->
        <div id="carte_resultat" class="carte-resultat"></div>
    </div>

    <form method="POST" action="/game.php">
        <input type="hidden" name="action" value="suivant">
        <?php if ($manche_actuelle >= NB_MANCHES): ?>
            <button type="submit" class="btn btn-orange">Voir les resultats</button>
        <?php else: ?>
            <button type="submit" class="btn">Manche suivante</button>
        <?php endif; ?>
    </form>

    <script>
    // Carte de correction apres la reponse
    var lat_reelle = <?php echo (float)$manche['lat_reelle']; ?>;
    var lng_reelle = <?php echo (float)$manche['lng_reelle']; ?>;
    var lat_joueur = <?php echo $_POST['lat_joueur'] != '' ? (float)$_POST['lat_joueur'] : 'null'; ?>;
    var lng_joueur = <?php echo $_POST['lng_joueur'] != '' ? (float)$_POST['lng_joueur'] : 'null'; ?>;

    var carte = L.map('carte_resultat').setView([lat_reelle, lng_reelle], 3);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(carte);

    // Marqueur vert = lieu reel
    var icone_verte = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
        iconSize: [25, 41], iconAnchor: [12, 41]
    });
    L.marker([lat_reelle, lng_reelle], {icon: icone_verte}).addTo(carte).bindPopup('Lieu reel');

    // Marqueur rouge = reponse du joueur
    if (lat_joueur != null) {
        var icone_rouge = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
            iconSize: [25, 41], iconAnchor: [12, 41]
        });
        L.marker([lat_joueur, lng_joueur], {icon: icone_rouge}).addTo(carte).bindPopup('Votre reponse');
        L.polyline([[lat_reelle, lng_reelle], [lat_joueur, lng_joueur]], {color: 'red', dashArray: '6 4'}).addTo(carte);
        carte.fitBounds([[lat_reelle, lng_reelle], [lat_joueur, lng_joueur]], {padding: [40, 40]});
    }
    </script>

    <?php endif; ?>

</div>

<?php if (!$reponse_envoyee): ?>
<script>
// Carte interactive pour la reponse
var carte = L.map('carte').setView([20, 0], 2);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(carte);

var marqueur = null;

carte.on('click', function(e) {
    if (marqueur != null) {
        carte.removeLayer(marqueur);
    }
    marqueur = L.marker(e.latlng).addTo(carte);

    document.getElementById('lat_joueur').value = e.latlng.lat.toFixed(4);
    document.getElementById('lng_joueur').value = e.latlng.lng.toFixed(4);
    document.getElementById('info_epingle').textContent = 'Epingle placee : ' + e.latlng.lat.toFixed(4) + ', ' + e.latlng.lng.toFixed(4);
});
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
