<?php
// Connexion a la base de donnees

function get_db() {
    static $connexion = null;

    if ($connexion == null) {
        $dsn = 'mysql:host=localhost;dbname=timeguessr;charset=utf8mb4';
        $connexion = new PDO($dsn, 'root', '');
        $connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    return $connexion;
}
