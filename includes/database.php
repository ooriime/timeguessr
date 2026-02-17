<?php

class ImageDatabase {
    private $useDatabase = false;
    private $db = null;

    public function __construct($useDatabase = false) {
        $this->useDatabase = $useDatabase;

        if ($this->useDatabase) {
            if (file_exists('timeguessr.db')) {
                $this->db = new SQLite3('timeguessr.db');
            } else {
                throw new Exception("Base de donnees non trouvee.");
            }
        }
    }

    public function getAllImages() {
        if ($this->useDatabase) {
            return $this->getImagesFromDatabase();
        } else {
            return $this->getImagesFromJSON();
        }
    }

    private function getImagesFromJSON() {
        $json_data = file_get_contents('data.json');
        return json_decode($json_data, true);
    }

    private function getImagesFromDatabase() {
        $results = $this->db->query('SELECT * FROM images ORDER BY RANDOM()');
        $images = [];

        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $images[] = $row;
        }

        return $images;
    }

    public function addImage($url, $year, $location, $description, $hint) {
        if (!$this->useDatabase) {
            throw new Exception("Fonction disponible uniquement avec SQLite");
        }

        $stmt = $this->db->prepare('INSERT INTO images (url, year, location, description, hint) VALUES (:url, :year, :location, :description, :hint)');
        $stmt->bindValue(':url', $url, SQLITE3_TEXT);
        $stmt->bindValue(':year', $year, SQLITE3_INTEGER);
        $stmt->bindValue(':location', $location, SQLITE3_TEXT);
        $stmt->bindValue(':description', $description, SQLITE3_TEXT);
        $stmt->bindValue(':hint', $hint, SQLITE3_TEXT);

        return $stmt->execute();
    }

    public function close() {
        if ($this->db) {
            $this->db->close();
        }
    }
}

function getImages() {
    $db = new ImageDatabase(false);
    $images = $db->getAllImages();
    $db->close();
    return $images;
}
?>
