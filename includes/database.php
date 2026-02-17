<?php
/**
 * Classe pour gérer les images depuis JSON ou SQLite
 */

class ImageDatabase {
    private $useDatabase = false; // Mettre à true pour utiliser SQLite
    private $db = null;

    public function __construct($useDatabase = false) {
        $this->useDatabase = $useDatabase;

        if ($this->useDatabase) {
            // Utiliser SQLite
            if (file_exists('timeguessr.db')) {
                $this->db = new SQLite3('timeguessr.db');
            } else {
                throw new Exception("Base de données non trouvée. Exécutez setup_database.php d'abord.");
            }
        }
    }

    /**
     * Récupérer toutes les images
     */
    public function getAllImages() {
        if ($this->useDatabase) {
            return $this->getImagesFromDatabase();
        } else {
            return $this->getImagesFromJSON();
        }
    }

    /**
     * Récupérer les images depuis le fichier JSON
     */
    private function getImagesFromJSON() {
        $json_data = file_get_contents('data.json');
        return json_decode($json_data, true);
    }

    /**
     * Récupérer les images depuis la base de données SQLite
     */
    private function getImagesFromDatabase() {
        $results = $this->db->query('SELECT * FROM images ORDER BY RANDOM()');
        $images = [];

        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $images[] = $row;
        }

        return $images;
    }

    /**
     * Ajouter une nouvelle image (uniquement pour SQLite)
     */
    public function addImage($url, $year, $location, $description, $hint) {
        if (!$this->useDatabase) {
            throw new Exception("Cette fonction n'est disponible qu'avec SQLite");
        }

        $stmt = $this->db->prepare('INSERT INTO images (url, year, location, description, hint) VALUES (:url, :year, :location, :description, :hint)');
        $stmt->bindValue(':url', $url, SQLITE3_TEXT);
        $stmt->bindValue(':year', $year, SQLITE3_INTEGER);
        $stmt->bindValue(':location', $location, SQLITE3_TEXT);
        $stmt->bindValue(':description', $description, SQLITE3_TEXT);
        $stmt->bindValue(':hint', $hint, SQLITE3_TEXT);

        return $stmt->execute();
    }

    /**
     * Fermer la connexion
     */
    public function close() {
        if ($this->db) {
            $this->db->close();
        }
    }
}

// Fonction helper pour récupérer les images
function getImages() {
    // Changer le paramètre à true pour utiliser SQLite au lieu de JSON
    $db = new ImageDatabase(false); // false = JSON, true = SQLite
    $images = $db->getAllImages();
    $db->close();
    return $images;
}
?>
