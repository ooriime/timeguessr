<?php
/**
 * Configuration SQLite pour TimeGuessr
 * Crée la base de données et importe les données de data.json
 */

// Créer la base de données SQLite
try {
    $db = new SQLite3('timeguessr.db');

    // Créer la table images
    $db->exec('DROP TABLE IF EXISTS images');
    $db->exec('
        CREATE TABLE images (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            url TEXT NOT NULL,
            year INTEGER NOT NULL,
            location TEXT NOT NULL,
            description TEXT NOT NULL,
            hint TEXT NOT NULL
        )
    ');

    // Charger les données depuis data.json
    $json_data = file_get_contents('data.json');
    $images = json_decode($json_data, true);

    // Préparer la requête d'insertion
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

    $db->close();

    $success = true;
    $message = "Base de données créée avec succès ! $count images importées.";

} catch (Exception $e) {
    $success = false;
    $message = "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Configuration SQLite</title>
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
            max-width: 800px;
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
        .success {
            color: #10b981;
            font-size: 4em;
            margin-bottom: 20px;
        }
        .error {
            color: #ef4444;
            font-size: 4em;
            margin-bottom: 20px;
        }
        .message {
            font-size: 1.5em;
            margin: 30px 0;
            line-height: 1.6;
        }
        .info-box {
            background: #0f172a;
            padding: 30px;
            border-radius: 15px;
            margin: 30px 0;
            text-align: left;
        }
        .info-box h3 {
            color: #3b82f6;
            margin-bottom: 15px;
        }
        .info-box ul {
            list-style: none;
            padding: 0;
        }
        .info-box li {
            padding: 10px 0;
            border-bottom: 1px solid #334155;
        }
        .info-box li:last-child {
            border-bottom: none;
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
        .code {
            background: #0f172a;
            padding: 3px 8px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            color: #10b981;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($success): ?>
            <div class="success">✅</div>
            <h1>SQLite Activé !</h1>
            <p class="message"><?php echo $message; ?></p>

            <div class="info-box">
                <h3>📊 Configuration actuelle :</h3>
                <ul>
                    <li>✅ Base de données : <span class="code">timeguessr.db</span></li>
                    <li>✅ Table : <span class="code">images</span></li>
                    <li>✅ Images importées : <span class="code"><?php echo $count; ?></span></li>
                    <li>✅ Le site utilise maintenant SQLite au lieu de JSON</li>
                </ul>
            </div>

            <div class="info-box">
                <h3>🎯 Prochaines étapes :</h3>
                <ul>
                    <li>1️⃣ Réinitialiser le jeu</li>
                    <li>2️⃣ Commencer à jouer</li>
                    <li>3️⃣ Les données sont maintenant en base de données</li>
                </ul>
            </div>

            <div style="margin-top: 40px;">
                <a href="reset_game.php" class="btn">🔄 Réinitialiser le jeu</a>
                <a href="game.php" class="btn btn-success">🎮 Jouer maintenant</a>
            </div>

        <?php else: ?>
            <div class="error">❌</div>
            <h1>Erreur</h1>
            <p class="message"><?php echo $message; ?></p>
            <a href="setup_sqlite.php" class="btn">🔄 Réessayer</a>
        <?php endif; ?>
    </div>
</body>
</html>
