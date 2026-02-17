<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('GAME_NAME', 'TimeGuessr');
define('GAME_VERSION', '1.0.0');

define('MAX_SCORE', 5000);
define('MIN_YEAR', 1800);
define('MAX_YEAR', 2024);
define('DEFAULT_YEAR', 1950);

define('DATA_FILE', __DIR__ . '/../data.json');
define('ASSETS_PATH', '/assets/');
define('IMAGES_PATH', ASSETS_PATH . 'images/');

define('IMAGES_PER_SESSION', 20);
define('SHOW_HINTS', true);
define('SHUFFLE_ON_START', true);

define('IMAGE_PLACEHOLDER', 'https://via.placeholder.com/1200x600?text=Image+non+disponible');
define('IMAGE_MAX_WIDTH', 1200);
define('IMAGE_MAX_HEIGHT', 600);

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

function sanitize($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function formatNumber($number) {
    return number_format($number, 0, ',', ' ');
}

function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
