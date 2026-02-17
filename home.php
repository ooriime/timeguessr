<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>TimeGuessr</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="header">
	<h1>TimeGuessr</h1>
</div>

<h2>Bienvenue !</h2>

<p>Dans ce jeu vous allez voir des photos historiques et vous devez deviner :</p>
<ul>
	<li>L'annee ou la photo a ete prise</li>
	<li>Le lieu ou la photo a ete prise (sur une carte)</li>
</ul>

<p>Vous pouvez gagner jusqu'a <b>10 000 points</b> par round.</p>
<p>Plus votre reponse est proche de la vraie annee et du vrai lieu, plus vous gagnez de points.</p>

<br>
<a href="game.php" class="btn">Commencer le jeu</a>

<br><br>

<div class="footer">
	<p>Projet scolaire - TimeGuessr</p>
</div>

</body>
</html>
