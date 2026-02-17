<?php
/**
 * Gestion de la base de données SQLite
 */

class Database {
    private static $instance = null;
    private $db;

    private function __construct() {
        $db_path = __DIR__ . '/../timeguessr.db';

        if (!file_exists($db_path)) {
            die("Erreur : Base de données non trouvée. Exécutez setup_sqlite.php d'abord.");
        }

        $this->db = new SQLite3($db_path);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->db;
    }

    /**
     * Récupérer toutes les images
     */
    public function getAllImages() {
        $query = "SELECT * FROM images ORDER BY id ASC";
        $results = $this->db->query($query);

        $images = [];
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $images[] = $row;
        }

        return $images;
    }

    /**
     * Récupérer une image par ID
     */
    public function getImageById($id) {
        $stmt = $this->db->prepare("SELECT * FROM images WHERE id = :id");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $result = $stmt->execute();

        return $result->fetchArray(SQLITE3_ASSOC);
    }

    /**
     * Récupérer une image aléatoire
     */
    public function getRandomImage() {
        $query = "SELECT * FROM images ORDER BY RANDOM() LIMIT 1";
        $result = $this->db->query($query);

        return $result->fetchArray(SQLITE3_ASSOC);
    }

    /**
     * Compter le nombre total d'images
     */
    public function countImages() {
        $query = "SELECT COUNT(*) as count FROM images";
        $result = $this->db->query($query);
        $row = $result->fetchArray(SQLITE3_ASSOC);

        return $row['count'];
    }

    /**
     * Ajouter une nouvelle image
     */
    public function addImage($url, $year, $location, $description, $hint) {
        $stmt = $this->db->prepare("
            INSERT INTO images (url, year, location, description, hint)
            VALUES (:url, :year, :location, :description, :hint)
        ");

        $stmt->bindValue(':url', $url, SQLITE3_TEXT);
        $stmt->bindValue(':year', $year, SQLITE3_INTEGER);
        $stmt->bindValue(':location', $location, SQLITE3_TEXT);
        $stmt->bindValue(':description', $description, SQLITE3_TEXT);
        $stmt->bindValue(':hint', $hint, SQLITE3_TEXT);

        return $stmt->execute();
    }

    /**
     * Mettre à jour une image
     */
    public function updateImage($id, $url, $year, $location, $description, $hint) {
        $stmt = $this->db->prepare("
            UPDATE images
            SET url = :url, year = :year, location = :location,
                description = :description, hint = :hint
            WHERE id = :id
        ");

        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $stmt->bindValue(':url', $url, SQLITE3_TEXT);
        $stmt->bindValue(':year', $year, SQLITE3_INTEGER);
        $stmt->bindValue(':location', $location, SQLITE3_TEXT);
        $stmt->bindValue(':description', $description, SQLITE3_TEXT);
        $stmt->bindValue(':hint', $hint, SQLITE3_TEXT);

        return $stmt->execute();
    }

    /**
     * Supprimer une image
     */
    public function deleteImage($id) {
        $stmt = $this->db->prepare("DELETE FROM images WHERE id = :id");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

        return $stmt->execute();
    }

    public function __destruct() {
        if ($this->db) {
            $this->db->close();
        }
    }
}
?>
