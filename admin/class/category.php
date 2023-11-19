<?php
class Category {
       
	private $vehiclesTable = 'vehicles';
	private $categoryTable = 'categories';
	private $brandTable = 'brands';
	private $userTable = 'users';
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	

     public function getListOfCategories() {
        $query = "SELECT * FROM " . $this->categoryTable;
        $stmt = $this->conn->query($query);

        return $stmt;

     }
}
?>
