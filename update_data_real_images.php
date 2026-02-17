<?php
/**
 * Mise à jour de data.json avec les vraies photos historiques
 */

$new_data = [
    [
        'id' => 1,
        'url' => 'assets/images/historical/1906_earthquake_sf.jpg',
        'year' => 1906,
        'location' => 'San Francisco, USA',
        'description' => 'Tremblement de terre de San Francisco - Foules dans les rues',
        'hint' => 'Catastrophe naturelle majeure aux USA'
    ],
    [
        'id' => 2,
        'url' => 'assets/images/historical/1917_revolution_russia.jpg',
        'year' => 1917,
        'location' => 'Petrograd, Russie',
        'description' => 'Révolution russe - Bataillon féminin',
        'hint' => 'Révolution qui a changé la Russie'
    ],
    [
        'id' => 3,
        'url' => 'assets/images/historical/1929_wall_street_crash.jpg',
        'year' => 1929,
        'location' => 'New York, USA',
        'description' => 'Krach boursier de Wall Street - Foule devant la bourse',
        'hint' => 'Début de la Grande Dépression'
    ],
    [
        'id' => 4,
        'url' => 'assets/images/historical/1936_olympics_berlin.jpg',
        'year' => 1936,
        'location' => 'Berlin, Allemagne',
        'description' => 'Jeux Olympiques de Berlin - Cérémonie',
        'hint' => 'JO organisés par le régime nazi'
    ],
    [
        'id' => 5,
        'url' => 'assets/images/historical/1945_ve_day.jpg',
        'year' => 1945,
        'location' => 'Londres, UK',
        'description' => 'Jour de la Victoire en Europe - Foules célébrant',
        'hint' => 'Fin de la guerre en Europe'
    ],
    [
        'id' => 6,
        'url' => 'assets/images/historical/1947_independence_india.jpg',
        'year' => 1947,
        'location' => 'Inde',
        'description' => 'Indépendance de l\'Inde - Gandhi',
        'hint' => 'Fin de la colonisation britannique'
    ],
    [
        'id' => 7,
        'url' => 'assets/images/historical/1956_hungarian_revolution.jpg',
        'year' => 1956,
        'location' => 'Budapest, Hongrie',
        'description' => 'Révolution hongroise - Manifestants',
        'hint' => 'Soulèvement contre l\'URSS'
    ],
    [
        'id' => 8,
        'url' => 'assets/images/historical/1960_independence_congo.jpg',
        'year' => 1960,
        'location' => 'Léopoldville, Congo',
        'description' => 'Indépendance du Congo - Cérémonie',
        'hint' => 'Décolonisation africaine'
    ],
    [
        'id' => 9,
        'url' => 'assets/images/historical/1963_march_washington.jpg',
        'year' => 1963,
        'location' => 'Washington D.C., USA',
        'description' => 'Marche pour les droits civiques - I Have a Dream',
        'hint' => 'Discours de Martin Luther King'
    ],
    [
        'id' => 10,
        'url' => 'assets/images/historical/1968_prague_spring.jpg',
        'year' => 1968,
        'location' => 'Prague, Tchécoslovaquie',
        'description' => 'Printemps de Prague - Invasion soviétique',
        'hint' => 'Résistance pacifique contre les chars'
    ],
    [
        'id' => 11,
        'url' => 'assets/images/historical/1969_moonlanding_crowds.jpg',
        'year' => 1969,
        'location' => 'Lune',
        'description' => 'Apollo 11 - Buzz Aldrin sur la Lune',
        'hint' => 'Premier homme sur la Lune'
    ],
    [
        'id' => 12,
        'url' => 'assets/images/historical/1973_chile_coup.jpg',
        'year' => 1973,
        'location' => 'Santiago, Chili',
        'description' => 'Coup d\'État au Chili - Palais présidentiel bombardé',
        'hint' => 'Renversement de Salvador Allende'
    ],
    [
        'id' => 13,
        'url' => 'assets/images/historical/1979_iran_revolution.jpg',
        'year' => 1979,
        'location' => 'Téhéran, Iran',
        'description' => 'Révolution iranienne - Retour de Khomeini',
        'hint' => 'Révolution islamique'
    ],
    [
        'id' => 14,
        'url' => 'assets/images/historical/1986_chernobyl.jpg',
        'year' => 1986,
        'location' => 'Tchernobyl, Ukraine',
        'description' => 'Catastrophe nucléaire de Tchernobyl',
        'hint' => 'Pire accident nucléaire de l\'histoire'
    ],
    [
        'id' => 15,
        'url' => 'assets/images/historical/1989_tiananmen.jpg',
        'year' => 1989,
        'location' => 'Pékin, Chine',
        'description' => 'Place Tian\'anmen - Manifestations étudiantes',
        'hint' => 'Manifestations pour la démocratie'
    ],
    [
        'id' => 16,
        'url' => 'assets/images/historical/1989_berlin_wall.jpg',
        'year' => 1989,
        'location' => 'Berlin, Allemagne',
        'description' => 'Chute du mur de Berlin - Foules euphoriques',
        'hint' => 'Fin de la Guerre froide'
    ],
    [
        'id' => 17,
        'url' => 'assets/images/historical/1994_mandela_election.jpg',
        'year' => 1994,
        'location' => 'Afrique du Sud',
        'description' => 'Élection de Nelson Mandela - Fin de l\'apartheid',
        'hint' => 'Première élection démocratique'
    ],
    [
        'id' => 18,
        'url' => 'assets/images/historical/2001_september_11.jpg',
        'year' => 2001,
        'location' => 'New York, USA',
        'description' => 'World Trade Center avant le 11 septembre',
        'hint' => 'Année des attentats terroristes'
    ],
    [
        'id' => 19,
        'url' => 'assets/images/historical/2011_arab_spring.jpg',
        'year' => 2011,
        'location' => 'Le Caire, Égypte',
        'description' => 'Printemps arabe - Manifestations place Tahrir',
        'hint' => 'Révolutions au Moyen-Orient'
    ],
    [
        'id' => 20,
        'url' => 'assets/images/historical/2020_covid_lockdown.jpg',
        'year' => 2020,
        'location' => 'Monde entier',
        'description' => 'Pandémie COVID-19 - Confinement mondial',
        'hint' => 'Pandémie mondiale'
    ]
];

// Sauvegarder dans data.json
$json_content = json_encode($new_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
file_put_contents('data.json', $json_content);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mise à jour effectuée</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #1a1a1a; color: #fff; text-align: center; }
        h1 { color: #10b981; font-size: 3em; }
        .btn {
            display: inline-block;
            padding: 15px 40px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 1.2em;
            margin: 20px;
        }
        .btn:hover { background: #2563eb; }
    </style>
</head>
<body>
    <h1>✅ Mise à jour terminée !</h1>
    <p style="font-size: 1.5em;">data.json a été mis à jour avec 20 vraies photos historiques</p>

    <div style="margin-top: 50px;">
        <a href="reset_game.php" class="btn">🔄 Réinitialiser le jeu</a>
        <a href="game.php" class="btn">🎮 Commencer à jouer</a>
    </div>

    <div style="margin-top: 50px; text-align: left; max-width: 800px; margin-left: auto; margin-right: auto; background: #2a2a2a; padding: 30px; border-radius: 15px;">
        <h2>📋 Liste des nouvelles images :</h2>
        <ul style="line-height: 2;">
            <?php foreach ($new_data as $img): ?>
                <li><strong><?php echo $img['year']; ?></strong> - <?php echo $img['description']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
