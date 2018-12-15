<?php
// Database Connection Class
 class Database {

  // Set connection variables
  private $host = "localhost";
  private $db_name = "haji";
  private $username = "root";
  private $password = "";
  private $conn;

  // connection function
  public function connect(){
      $this->conn = null;
      try {
        //create connection
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name",$this->username,$this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      } catch(PDOException $err) {
          echo "Connection error:".$err->getMessage();
      }

      return $this->conn;
  }

 }

?>