<?php
/**
 * Ajouter la nouvelle image à la base de données
 */

require_once 'includes/db.php';

try {
    $db = Database::getInstance();

    // Informations de la nouvelle image
    $url = 'assets/images/historical/1944_liberation_paris.jpg';
    $year = 1944;
    $location = 'Paris, France';
    $description = 'Libération de Paris - Foules sur les Champs-Élysées';
    $hint = 'Fin de l\'occupation nazie en France';

    // Ajouter l'image
    $result = $db->addImage($url, $year, $location, $description, $hint);

    if ($result) {
        $total = $db->countImages();
        $success = true;
        $message = "Image ajoutée avec succès ! Vous avez maintenant $total images dans la base de données.";
    } else {
        $success = false;
        $message = "Erreur lors de l'ajout de l'image.";
    }

} catch (Exception $e) {
    $success = false;
    $message = "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'image</title>
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
        .success-icon {
            font-size: 5em;
            margin-bottom: 20px;
        }
        .message {
            font-size: 1.5em;
            margin: 30px 0;
            line-height: 1.6;
        }
        .image-preview {
            max-width: 600px;
            margin: 30px auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .image-preview img {
            width: 100%;
            height: auto;
            display: block;
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
        .info-item {
            padding: 10px 0;
            border-bottom: 1px solid #334155;
            display: flex;
            justify-content: space-between;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            color: #94a3b8;
            font-weight: 600;
        }
        .info-value {
            color: #10b981;
            font-weight: 700;
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
            <div class="success-icon">✅</div>
            <h1>Image Ajoutée !</h1>
            <p class="message"><?php echo $message; ?></p>

            <div class="image-preview">
                <img src="<?php echo $url; ?>" alt="Libération de Paris">
            </div>

            <div class="info-box">
                <h3>📋 Détails de l'image :</h3>
                <div class="info-item">
                    <span class="info-label">Année :</span>
                    <span class="info-value"><?php echo $year; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Lieu :</span>
                    <span class="info-value"><?php echo $location; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Description :</span>
                    <span class="info-value"><?php echo $description; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Indice :</span>
                    <span class="info-value"><?php echo $hint; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Total d'images :</span>
                    <span class="info-value"><?php echo $total; ?></span>
                </div>
            </div>

            <div style="margin-top: 40px;">
                <a href="reset_game.php" class="btn">🔄 Réinitialiser le jeu</a>
                <a href="game.php" class="btn btn-success">🎮 Jouer maintenant</a>
            </div>

        <?php else: ?>
            <div class="success-icon">❌</div>
            <h1>Erreur</h1>
            <p class="message"><?php echo $message; ?></p>
            <a href="add_image_to_db.php" class="btn">🔄 Réessayer</a>
        <?php endif; ?>
    </div>
</body>
</html>
