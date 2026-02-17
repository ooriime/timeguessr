<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'timeguessr';

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        global $db_host, $db_user, $db_pass, $db_name;
        $this->conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($this->conn->connect_error) {
            die('Erreur connexion base de donnees : ' . $this->conn->connect_error);
        }
        $this->conn->set_charset('utf8');
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getAllImages() {
        $result = $this->conn->query("SELECT * FROM images ORDER BY id ASC");
        $images = array();
        while ($row = $result->fetch_assoc()) {
            $images[] = $row;
        }
        return $images;
    }
}
?>
