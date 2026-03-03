<?php
// Page d'accueil du jeu

require_once 'includes/functions.php';
demarrer_session();

// Si le joueur clique sur "Nouvelle partie"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    creer_partie();
    rediriger('/game.php');
}

include 'includes/header.php';
?>

<div class="contenu">
    <h1>Bienvenue sur TimeGuessr !</h1>

    <p class="accueil-intro">
        Dans ce jeu, on vous montre une photo historique et vous devez deviner l'annee
        ou elle a ete prise, et l'endroit dans le monde.
    </p>

    <div class="regles">
        <h2>Comment jouer ?</h2>
        <ul>
            <li>Une photo historique vous est presentee.</li>
            <li>Utilisez le curseur pour choisir l'annee.</li>
            <li>Cliquez sur la carte pour indiquer le lieu.</li>
            <li>Plus vous etes precis, plus vous gagnez de points !</li>
        </ul>
        <p><strong>5 manches</strong> - Score maximum : <strong>50 000 points</strong></p>
    </div>

    <form method="POST" action="/index.php">
        <button type="submit" class="btn btn-orange">Commencer une partie</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
