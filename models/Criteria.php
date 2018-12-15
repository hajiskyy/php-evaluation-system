<?php
class Criteria {

    //database req
    private $conn;
    private $table = 'criteria';
    
    //tasks properties
    public $id;
    public $name;
    public $staffId;
    public $total;
    public $course;
    
    //constuctor
    public function __construct($db){
        $this->conn = $db;
    }

    //get a staff id
    public function getByStaffId(){
        $query = "SELECT * from $this->table WHERE staff_id = ?";
        $stmt = $this->conn->prepare($query);
  
        // Bind Id
        $stmt->bindParam(1, $this->staffId);
        $stmt->execute();

        $result = $stmt;

        if($num > 0){
          $criteria = $result->fetch  (PDO::FETCH_OBJ);
        }
      
      return $critera ? $critera : NULL;
    }

    //get by course
    public function getByCourse(){
        $query = "SELECT * from $this->table WHERE course = ?";
        $stmt = $this->conn->prepare($query);
  
        // Bind Id
        $stmt->bindParam(1, $this->course);
        $stmt->execute();

        $result = $stmt;

        //get row count
        $num = $result->rowCount();

        // create array
        $criterias = array();

        // if num > 0
        if($num > 0){
          while($row = $result->fetch(PDO::FETCH_OBJ)){
            array_push($criterias, $row);
          }
        }
      
      return $criterias ? $criterias : NULL;
    }

    //set staff to criteria
    public function setStaff(){
        $query = "UPDATE $this->table SET staff_id = :staff  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        //  sanitize data
        $this->staffId = htmlspecialchars(strip_tags($this->staffId));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind parameter
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':staff', $this->staffId);

        if($stmt->execute()){
            return TRUE;
        } else {
            printf("Error %s \n", $stmt->error);
            return FALSE;
        } 
    }

}
?>