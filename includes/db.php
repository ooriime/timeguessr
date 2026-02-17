<?php
class Database {
    private static $instance=null;
    private $db;
    private function __construct() {
        $path=__DIR__.'/../timeguessr.db';
        if (!file_exists($path)) die("Erreur : base de donnees non trouvee.");
        $this->db=new SQLite3($path);
    }
    public static function getInstance() {
        if (self::$instance===null) self::$instance=new Database();
        return self::$instance;
    }
    public function getAllImages() {
        $r=$this->db->query("SELECT * FROM images ORDER BY id ASC");
        $images=[];
        while ($row=$r->fetchArray(SQLITE3_ASSOC)) $images[]=$row;
        return $images;
    }
    public function __destruct() { if ($this->db) $this->db->close(); }
}
?>
