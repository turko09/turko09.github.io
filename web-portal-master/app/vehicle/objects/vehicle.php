<?php
class Vehicle{
 
    // database connection and table name
    private $conn;
    private $table_name = "vehicle";
 
    // object properties
    public $id;
	public $driverid;
    public $plateno;
    public $type;
    public $make;
    public $model;
    public $color;
	public $photo;
	public $active;
	public $available;
	public $locationlat;
	public $locationlong;
    public $datecreated;
    public $datemodified;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    // create product
    function create(){
 
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET	
                    driverid=:driverid, plateno=:plateno, type=:type, make=:make, model=:model,
					color=:color, photo=:photo, active=:active, available=:available, 
					locationlat=:locationlat, locationlong=:locationlong,
                    datecreated=:datecreated, datemodified=:datemodified";
 
        $stmt = $this->conn->prepare($query);
 
        // posted values
        $this->driverid=htmlspecialchars(strip_tags($this->driverid));
        $this->plateno=htmlspecialchars(strip_tags($this->plateno));
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->make=htmlspecialchars(strip_tags($this->make));
		$this->model=htmlspecialchars(strip_tags($this->model));
		$this->color=htmlspecialchars(strip_tags($this->color));
		$this->photo=htmlspecialchars(strip_tags($this->photo));
		$this->active=htmlspecialchars(strip_tags($this->active));
		$this->available=htmlspecialchars(strip_tags($this->available));
		$this->locationlat=htmlspecialchars(strip_tags($this->locationlat));
		$this->locationlong=htmlspecialchars(strip_tags($this->locationlong));
        $this->datecreated=htmlspecialchars(strip_tags($this->datecreated));
        $this->datemodified=htmlspecialchars(strip_tags($this->datemodified));
 
        // to get time-stamp for 'created' field
        //$this->timestamp = date('Y-m-d H:i:s');
 
        // bind values 
        $stmt->bindParam(":driverid", $this->driverid);
        $stmt->bindParam(":plateno", $this->plateno);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":make", $this->make);
        $stmt->bindParam(":model", $this->model);
		$stmt->bindParam(":color", $this->color);
		$stmt->bindParam(":photo", $this->photo);
		$stmt->bindParam(":active", $this->active);
		$stmt->bindParam(":available", $this->available);
		$stmt->bindParam(":locationlat", $this->locationlat);
		$stmt->bindParam(":locationlong", $this->locationlong);
        $stmt->bindParam(":datecreated", $this->datecreated);
        $stmt->bindParam(":datemodified", $this->datemodified);
		
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
	
    }
	function readAll($from_record_num, $records_per_page){
 
    $query = "SELECT
                *
            FROM
                " . $this->table_name . "
            ORDER BY
                make ASC
            LIMIT
                {$from_record_num}, {$records_per_page}";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;
} 
// used for paging products
public function countAll(){
 
    $query = "SELECT id FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    $num = $stmt->rowCount();
 
    return $num;
}
function readOne(){
 
    $query = "SELECT
                *
            FROM
                " . $this->table_name . "
            WHERE
                id = ?
            LIMIT
                0,1";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    $this->id = $row['id'];
    $this->driverid = $row['driverid'];
    $this->plateno = $row['plateno'];
	$this->type = $row['type'];
    $this->make = $row['make'];
	$this->model = $row['model'];
	$this->color = $row['color'];
	$this->photo = $row['photo'];
	$this->active = $row['active'];
	$this->available = $row['available'];
	$this->locationlat = $row['locationlat'];
	$this->locationlong = $row['locationlong'];
    $this->datecreated = $row['datecreated'];
    $this->datemodified = $row['datemodified'];
}
function update(){
 
    $query = "UPDATE
                " . $this->table_name . "
            SET
                driverid = :driverid,
                plateno = :plateno,
                type = :type,
                make = :make,
                model = :model,
                color = :color,
                active = :active,
                available = :available
                
            WHERE
                id = :id";
 
    $stmt = $this->conn->prepare($query);
 
    // posted values
    $this->driverid=htmlspecialchars(strip_tags($this->driverid));
    $this->plateno=htmlspecialchars(strip_tags($this->plateno));
    $this->type=htmlspecialchars(strip_tags($this->type));
    $this->make=htmlspecialchars(strip_tags($this->make));
    $this->model=htmlspecialchars(strip_tags($this->model));
    $this->color=htmlspecialchars(strip_tags($this->color));
    $this->active=htmlspecialchars(strip_tags($this->active));
    $this->available=htmlspecialchars(strip_tags($this->available));
    
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind parameters
    $stmt->bindParam(':driverid', $this->driverid);
    $stmt->bindParam(':plateno', $this->plateno);
    $stmt->bindParam(':type', $this->type);
    $stmt->bindParam(':make', $this->make);
    $stmt->bindParam(':model', $this->model);
    $stmt->bindParam(':color', $this->color);
    $stmt->bindParam(':active', $this->active);
    $stmt->bindParam(':available', $this->available);
    
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
// delete the product
function delete(){
 //echo $id;
 //exit;
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
     
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
 
    if($result = $stmt->execute()){
        return true;
    }else{
        return false;
    }
}
}

?>
