<?php
// Page de resultats finaux

require_once 'includes/functions.php';
demarrer_session();

if (empty($_SESSION['id_partie'])) {
    rediriger('/index.php');
}

$id_partie = $_SESSION['id_partie'];

// Recupere toutes les manches de la partie
$manches = get_toutes_manches($id_partie);

// Recupere le score total
$db = get_db();
$stmt = $db->prepare('SELECT total_score FROM games WHERE id = :id');
$stmt->execute(array(':id' => $id_partie));
$partie = $stmt->fetch();
$score_total = $partie['total_score'];

// Score max possible
$score_max = NB_MANCHES * (MAX_SCORE_ANNEE + MAX_SCORE_GEO);
$pourcentage = round($score_total / $score_max * 100);

// On efface la session pour permettre une nouvelle partie
unset($_SESSION['id_partie']);
unset($_SESSION['manche_actuelle']);

include 'includes/header.php';
?>

<div class="contenu">
    <h1>Partie terminee !</h1>

    <div class="score-final">
        <div class="nombre"><?php echo $score_total; ?> pts</div>
        <div class="mention">
            <?php
            if ($pourcentage >= 80) {
                echo 'Excellent ! Vous etes un expert de l\'histoire !';
            } elseif ($pourcentage >= 50) {
                echo 'Bien joue ! Pas mal du tout.';
            } else {
                echo 'A vous de retenter pour faire mieux !';
            }
            ?>
        </div>
        <p style="color:#888; margin-top:5px;"><?php echo $pourcentage; ?>% du score maximum</p>
    </div>

    <h2>Detail des manches :</h2>

    <?php foreach ($manches as $m): ?>
    <div class="recap-manche">
        <img src="<?php echo h($m['url']); ?>" alt="<?php echo h($m['title']); ?>">
        <div>
            <h3>Manche <?php echo $m['round_number']; ?> - <?php echo h($m['title']); ?></h3>
            <p>Lieu : <?php echo h($m['location']); ?> | Annee reelle : <?php echo h($m['annee_reelle']); ?></p>
            <p>Score annee : <?php echo $m['year_score']; ?> pts &nbsp; Score lieu : <?php echo $m['geo_score']; ?> pts</p>
            <p class="pts"><?php echo $m['total_score']; ?> pts au total</p>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="boutons-fin">
        <form method="POST" action="/index.php">
            <button type="submit" class="btn btn-orange">Rejouer</button>
        </form>
        <a href="/history.php" class="btn">Voir les statistiques</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
