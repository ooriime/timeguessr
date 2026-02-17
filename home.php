<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TimeGuessr</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="header">
    <div class="logo">TimeGuessr</div>
    <p class="subtitle">Devinez l'annee des evenements historiques !</p>
</div>

<div class="container">
    <h2>Bienvenue sur TimeGuessr</h2>
    <p>Dans ce jeu, une photo historique vous est presentee. Vous devez deviner :</p>
    <ul>
        <li>L'annee ou la photo a ete prise</li>
        <li>L'endroit ou elle a ete prise (sur la carte)</li>
    </ul>
    <p>Plus vous etes precis, plus vous gagnez de points (maximum 10 000 par round).</p>

    <br>
    <a href="game.php" class="btn btn-primary">Jouer</a>
</div>

<div class="footer">
    <p>TimeGuessr - projet scolaire</p>
</div>

</body>
</html>
