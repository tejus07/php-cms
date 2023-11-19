<?php
class Vehicle {
       
	private $vehiclesTable = 'vehicles';
	private $categoryTable = 'categories';
	private $brandTable = 'brands';
	private $userTable = 'users';
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	

     public function getListOfVehicles() {
        $query = "SELECT 
            V.vehicle_id,
            U.username,
            C.category_name,
            B.brand_name,
            V.model,
            V.license_plate,
            V.description,
            V.rental_rate,
            V.availability_status,
            V.image_url,
            V.created_at
        FROM 
            " . $this->vehiclesTable . " V
        JOIN 
            " . $this->userTable . " U ON V.owner_id = U.user_id
        JOIN 
            " . $this->categoryTable . " C ON V.category_id = C.category_id
        JOIN 
            " . $this->brandTable . " B ON V.brand_id = B.brand_id;
        ";
        $stmt = $this->conn->query($query);

        return $stmt;

     }

     public function getVehiclesCount() {
        $query = "SELECT COUNT(*) AS total_entries FROM " . $this->vehiclesTable;
        $stmt = $this->conn->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $$result['total_entries'];

     }
}
?>
