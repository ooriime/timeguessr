<?php
/**
 * Téléchargement de VRAIES photos historiques depuis Wikimedia Commons
 * Images de foules, manifestations, événements historiques majeurs
 */

set_time_limit(600); // 10 minutes

$images_to_download = [
    [
        'filename' => '1906_earthquake_sf.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/60/1906_Earthquake_-_Aftermath_of_fire_in_San_Francisco.jpg/1280px-1906_Earthquake_-_Aftermath_of_fire_in_San_Francisco.jpg',
        'year' => 1906,
        'location' => 'San Francisco, USA',
        'description' => 'Tremblement de terre de San Francisco - Foules dans les rues',
        'hint' => 'Catastrophe naturelle majeure aux USA'
    ],
    [
        'filename' => '1917_revolution_russia.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/33/1917_female_battalion.jpg/1280px-1917_female_battalion.jpg',
        'year' => 1917,
        'location' => 'Petrograd, Russie',
        'description' => 'Révolution russe - Bataillon féminin',
        'hint' => 'Révolution qui a changé la Russie'
    ],
    [
        'filename' => '1929_wall_street_crash.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/Crowd_outside_nyse.jpg/1280px-Crowd_outside_nyse.jpg',
        'year' => 1929,
        'location' => 'New York, USA',
        'description' => 'Krach boursier de Wall Street - Foule devant la bourse',
        'hint' => 'Début de la Grande Dépression'
    ],
    [
        'filename' => '1936_olympics_berlin.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1d/Bundesarchiv_Bild_183-G00825%2C_Sommerolympiade%2C_Siegerehrung_Stabhochsprung.jpg/1280px-Bundesarchiv_Bild_183-G00825%2C_Sommerolympiade%2C_Siegerehrung_Stabhochsprung.jpg',
        'year' => 1936,
        'location' => 'Berlin, Allemagne',
        'description' => 'Jeux Olympiques de Berlin - Cérémonie',
        'hint' => 'JO organisés par le régime nazi'
    ],
    [
        'filename' => '1945_ve_day.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fb/Celebration_of_VE_Day.jpg/1280px-Celebration_of_VE_Day.jpg',
        'year' => 1945,
        'location' => 'Londres, UK',
        'description' => 'Jour de la Victoire en Europe - Foules célébrant',
        'hint' => 'Fin de la guerre en Europe'
    ],
    [
        'filename' => '1947_independence_india.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Mahatma-Gandhi%2C_studio%2C_1931.jpg/800px-Mahatma-Gandhi%2C_studio%2C_1931.jpg',
        'year' => 1947,
        'location' => 'Inde',
        'description' => 'Indépendance de l\'Inde - Gandhi',
        'hint' => 'Fin de la colonisation britannique'
    ],
    [
        'filename' => '1956_hungarian_revolution.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/Kossuth_Square_Budapest_1956_October_25.jpg/1280px-Kossuth_Square_Budapest_1956_October_25.jpg',
        'year' => 1956,
        'location' => 'Budapest, Hongrie',
        'description' => 'Révolution hongroise - Manifestants',
        'hint' => 'Soulèvement contre l\'URSS'
    ],
    [
        'filename' => '1960_independence_congo.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/90/Independence_ceremony_Congo_1960.jpg/1280px-Independence_ceremony_Congo_1960.jpg',
        'year' => 1960,
        'location' => 'Léopoldville, Congo',
        'description' => 'Indépendance du Congo - Cérémonie',
        'hint' => 'Décolonisation africaine'
    ],
    [
        'filename' => '1963_march_washington.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/19/March_on_Washington_edit.jpg/1280px-March_on_Washington_edit.jpg',
        'year' => 1963,
        'location' => 'Washington D.C., USA',
        'description' => 'Marche pour les droits civiques - I Have a Dream',
        'hint' => 'Discours de Martin Luther King'
    ],
    [
        'filename' => '1968_prague_spring.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Czechoslovak_citizens_confront_Soviet_troops_-_Flickr_-_The_Central_IA.jpg/1280px-Czechoslovak_citizens_confront_Soviet_troops_-_Flickr_-_The_Central_IA.jpg',
        'year' => 1968,
        'location' => 'Prague, Tchécoslovaquie',
        'description' => 'Printemps de Prague - Invasion soviétique',
        'hint' => 'Résistance pacifique contre les chars'
    ],
    [
        'filename' => '1969_moonlanding_crowds.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/Aldrin_Apollo_11_original.jpg/800px-Aldrin_Apollo_11_original.jpg',
        'year' => 1969,
        'location' => 'Lune',
        'description' => 'Apollo 11 - Buzz Aldrin sur la Lune',
        'hint' => 'Premier homme sur la Lune'
    ],
    [
        'filename' => '1973_chile_coup.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Palacio_de_La_Moneda_during_coup.jpg/1280px-Palacio_de_La_Moneda_during_coup.jpg',
        'year' => 1973,
        'location' => 'Santiago, Chili',
        'description' => 'Coup d\'État au Chili - Palais présidentiel bombardé',
        'hint' => 'Renversement de Salvador Allende'
    ],
    [
        'filename' => '1979_iran_revolution.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bd/Ruhollah_Khomeini_in_Mehrabad.jpg/1280px-Ruhollah_Khomeini_in_Mehrabad.jpg',
        'year' => 1979,
        'location' => 'Téhéran, Iran',
        'description' => 'Révolution iranienne - Retour de Khomeini',
        'hint' => 'Révolution islamique'
    ],
    [
        'filename' => '1986_chernobyl.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/Chernobyl_reactor_4_aerial_view.jpg/1280px-Chernobyl_reactor_4_aerial_view.jpg',
        'year' => 1986,
        'location' => 'Tchernobyl, Ukraine',
        'description' => 'Catastrophe nucléaire de Tchernobyl',
        'hint' => 'Pire accident nucléaire de l\'histoire'
    ],
    [
        'filename' => '1989_tiananmen.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d8/Tiananmen_Square_crowds.jpg/1280px-Tiananmen_Square_crowds.jpg',
        'year' => 1989,
        'location' => 'Pékin, Chine',
        'description' => 'Place Tian\'anmen - Manifestations étudiantes',
        'hint' => 'Manifestations pour la démocratie'
    ],
    [
        'filename' => '1989_berlin_wall.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/89/Thefalloftheberlinwall1989.JPG/1280px-Thefalloftheberlinwall1989.JPG',
        'year' => 1989,
        'location' => 'Berlin, Allemagne',
        'description' => 'Chute du mur de Berlin - Foules euphoriques',
        'hint' => 'Fin de la Guerre froide'
    ],
    [
        'filename' => '1994_mandela_election.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/32/Nelson_Mandela-2008_%28edit%29.jpg/800px-Nelson_Mandela-2008_%28edit%29.jpg',
        'year' => 1994,
        'location' => 'Afrique du Sud',
        'description' => 'Élection de Nelson Mandela - Fin de l\'apartheid',
        'hint' => 'Première élection démocratique'
    ],
    [
        'filename' => '2001_september_11.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/00/World_Trade_Center%2C_New_York_City_-_aerial_view_%28March_2001%29.jpg/1280px-World_Trade_Center%2C_New_York_City_-_aerial_view_%28March_2001%29.jpg',
        'year' => 2001,
        'location' => 'New York, USA',
        'description' => 'World Trade Center avant le 11 septembre',
        'hint' => 'Année des attentats terroristes'
    ],
    [
        'filename' => '2011_arab_spring.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/91/Egyptprotests.jpg/1280px-Egyptprotests.jpg',
        'year' => 2011,
        'location' => 'Le Caire, Égypte',
        'description' => 'Printemps arabe - Manifestations place Tahrir',
        'hint' => 'Révolutions au Moyen-Orient'
    ],
    [
        'filename' => '2020_covid_lockdown.jpg',
        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/COVID-19_Outbreak_World_Map.svg/1280px-COVID-19_Outbreak_World_Map.svg.png',
        'year' => 2020,
        'location' => 'Monde entier',
        'description' => 'Pandémie COVID-19 - Confinement mondial',
        'hint' => 'Pandémie mondiale'
    ]
];

