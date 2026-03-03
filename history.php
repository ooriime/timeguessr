<?php
// Page des statistiques par image

require_once 'includes/functions.php';
demarrer_session();

$db = get_db();
$req = $db->query(
    'SELECT i.title, i.year, i.location, sh.play_count, sh.avg_year_error, sh.avg_geo_error, sh.avg_score
     FROM score_history sh
     JOIN images i ON i.id = sh.image_id
     ORDER BY sh.avg_score ASC'
);
$stats = $req->fetchAll();

include 'includes/header.php';
?>

<div class="contenu">
    <h1>Statistiques des images</h1>
    <p>Classement des images par score moyen (plus difficile en premier).</p>

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Annee reelle</th>
                <th>Lieu</th>
                <th>Parties jouees</th>
                <th>Ecart annee moyen</th>
                <th>Ecart geo moyen (km)</th>
                <th>Score moyen</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($stats) == 0): ?>
                <tr>
                    <td colspan="7">Aucune donnee pour l'instant.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($stats as $ligne): ?>
                <tr>
                    <td><?php echo h($ligne['title']); ?></td>
                    <td><?php echo h($ligne['year']); ?></td>
                    <td><?php echo h($ligne['location']); ?></td>
                    <td><?php echo $ligne['play_count']; ?></td>
                    <td><?php echo $ligne['play_count'] > 0 ? round($ligne['avg_year_error'], 1) . ' ans' : '-'; ?></td>
                    <td><?php echo $ligne['play_count'] > 0 ? round($ligne['avg_geo_error']) . ' km' : '-'; ?></td>
                    <td><?php echo $ligne['play_count'] > 0 ? round($ligne['avg_score']) : '-'; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="/index.php" class="btn btn-orange">Nouvelle partie</a>
</div>

<?php include 'includes/footer.php'; ?>
