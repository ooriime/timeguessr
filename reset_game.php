<?php
session_start();

$_SESSION['total_score'] = 0;
$_SESSION['rounds_played'] = 0;
$_SESSION['image_index'] = 0;
$_SESSION['total_difference'] = 0;

unset($_SESSION['shuffled_images']);
unset($_SESSION['user_guess']);
unset($_SESSION['score']);
unset($_SESSION['difference']);
unset($_SESSION['correct_year']);
unset($_SESSION['image_url']);
unset($_SESSION['image_location']);
unset($_SESSION['image_description']);
unset($_SESSION['image_hint']);

header('Location: home.php');
exit;
?>
