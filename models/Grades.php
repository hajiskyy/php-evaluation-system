<?php
class Grades {
    //database req
    private $conn;
    private $table = 'grades';

    //tasks properties
    public $id;
    public $studentId;
    public $staffId;
    public $course;
    public $score;
    public $criteriaId;
    public $comments;

    //constructor
    public function __construct($db){
        $this->conn = $db;
    }

    public function put(){
        //query
        $query = "INSERT INTO $this->table
                  SET id = :id,
                  score = :score, 
                  criteria_id = :criteria_id, 
                  student_id =:student_id, 
                  staff_id = :staff_id, 
                  course = :course, 
                  comments = :comments
                  ON DUPLICATE KEY UPDATE 
                  score = :score,
                  comments = :comments";

        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize data
        $this->id = htmlspecialchars(strip_tags($this->id));            
        $this->score = htmlspecialchars(strip_tags($this->score));            
        $this->staffId = htmlspecialchars(strip_tags($this->staffId));            
        $this->criteriaId = htmlspecialchars(strip_tags($this->criteriaId));            
        $this->studentId = htmlspecialchars(strip_tags($this->studentId));
        $this->course = htmlspecialchars(strip_tags($this->course));            
        $this->comments = htmlspecialchars(strip_tags($this->comments));            
    
        // Bind parameters
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':score', $this->score);
        $stmt->bindParam(':student_id', $this->studentId);
        $stmt->bindParam(':staff_id', $this->staffId);
        $stmt->bindParam(':criteria_id', $this->criteriaId);
        $stmt->bindParam(':course', $this->course);       
        $stmt->bindParam(':comments', $this->comments);

        // return true if query is successful
        if($stmt->execute()){
            return TRUE;
        } else {
            printf("Error %s \n", $stmt->error);
            return FALSE;
        }  

    }


    public function single(){
        $query = "SELECT $this->table.score AS score, criteria.total AS total, criteria.name AS name 
        FROM $this->table
        JOIN criteria
        WHERE $this->table.student_id = :id AND $this->table.course = :course AND $this->table.criteria_id = criteria.id ";
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->studentId = htmlspecialchars(strip_tags($this->studentId));
        $this->course = htmlspecialchars(strip_tags($this->course));

        //bind parameters
        $stmt->bindParam(':id', $this->studentId);
        $stmt->bindParam(':course', $this->course);

        $stmt->execute();

        $result = $stmt;
        //get row count
        $num = $result->rowCount();
        // create students array
        $grades = array();
        // if num > 0
        if($num > 0){
          while($row = $result->fetch(PDO::FETCH_OBJ)){
            array_push($grades, $row);
          }
        }
        // return
        return $grades ? $grades : NULL;
    }

}


?>