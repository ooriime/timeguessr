<?php
// Fonctions utiles pour le jeu

require_once __DIR__ . '/db.php';

// Nombre de manches par partie
define('NB_MANCHES', 5);
// Score max pour l'annee et le lieu
define('MAX_SCORE_ANNEE', 5000);
define('MAX_SCORE_GEO', 5000);

// Demarre la session si pas encore demarree
function demarrer_session() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

// Redirige vers une page
function rediriger($url) {
    header('Location: ' . $url);
    exit;
}

// Evite les failles XSS en echappant le texte
function h($texte) {
    return htmlspecialchars((string)$texte, ENT_QUOTES, 'UTF-8');
}

// Cree une nouvelle partie et la met en session
function creer_partie() {
    $db = get_db();

    // On prend 5 images au hasard
    $req = $db->query('SELECT id FROM images ORDER BY RAND() LIMIT ' . NB_MANCHES);
    $ids = $req->fetchAll(PDO::FETCH_COLUMN);

    // On cree la partie dans la base
    $db->exec('INSERT INTO games (total_score) VALUES (0)');
    $id_partie = $db->lastInsertId();

    // On cree les manches
    $stmt = $db->prepare('INSERT INTO rounds (game_id, image_id, round_number) VALUES (:gid, :iid, :num)');
    for ($i = 0; $i < count($ids); $i++) {
        $stmt->execute(array(':gid' => $id_partie, ':iid' => $ids[$i], ':num' => $i + 1));
    }

    // On sauvegarde en session
    $_SESSION['id_partie'] = $id_partie;
    $_SESSION['manche_actuelle'] = 1;
}

// Recupere les infos d'une manche
function get_manche($id_partie, $numero) {
    $db = get_db();
    $stmt = $db->prepare(
        'SELECT r.*, i.title, i.url, i.year AS annee_reelle,
                i.latitude AS lat_reelle, i.longitude AS lng_reelle, i.location
         FROM rounds r
         JOIN images i ON i.id = r.image_id
         WHERE r.game_id = :gid AND r.round_number = :num'
    );
    $stmt->execute(array(':gid' => $id_partie, ':num' => $numero));
    return $stmt->fetch();
}

// Recupere toutes les manches d'une partie
function get_toutes_manches($id_partie) {
    $db = get_db();
    $stmt = $db->prepare(
        'SELECT r.*, i.title, i.url, i.year AS annee_reelle,
                i.latitude AS lat_reelle, i.longitude AS lng_reelle, i.location
         FROM rounds r
         JOIN images i ON i.id = r.image_id
         WHERE r.game_id = :gid
         ORDER BY r.round_number ASC'
    );
    $stmt->execute(array(':gid' => $id_partie));
    return $stmt->fetchAll();
}

// Calcule le score pour l'annee
// Plus on est proche, plus on a de points
function calculer_score_annee($annee_joueur, $annee_reelle) {
    $difference = abs($annee_joueur - $annee_reelle);
    $score = MAX_SCORE_ANNEE * (1 - $difference / 50);
    if ($score < 0) $score = 0;
    return round($score);
}

// Calcule la distance en km entre deux points GPS (formule de Haversine)
function calculer_distance($lat1, $lng1, $lat2, $lng2) {
    $rayon_terre = 6371;
    $dlat = deg2rad($lat2 - $lat1);
    $dlng = deg2rad($lng2 - $lng1);
    $a = sin($dlat / 2) * sin($dlat / 2)
       + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dlng / 2) * sin($dlng / 2);
    return 2 * $rayon_terre * asin(sqrt($a));
}

// Calcule le score pour le lieu
function calculer_score_geo($lat_joueur, $lng_joueur, $lat_reelle, $lng_reelle) {
    $distance = calculer_distance($lat_joueur, $lng_joueur, $lat_reelle, $lng_reelle);
    $score = MAX_SCORE_GEO * exp(-$distance / 2000);
    if ($score < 0) $score = 0;
    return round($score);
}

// Enregistre la reponse du joueur et calcule les scores
function enregistrer_reponse($id_round, $id_image, $id_partie, $annee_joueur, $lat_joueur, $lng_joueur, $annee_reelle, $lat_reelle, $lng_reelle) {
    $db = get_db();

    $score_annee = calculer_score_annee($annee_joueur, $annee_reelle);
    $score_geo = 0;

    if ($lat_joueur != null && $lng_joueur != null) {
        $score_geo = calculer_score_geo($lat_joueur, $lng_joueur, $lat_reelle, $lng_reelle);
    }

    $total = $score_annee + $score_geo;

    // Mise a jour de la manche
    $stmt = $db->prepare(
        'UPDATE rounds SET guessed_year=:ay, guessed_lat=:lat, guessed_lng=:lng,
         year_score=:sa, geo_score=:sg, total_score=:tot, answered_at=NOW()
         WHERE id=:id'
    );
    $stmt->execute(array(
        ':ay'  => $annee_joueur,
        ':lat' => $lat_joueur,
        ':lng' => $lng_joueur,
        ':sa'  => $score_annee,
        ':sg'  => $score_geo,
        ':tot' => $total,
        ':id'  => $id_round
    ));

    // Mise a jour du score de la partie
    $stmt2 = $db->prepare('UPDATE games SET total_score = total_score + :tot WHERE id = :gid');
    $stmt2->execute(array(':tot' => $total, ':gid' => $id_partie));

    // Mise a jour des statistiques
    maj_statistiques($id_image, abs($annee_joueur - $annee_reelle), ($lat_joueur != null ? calculer_distance($lat_joueur, $lng_joueur, $lat_reelle, $lng_reelle) : null), $total);

    return array('score_annee' => $score_annee, 'score_geo' => $score_geo, 'total' => $total);
}

// Met a jour les statistiques d'une image
function maj_statistiques($id_image, $erreur_annee, $erreur_geo, $score) {
    $db = get_db();
    $stmt = $db->prepare(
        'UPDATE score_history
         SET play_count = play_count + 1,
             avg_year_error = (avg_year_error * play_count + :ea) / (play_count + 1),
             avg_geo_error = CASE WHEN :eg IS NOT NULL THEN (avg_geo_error * play_count + :eg2) / (play_count + 1) ELSE avg_geo_error END,
             avg_score = (avg_score * play_count + :sc) / (play_count + 1)
         WHERE image_id = :iid'
    );
    $stmt->execute(array(':ea' => $erreur_annee, ':eg' => $erreur_geo, ':eg2' => $erreur_geo, ':sc' => $score, ':iid' => $id_image));
}

// Marque la partie comme terminee
function terminer_partie($id_partie) {
    $db = get_db();
    $stmt = $db->prepare('UPDATE games SET finished_at = NOW() WHERE id = :id');
    $stmt->execute(array(':id' => $id_partie));
}
