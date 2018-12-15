<?php
class Attendance {
    //database req
    private $conn;
    private $table = 'attendance';

    //tasks properties
    public $id;
    public $studentId;
    public $staffId;
    public $course;

    //constructor
    public function __construct($db){
        $this->conn = $db;
    }

    public function put($checks){

        //query
        $query = "INSERT INTO $this->table (student_id, staff_id, course) VALUES";

        foreach ($checks as $check) {
          $query .= "('$check','$this->staffId', '$this->course'),";
        }

        $query = substr($query, 0, -1);


        $stmt = $this->conn->prepare($query);

        //  sanitize data
        // $this->id = htmlspecialchars(strip_tags($this->id));
        // $this->studentId = htmlspecialchars(strip_tags($this->studentId));
        // $this->staffId = htmlspecialchars(strip_tags($this->staffId));
        // $this->course = htmlspecialchars(strip_tags($this->course));

        // bind parameter
        // $stmt->bindParam(':id', $this->id);
        // $stmt->bindParam(':student_id', $this->studentId);
        // $stmt->bindParam(':staff_id', $this->staffId);
        // $stmt->bindParam(':course', $this->course);


        // return true if query is successful
        if($stmt->execute()){
            return TRUE;
        } else {
            printf("Error %s \n", $stmt->error);
            return FALSE;
        }  

    }

    // delete attendance
    public function delete(){
        //query
        $query = "DELETE FROM $this->table WHERE student_id = :student_id ORDER BY updated_at DESC LIMIT 1";
    
        $stmt = $this->conn->prepare($query);

        // sanitize data
        $this->studentId = htmlspecialchars(strip_tags($this->studentId));

        // bind parameter
        $stmt->bindParam(':student_id',$this->studentId);
    
        // return true if query is successful
        if($stmt->execute()){
            return TRUE;
        } else {
            return FALSE;
        }
                    
    }

    public function getAll(){
        //query
        $query = "SELECT * FROM $this->table WHERE course = :course";
        $stmt = $this->conn->prepare($query);
        // sanitize data
        $this->course = htmlspecialchars(strip_tags($this->course));

        // bind parameter
        $stmt->bindParam(':course',$this->course);
        $stmt->execute();
        $result = $stmt;

        //get row count
        $num = $result->rowCount();

        //create student array
        $attendance = array();
    
      if($num > 0){
        while($row = $result->fetch(PDO::FETCH_OBJ)){
          array_push($attendance, $row);
        }
      }
    
      return $attendance ? $attendance : NULL;
    }

    public function single(){
        $query = "SELECT * from $this->table WHERE student_id = :id";
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->studentId = htmlspecialchars(strip_tags($this->studentId));

        //bind parameters
        $stmt->bindParam(':id', $this->studentId);

        $stmt->execute();
        return $stmt;
    }

}


?>