<?php
/**
 * Script de téléchargement automatique des images historiques
 * Exécutez ce fichier UNE SEULE FOIS pour télécharger toutes les images
 */

set_time_limit(300); // 5 minutes max

$images_to_download = [
    [
        'filename' => '1903_aviation.jpg',
        'url' => 'https://picsum.photos/id/1/1200/600',
        'description' => '1903 - Aviation'
    ],
    [
        'filename' => '1912_titanic.jpg',
        'url' => 'https://picsum.photos/id/10/1200/600',
        'description' => '1912 - Titanic'
    ],
    [
        'filename' => '1936_depression.jpg',
        'url' => 'https://picsum.photos/id/20/1200/600',
        'description' => '1936 - Grande Dépression'
    ],
    [
        'filename' => '1945_wwii.jpg',
        'url' => 'https://picsum.photos/id/30/1200/600',
        'description' => '1945 - Fin WWII'
    ],
    [
        'filename' => '1957_car.jpg',
        'url' => 'https://picsum.photos/id/40/1200/600',
        'description' => '1957 - Chevrolet'
    ],
    [
        'filename' => '1960_beetle.jpg',
        'url' => 'https://picsum.photos/id/50/1200/600',
        'description' => '1960 - Coccinelle'
    ],
    [
        'filename' => '1969_moon.jpg',
        'url' => 'https://picsum.photos/id/60/1200/600',
        'description' => '1969 - Lune'
    ],
    [
        'filename' => '1969_woodstock.jpg',
        'url' => 'https://picsum.photos/id/70/1200/600',
        'description' => '1969 - Woodstock'
    ],
    [
        'filename' => '1976_concorde.jpg',
        'url' => 'https://picsum.photos/id/80/1200/600',
        'description' => '1976 - Concorde'
    ],
    [
        'filename' => '1977_disco.jpg',
        'url' => 'https://picsum.photos/id/90/1200/600',
        'description' => '1977 - Disco'
    ],
    [
        'filename' => '1982_computer.jpg',
        'url' => 'https://picsum.photos/id/100/1200/600',
        'description' => '1982 - Commodore 64'
    ],
    [
        'filename' => '1984_mac.jpg',
        'url' => 'https://picsum.photos/id/110/1200/600',
        'description' => '1984 - Macintosh'
    ],
    [
        'filename' => '1989_berlin.jpg',
        'url' => 'https://picsum.photos/id/119/1200/600',
        'description' => '1989 - Mur de Berlin'
    ],
    [
        'filename' => '1989_gameboy.jpg',
        'url' => 'https://picsum.photos/id/130/1200/600',
        'description' => '1989 - Game Boy'
    ],
    [
        'filename' => '1994_playstation.jpg',
        'url' => 'https://picsum.photos/id/140/1200/600',
        'description' => '1994 - PlayStation'
    ],
    [
        'filename' => '1998_wtc.jpg',
        'url' => 'https://picsum.photos/id/150/1200/600',
        'description' => '1998 - WTC'
    ],
    [
        'filename' => '2007_iphone.jpg',
        'url' => 'https://picsum.photos/id/160/1200/600',
        'description' => '2007 - iPhone'
    ],
    [
        'filename' => '2009_obama.jpg',
        'url' => 'https://picsum.photos/id/169/1200/600',
        'description' => '2009 - Obama'
    ],
    [
        'filename' => '2012_olympics.jpg',
        'url' => 'https://picsum.photos/id/180/1200/600',
        'description' => '2012 - JO Londres'
    ],
    [
        'filename' => '2015_social.jpg',
        'url' => 'https://picsum.photos/id/190/1200/600',
        'description' => '2015 - Réseaux sociaux'
    ]
];

$download_dir = 'assets/images/historical/';
$success_count = 0;
$error_count = 0;

echo "<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Téléchargement des images</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #1a1a1a; color: #fff; }
        .progress { background: #2a2a2a; padding: 20px; border-radius: 10px; margin: 10px 0; }
        .success { color: #10b981; }
        .error { color: #ef4444; }
        .info { color: #3b82f6; }
        h1 { color: #3b82f6; }
    </style>
</head>
<body>
    <h1>📥 Téléchargement des images historiques</h1>
    <p class='info'>Veuillez patienter pendant le téléchargement...</p>
";

foreach ($images_to_download as $image) {
    echo "<div class='progress'>";
    echo "Téléchargement : <strong>{$image['description']}</strong>...<br>";

    $destination = $download_dir . $image['filename'];

    // Télécharger l'image
    $ch = curl_init($image['url']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $image_data = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($image_data && $http_code == 200) {
        file_put_contents($destination, $image_data);
        echo "<span class='success'>✓ Téléchargé : {$image['filename']}</span><br>";
        $success_count++;
    } else {
        echo "<span class='error'>✗ Échec : {$image['filename']} (Code: $http_code)</span><br>";
        $error_count++;
    }

    echo "</div>";
    flush();

    // Petite pause pour ne pas surcharger le serveur
    usleep(200000); // 0.2 secondes
}

echo "
    <hr>
    <h2>📊 Résumé</h2>
    <p class='success'>✓ Images téléchargées : <strong>$success_count</strong></p>
    <p class='error'>✗ Échecs : <strong>$error_count</strong></p>
    <hr>
    <p class='info'>➡️ <a href='game.php' style='color: #3b82f6;'>Commencer à jouer !</a></p>
</body>
</html>
";
?>
