<?php
/**
 * TimeGuessr - Fichier de configuration
 * Centralisez ici tous les paramètres du jeu
 */

// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuration du jeu
define('GAME_NAME', 'TimeGuessr');
define('GAME_VERSION', '1.0.0');

// Paramètres de scoring
define('MAX_SCORE', 5000);              // Score maximum par round
define('MIN_YEAR', 1800);               // Année minimale pour les estimations
define('MAX_YEAR', 2024);               // Année maximale pour les estimations
define('DEFAULT_YEAR', 1950);           // Année par défaut du slider

// Système de points
$SCORING_SYSTEM = [
    'perfect' => ['difference' => 0, 'score' => 5000],
    'excellent' => ['max_difference' => 1, 'score' => 4950],
    'very_good' => ['max_difference' => 5, 'points_per_year' => 50],
    'good' => ['max_difference' => 10, 'points_per_year' => 50],
    'ok' => ['max_difference' => 25, 'points_per_year' => 50],
    'medium' => ['max_difference' => 50, 'points_per_year' => 50],
    'bad' => ['max_difference' => 100, 'points_per_year' => 50]
];

// Messages de feedback selon la performance
$FEEDBACK_MESSAGES = [
    'perfect' => "🎉 PARFAIT ! Vous êtes un expert !",
    'excellent' => "🔥 Excellent ! Très proche !",
    'very_good' => "✨ Impressionnant ! Belle précision !",
    'good' => "👍 Très bien ! Belle estimation !",
    'ok' => "👌 Pas mal ! Vous y êtes presque !",
    'medium' => "🤔 Moyen... Il faut réviser !",
    'bad' => "😅 Oups ! C'était loin !"
];

// Chemins des fichiers
define('DATA_FILE', __DIR__ . '/../data.json');
define('ASSETS_PATH', '/assets/');
define('IMAGES_PATH', ASSETS_PATH . 'images/');

// Configuration de l'affichage
define('IMAGES_PER_SESSION', 20);       // Nombre d'images avant de remélanger
define('SHOW_HINTS', true);             // Afficher les indices
define('SHUFFLE_ON_START', true);       // Mélanger les images au démarrage

// Configuration des images
define('IMAGE_PLACEHOLDER', 'https://via.placeholder.com/1200x600?text=Image+non+disponible');
define('IMAGE_MAX_WIDTH', 1200);
define('IMAGE_MAX_HEIGHT', 600);

// Fonctions utilitaires

/**
 * Calculer le score en fonction de la différence
 */
function calculateScore($difference) {
    if ($difference == 0) {
        return 5000;
    } elseif ($difference == 1) {
        return 4950;
    } elseif ($difference <= 5) {
        return 5000 - ($difference * 50);
    } elseif ($difference <= 10) {
        return 4750 - (($difference - 5) * 50);
    } elseif ($difference <= 25) {
        return 4500 - (($difference - 10) * 50);
    } elseif ($difference <= 50) {
        return 3750 - (($difference - 25) * 50);
    } elseif ($difference <= 100) {
        return 2500 - (($difference - 50) * 50);
    } else {
        return 0;
    }
}

/**
 * Obtenir le message de feedback en fonction de la différence
 */
function getFeedbackMessage($difference) {
    global $FEEDBACK_MESSAGES;

    if ($difference == 0) {
        return $FEEDBACK_MESSAGES['perfect'];
    } elseif ($difference <= 1) {
        return $FEEDBACK_MESSAGES['excellent'];
    } elseif ($difference <= 5) {
        return $FEEDBACK_MESSAGES['very_good'];
    } elseif ($difference <= 10) {
        return $FEEDBACK_MESSAGES['good'];
    } elseif ($difference <= 25) {
        return $FEEDBACK_MESSAGES['ok'];
    } elseif ($difference <= 50) {
        return $FEEDBACK_MESSAGES['medium'];
    } else {
        return $FEEDBACK_MESSAGES['bad'];
    }
}

/**
 * Charger les images depuis le fichier JSON
 */
function loadImages() {
    $json_data = file_get_contents(DATA_FILE);
    return json_decode($json_data, true);
}

/**
 * Initialiser la session de jeu
 */
function initGameSession() {
    if (!isset($_SESSION['total_score'])) {
        $_SESSION['total_score'] = 0;
        $_SESSION['rounds_played'] = 0;
        $_SESSION['image_index'] = 0;
    }
}

/**
 * Sécuriser l'affichage HTML
 */
function sanitize($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Formater un nombre avec des espaces (ex: 1 000 000)
 */
function formatNumber($number) {
    return number_format($number, 0, ',', ' ');
}

// Protection CSRF (optionnel mais recommandé)
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
