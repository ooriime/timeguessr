<?php

class Database {
    private static $instance = null;
    private $db;

    private function __construct() {
        $db_path = __DIR__ . '/../timeguessr.db';

        if (!file_exists($db_path)) {
            die("Erreur : Base de donnees non trouvee.");
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

    public function getAllImages() {
        $query = "SELECT * FROM images ORDER BY id ASC";
        $results = $this->db->query($query);

        $images = [];
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $images[] = $row;
        }

        return $images;
    }

    public function getImageById($id) {
        $stmt = $this->db->prepare("SELECT * FROM images WHERE id = :id");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $result = $stmt->execute();

        return $result->fetchArray(SQLITE3_ASSOC);
    }

    public function getRandomImage() {
        $query = "SELECT * FROM images ORDER BY RANDOM() LIMIT 1";
        $result = $this->db->query($query);

        return $result->fetchArray(SQLITE3_ASSOC);
    }

    public function countImages() {
        $query = "SELECT COUNT(*) as count FROM images";
        $result = $this->db->query($query);
        $row = $result->fetchArray(SQLITE3_ASSOC);

        return $row['count'];
    }

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

    public function __destruct() {
        if ($this->db) {
            $this->db->close();
        }
    }
}
?>