$download_dir = 'assets/images/historical/';
$success_count = 0;
$error_count = 0;

echo "<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Téléchargement des vraies photos historiques</title>
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
    <h1>📥 Téléchargement de 20 photos historiques réelles</h1>
    <p class='info'>Images de Wikimedia Commons - Photos authentiques d'événements historiques</p>
";

foreach ($images_to_download as $image) {
    echo "<div class='progress'>";
    echo "Téléchargement : <strong>{$image['year']} - {$image['description']}</strong>...<br>";

    $destination = $download_dir . $image['filename'];

    $ch = curl_init($image['url']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, 'TimeGuessrGame/1.0');

    $image_data = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($image_data && $http_code == 200) {
        file_put_contents($destination, $image_data);
        echo "<span class='success'>✓ {$image['filename']} ({$image['location']})</span><br>";
        $success_count++;
    } else {
        echo "<span class='error'>✗ Échec : {$image['filename']} (HTTP $http_code)</span><br>";
        $error_count++;
    }

    echo "</div>";
    flush();
    usleep(500000); // 0.5 secondes entre chaque
}

echo "
    <hr>
    <h2>📊 Résumé</h2>
    <p class='success'>✓ Images téléchargées : <strong>$success_count / 20</strong></p>
    <p class='error'>✗ Échecs : <strong>$error_count</strong></p>
    <hr>
    <p class='info'>➡️ <a href='update_data_real_images.php' style='color: #3b82f6;'>Mettre à jour data.json avec les nouvelles images</a></p>
</body>
</html>
";
?>
