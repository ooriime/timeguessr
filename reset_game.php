<?php
session_start();

// Sauvegarder les statistiques globales avant de réinitialiser
$stats_file = 'stats.json';
$stats = [
    'total_games' => 0,
    'total_rounds' => 0,
    'best_score' => 0,
    'average_difference' => 0,
    'perfect_guesses' => 0,
    'last_updated' => null
];

// Charger les stats existantes
if (file_exists($stats_file)) {
    $stats_data = json_decode(file_get_contents($stats_file), true);
    if ($stats_data) {
        $stats = $stats_data;
    }
}

// Mettre à jour les stats si une partie a été jouée
if (isset($_SESSION['total_score']) && $_SESSION['rounds_played'] > 0) {
    $stats['total_games']++;
    $stats['total_rounds'] += $_SESSION['rounds_played'];

    if ($_SESSION['total_score'] > $stats['best_score']) {
        $stats['best_score'] = $_SESSION['total_score'];
    }

    // Calculer la moyenne des différences (approximatif)
    if (isset($_SESSION['total_difference'])) {
        $current_avg = $stats['average_difference'];
        $new_rounds = $_SESSION['rounds_played'];
        $total = $stats['total_rounds'];

        $stats['average_difference'] = (($current_avg * ($total - $new_rounds)) + $_SESSION['total_difference']) / $total;
    }

    $stats['last_updated'] = date('Y-m-d H:i:s');

    // Sauvegarder les stats
    file_put_contents($stats_file, json_encode($stats, JSON_PRETTY_PRINT));
}

// Réinitialiser toutes les variables de session
$_SESSION['total_score'] = 0;
$_SESSION['rounds_played'] = 0;
$_SESSION['image_index'] = 0;
$_SESSION['total_difference'] = 0;

// Supprimer les données temporaires
unset($_SESSION['shuffled_images']);
unset($_SESSION['user_guess']);
unset($_SESSION['score']);
unset($_SESSION['difference']);
unset($_SESSION['correct_year']);
unset($_SESSION['image_url']);
unset($_SESSION['image_location']);
unset($_SESSION['image_description']);
unset($_SESSION['image_hint']);

// Rediriger vers la page d'accueil
header('Location: home.php');
exit;
?>
