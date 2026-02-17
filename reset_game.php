<?php
session_start();
$_SESSION['score_total'] = 0;
$_SESSION['nb_rounds'] = 0;
$_SESSION['index_image'] = 0;
unset($_SESSION['images_melangees']);
unset($_SESSION['user_guess_year']);
unset($_SESSION['correct_year']);
unset($_SESSION['image_url']);
unset($_SESSION['image_location']);
unset($_SESSION['image_description']);
unset($_SESSION['image_hint']);
header('Location: home.php');
exit;
?>
