<?php
/**
 * Script de création de la base de données SQLite
 * Exécutez ce fichier une seule fois pour créer la base de données
 */

// Créer la base de données SQLite
$db = new SQLite3('timeguessr.db');

// Créer la table des images
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

// Insérer les images
$images = [
    ['https://images.unsplash.com/photo-1464047736614-af63643285bf?w=1200&h=800&fit=crop', 1920, 'Paris, France', 'Tour Eiffel et architecture parisienne des années 1920', 'Architecture européenne classique'],
    ['https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=1200&h=800&fit=crop', 1950, 'États-Unis', 'Voiture américaine classique des années 50', 'L\'âge d\'or de l\'automobile américaine'],
    ['https://images.unsplash.com/photo-1494438639946-1ebd1d20bf85?w=1200&h=800&fit=crop', 1969, 'États-Unis', 'Festival de musique emblématique', 'Contre-culture et musique rock'],
    ['https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=1200&h=800&fit=crop', 1985, 'Silicon Valley, USA', 'Ordinateurs personnels des années 80', 'Révolution informatique'],
    ['https://images.unsplash.com/photo-1551817958-d9d86fb29431?w=1200&h=800&fit=crop', 1945, 'New York, USA', 'Célébration de la fin de la guerre', 'Fin de la Seconde Guerre mondiale'],
    ['https://images.unsplash.com/photo-1468436139062-f60a71c5c892?w=1200&h=800&fit=crop', 1960, 'États-Unis', 'Diner américain typique des années 60', 'Culture américaine vintage'],
    ['https://images.unsplash.com/photo-1476900966873-ab20d6251dd1?w=1200&h=800&fit=crop', 1977, 'New York, USA', 'Ère disco et boule à facettes', 'Saturday Night Fever'],
    ['https://images.unsplash.com/photo-1511512578047-dfb367046420?w=1200&h=800&fit=crop', 1989, 'Berlin, Allemagne', 'Mur de Berlin et division', 'Fin de la Guerre froide'],
    ['https://images.unsplash.com/photo-1550009158-9ebf69173e03?w=1200&h=800&fit=crop', 1995, 'Silicon Valley, USA', 'Début d\'Internet et du web', 'Révolution numérique'],
    ['https://images.unsplash.com/photo-1556656793-08538906a9f8?w=1200&h=800&fit=crop', 2007, 'Cupertino, USA', 'Premier iPhone et révolution mobile', 'Début des smartphones modernes'],
    ['https://images.unsplash.com/photo-1542282088-fe8426682b8f?w=1200&h=800&fit=crop', 1936, 'États-Unis', 'Grande Dépression américaine', 'Crise économique mondiale'],
    ['https://images.unsplash.com/photo-1516214104703-d870798883c5?w=1200&h=800&fit=crop', 1903, 'Kitty Hawk, USA', 'Débuts de l\'aviation', 'Premier vol motorisé'],
    ['https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&h=800&fit=crop', 2015, 'Monde entier', 'Ère des réseaux sociaux et connectivité', 'Monde hyperconnecté'],
    ['https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=1200&h=800&fit=crop', 1984, 'États-Unis', 'Révolution des ordinateurs personnels', 'Apple et Microsoft émergent'],
    ['https://images.unsplash.com/photo-1534670007418-fbb7f6cf32c3?w=1200&h=800&fit=crop', 1928, 'Europe', 'Architecture art déco', 'Entre-deux-guerres'],
    ['https://images.unsplash.com/photo-1485872299829-c673f5194813?w=1200&h=800&fit=crop', 1965, 'États-Unis', 'Mouvement des droits civiques', 'Lutte pour l\'égalité'],
    ['https://images.unsplash.com/photo-1518770660439-4636190af475?w=1200&h=800&fit=crop', 2010, 'Monde entier', 'Ère des startups tech et innovation', 'Silicon Valley boom'],
    ['https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=1200&h=800&fit=crop', 1975, 'Californie, USA', 'Culture surf et plage', 'Lifestyle californien'],
    ['https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=1200&h=800&fit=crop', 2000, 'Monde entier', 'Passage au nouveau millénaire', 'Bug de l\'an 2000'],
    ['https://images.unsplash.com/photo-1512941675424-1c17dabfdddc?w=1200&h=800&fit=crop', 1955, 'États-Unis', 'Diner et culture des années 50', 'Rock\'n\'roll et jukebox']
];

$stmt = $db->prepare('INSERT INTO images (url, year, location, description, hint) VALUES (:url, :year, :location, :description, :hint)');

foreach ($images as $image) {
    $stmt->bindValue(':url', $image[0], SQLITE3_TEXT);
    $stmt->bindValue(':year', $image[1], SQLITE3_INTEGER);
    $stmt->bindValue(':location', $image[2], SQLITE3_TEXT);
    $stmt->bindValue(':description', $image[3], SQLITE3_TEXT);
    $stmt->bindValue(':hint', $image[4], SQLITE3_TEXT);
    $stmt->execute();
}

$db->close();

echo "✅ Base de données créée avec succès !<br>";
echo "📊 " . count($images) . " images ont été ajoutées.<br>";
echo "<br>";
echo "➡️ <a href='game.php'>Commencer à jouer</a>";
?>
