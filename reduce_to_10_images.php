<?php
/**
 * Réduire le jeu à 10 images historiques iconiques
 */

require_once 'includes/db.php';

try {
    $db = Database::getInstance()->getConnection();

    // Supprimer toutes les images actuelles
    $db->exec('DELETE FROM images');

    // Les 10 images les plus iconiques
    $images = [
        [
            'url' => 'assets/images/historical/1906_earthquake_sf.jpg',
            'year' => 1906,
            'location' => 'San Francisco, USA',
            'description' => 'Tremblement de terre de San Francisco - Foules dans les rues',
            'hint' => 'Catastrophe naturelle majeure aux USA'
        ],
        [
            'url' => 'assets/images/historical/1929_wall_street_crash.jpg',
            'year' => 1929,
            'location' => 'New York, USA',
            'description' => 'Krach boursier de Wall Street - Foule devant la bourse',
            'hint' => 'Début de la Grande Dépression'
        ],
        [
            'url' => 'assets/images/historical/1945_ve_day.jpg',
            'year' => 1945,
            'location' => 'Londres, UK',
            'description' => 'Jour de la Victoire en Europe - Foules célébrant',
            'hint' => 'Fin de la guerre en Europe'
        ],
        [
            'url' => 'assets/images/historical/1963_march_washington.jpg',
            'year' => 1963,
            'location' => 'Washington D.C., USA',
            'description' => 'Marche pour les droits civiques - I Have a Dream',
            'hint' => 'Discours de Martin Luther King'
        ],
        [
            'url' => 'assets/images/historical/1968_prague_spring.jpg',
            'year' => 1968,
            'location' => 'Prague, Tchécoslovaquie',
            'description' => 'Printemps de Prague - Invasion soviétique',
            'hint' => 'Résistance pacifique contre les chars'
        ],
        [
            'url' => 'assets/images/historical/1969_moonlanding_crowds.jpg',
            'year' => 1969,
            'location' => 'Lune',
            'description' => 'Apollo 11 - Buzz Aldrin sur la Lune',
            'hint' => 'Premier homme sur la Lune'
        ],
        [
            'url' => 'assets/images/historical/1986_chernobyl.jpg',
            'year' => 1986,
            'location' => 'Tchernobyl, Ukraine',
            'description' => 'Catastrophe nucléaire de Tchernobyl',
            'hint' => 'Pire accident nucléaire de l\'histoire'
        ],
        [
            'url' => 'assets/images/historical/1989_berlin_wall.jpg',
            'year' => 1989,
            'location' => 'Berlin, Allemagne',
            'description' => 'Chute du mur de Berlin - Foules euphoriques',
            'hint' => 'Fin de la Guerre froide'
        ],
        [
            'url' => 'assets/images/historical/2001_september_11.jpg',
            'year' => 2001,
            'location' => 'New York, USA',
            'description' => 'World Trade Center avant le 11 septembre',
            'hint' => 'Année des attentats terroristes'
        ],
        [
            'url' => 'assets/images/historical/2011_arab_spring.jpg',
            'year' => 2011,
            'location' => 'Le Caire, Égypte',
            'description' => 'Printemps arabe - Manifestations place Tahrir',
            'hint' => 'Révolutions au Moyen-Orient'
        ]
    ];

    // Insérer les 10 images
    $stmt = $db->prepare('INSERT INTO images (url, year, location, description, hint) VALUES (:url, :year, :location, :description, :hint)');

    $count = 0;
    foreach ($images as $image) {
        $stmt->bindValue(':url', $image['url'], SQLITE3_TEXT);
        $stmt->bindValue(':year', $image['year'], SQLITE3_INTEGER);
        $stmt->bindValue(':location', $image['location'], SQLITE3_TEXT);
        $stmt->bindValue(':description', $image['description'], SQLITE3_TEXT);
        $stmt->bindValue(':hint', $image['hint'], SQLITE3_TEXT);
        $stmt->execute();
        $count++;
    }

    $success = true;
    $message = "Base de données réduite à 10 images iconiques !";

} catch (Exception $e) {
    $success = false;
    $message = "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>10 Images Iconiques</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #fff;
            padding: 40px;
            text-align: center;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .container {
            max-width: 900px;
            background: #1e293b;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        h1 {
            font-size: 3em;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .icon {
            font-size: 5em;
            margin-bottom: 20px;
        }
        .message {
            font-size: 1.5em;
            margin: 30px 0;
            line-height: 1.6;
        }
        .images-list {
            background: #0f172a;
            padding: 30px;
            border-radius: 15px;
            margin: 30px 0;
            text-align: left;
        }
        .images-list h3 {
            color: #3b82f6;
            margin-bottom: 20px;
            text-align: center;
        }
        .image-item {
            padding: 15px;
            border-bottom: 1px solid #334155;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .image-item:last-child {
            border-bottom: none;
        }
        .year {
            color: #10b981;
            font-weight: 800;
            font-size: 1.3em;
        }
        .description {
            color: #f1f5f9;
            flex: 1;
            margin: 0 20px;
        }
        .btn {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 1.3em;
            margin: 10px;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
        }
        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($success): ?>
            <div class="icon">✅</div>
            <h1>10 Images Iconiques</h1>
            <p class="message"><?php echo $message; ?></p>

            <div class="images-list">
                <h3>📸 Les 10 événements sélectionnés :</h3>
                <?php foreach ($images as $img): ?>
                    <div class="image-item">
                        <span class="year"><?php echo $img['year']; ?></span>
                        <span class="description"><?php echo $img['description']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div style="background: #0f172a; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <p style="color: #94a3b8;">
                    ℹ️ Le jeu est maintenant plus court et plus concentré sur les moments les plus marquants de l'histoire.
                </p>
            </div>

            <div style="margin-top: 40px;">
                <a href="reset_game.php" class="btn">🔄 Réinitialiser le jeu</a>
                <a href="game.php" class="btn btn-success">🎮 Jouer maintenant</a>
            </div>

        <?php else: ?>
            <div class="icon">❌</div>
            <h1>Erreur</h1>
            <p class="message"><?php echo $message; ?></p>
            <a href="reduce_to_10_images.php" class="btn">🔄 Réessayer</a>
        <?php endif; ?>
    </div>
</body>
</html>
