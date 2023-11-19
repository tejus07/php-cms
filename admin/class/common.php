<?php
class Common {
    
	private $tableName = null;
	private $conn;
	
	public function __construct($db, $tableName) {
        $this->conn = $db;
        $this->tableName = $tableName;
    }	

     public function getListOfEntries() {
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->conn->query($query);
        return $stmt;

     }
}
?>
