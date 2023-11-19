<?php
class Brand {
       
	private $vehiclesTable = 'vehicles';
	private $categoryTable = 'categories';
	private $brandTable = 'brands';
	private $userTable = 'users';
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	

     public function getListOfBrand() {
        $query = "SELECT * FROM " . $this->brandTable;
        $stmt = $this->conn->query($query);

        return $stmt;

     }
}
?>
