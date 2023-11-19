<?php
class User {
       
	private $vehiclesTable = 'vehicles';
	private $categoryTable = 'categories';
	private $brandTable = 'brands';
	private $userTable = 'users';
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	

     public function getListOfUsers() {
        $query = "SELECT * FROM " . $this->userTable;
        $stmt = $this->conn->query($query);

        return $stmt;

     }
}
?>
