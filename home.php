<?php
session_start();

// Charger les statistiques
$stats_file = 'stats.json';
$global_stats = [
    'total_games' => 0,
    'total_rounds' => 0,
    'best_score' => 0,
    'average_difference' => 0
];

if (file_exists($stats_file)) {
    $stats_data = json_decode(file_get_contents($stats_file), true);
    if ($stats_data) {
        $global_stats = $stats_data;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeGuessr - Devinez l'année !</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .hero {
            min-height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px 20px;
        }

        .hero-logo {
            font-size: 5em;
            font-weight: 800;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            animation: glow 3s ease-in-out infinite;
        }

        @keyframes glow {
            0%, 100% { filter: drop-shadow(0 0 20px rgba(59, 130, 246, 0.5)); }
            50% { filter: drop-shadow(0 0 40px rgba(139, 92, 246, 0.8)); }
        }

        .hero-subtitle {
            font-size: 1.8em;
            color: var(--text-secondary);
            margin-bottom: 40px;
            max-width: 600px;
        }

        .hero-description {
            font-size: 1.2em;
            color: var(--text-secondary);
            margin-bottom: 50px;
            max-width: 700px;
            line-height: 1.6;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            margin-bottom: 60px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-large {
            font-size: 1.5em;
            padding: 20px 50px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 60px auto;
            padding: 0 20px;
        }

        .feature-card {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 16px;
            text-align: center;
            border: 2px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
        }

        .feature-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }

        .feature-title {
            font-size: 1.3em;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text-primary);
        }

        .feature-description {
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .stats-section {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 40px;
            max-width: 800px;
            margin: 40px auto;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .stat-item {
            background: var(--dark-bg);
            padding: 20px;
            border-radius: 12px;
            border: 2px solid var(--border-color);
        }

        .stat-value {
            font-size: 2.5em;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="hero-logo">⏰ TimeGuessr</div>
        <div class="hero-subtitle">
            Testez vos connaissances en histoire !
        </div>
        <div class="hero-description">
            Découvrez des photos iconiques d'événements historiques majeurs du 20ème siècle.
            Votre mission ? Deviner l'année avec le plus de précision possible !
        </div>

        <div class="cta-buttons">
            <a href="game.php" class="btn btn-primary btn-large">
                🎮 Commencer à jouer
            </a>
        </div>

        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <div class="feature-title">Scoring Avancé</div>
                <div class="feature-description">
                    Jusqu'à 5000 points par round ! Plus vous êtes précis, plus vous gagnez.
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🖼️</div>
                <div class="feature-title">20 Images Historiques</div>
                <div class="feature-description">
                    Des moments emblématiques du 20ème siècle. Devinez l'année pour découvrir les images !
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <div class="feature-title">Suivi des Stats</div>
                <div class="feature-description">
                    Suivez votre progression, votre score total et votre moyenne.
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">💡</div>
                <div class="feature-title">Indices Utiles</div>
                <div class="feature-description">
                    Chaque image vient avec un indice pour vous aider à situer l'époque.
                </div>
            </div>
        </div>

        <?php if ($global_stats['total_rounds'] > 0): ?>
        <div class="stats-section">
            <h2 style="font-size: 2em; margin-bottom: 10px;">📈 Statistiques Globales</h2>
            <p style="color: var(--text-secondary);">Performances de tous les joueurs</p>

            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-value"><?php echo number_format($global_stats['total_games']); ?></div>
                    <div class="stat-label">Parties Jouées</div>
                </div>

                <div class="stat-item">
                    <div class="stat-value"><?php echo number_format($global_stats['total_rounds']); ?></div>
                    <div class="stat-label">Rounds Totaux</div>
                </div>

                <div class="stat-item">
                    <div class="stat-value"><?php echo number_format($global_stats['best_score']); ?></div>
                    <div class="stat-label">Meilleur Score</div>
                </div>

                <div class="stat-item">
                    <div class="stat-value"><?php echo round($global_stats['average_difference']); ?></div>
                    <div class="stat-label">Différence Moyenne</div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <p><strong>TimeGuessr</strong> - Un jeu pour tester vos connaissances en histoire</p>
        <p>Images provenant de Wikimedia Commons | Version 1.0.0</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
