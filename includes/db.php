<?php
$connexion = mysqli_connect('localhost', 'root', '', 'timeguessr');

if (!$connexion) {
	die('Erreur de connexion : ' . mysqli_connect_error());
}
?>
