<?php
class Database{
  
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "id5118856_cmsc_team_alpha";
    private $username = "id5118856_root";
    private $password = "password";
    public $conn;
  
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}
?>
