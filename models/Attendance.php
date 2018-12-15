<?php
class Attendance {
    //database req
    private $conn;
    private $table = 'attendance';

    //tasks properties
    public $id;
    public $studentId;
    public $advisorId;
    public $week;
    public $attended;
    public $total;

    //constructor
    public function __construct($db){
        $this->conn = $db;
    }

    public function put(){
        //query
        $query = "INSERT INTO $this->table
        SET
            id = :id,
            student_id = :student_id, 
            advisor_id = :advisor_id ,
            attended = :attended, 
            week = :week
        ON DUPLICATE KEY UPDATE attended = attended + 1, week = :week
        ";

        $stmt = $this->conn->prepare($query);

        //  sanitize data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->studentId = htmlspecialchars(strip_tags($this->studentId));
        $this->advisorId = htmlspecialchars(strip_tags($this->advisorId));
        $this->attended = htmlspecialchars(strip_tags($this->attended));
        $this->week = htmlspecialchars(strip_tags($this->week));

        // bind parameter
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':student_id', $this->studentId);
        $stmt->bindParam(':advisor_id', $this->advisorId);
        $stmt->bindParam(':attended', $this->attended);
        $stmt->bindParam(':week', $this->week);


        // return true if query is successful
        if($stmt->execute()){
            return true;
        } else {
            printf("Error %s \n", $stmt->error);
            return false;
        }  

    }

    // delete attendance
    public function delete(){
        //query
        $query = "INSERT INTO $this->table
        SET
            id = :id,
            student_id = :student_id, 
            advisor_id = :advisor_id ,
            attended = :attended, 
            week = :week
        ON DUPLICATE KEY UPDATE attended = attended - 1,
        week = week - 1
        ";
    
        $stmt = $this->conn->prepare($query);

        //  sanitize data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->studentId = htmlspecialchars(strip_tags($this->studentId));
        $this->advisorId = htmlspecialchars(strip_tags($this->advisorId));
        $this->attended = htmlspecialchars(strip_tags($this->attended));
        $this->week = htmlspecialchars(strip_tags($this->week));
    
        // bind parameter
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':student_id',$this->studentId);
        $stmt->bindParam(':advisor_id',$this->advisorId);
        $stmt->bindParam(':attended', $this->attended);
        $stmt->bindParam(':week', $this->week);
    
    
        // return true if query is successful
        if($stmt->execute()){
            return true;
        } else {
            printf("Error %s \n", $stmt->error);
        }
                    
    }

    public function getAll(){
        //query
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
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