<?php
class Submissions {

    //database req
    private $conn;
    private $table = 'submissions';
    
    //submissions properties
    public $id;
    public $taskId;
    public $taskName;
    public $studentId;
    public $path;
    public $course;
    
    //constuctor
    public function __construct($db){
        $this->conn = $db;
    }

    //get all submissions
    public function getAllSubmissions(){
        $query = "SELECT * from $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //get a student submission
    public function getStudentSubmission(){
        $query = "SELECT * from $this->table WHERE student_id = :id AND course = :course";
        $stmt = $this->conn->prepare($query);
        // Bind Id
        $stmt->bindParam(":id", $this->studentId);
        $stmt->bindParam(":course", $this->course);
        $this->studentId = htmlspecialchars(strip_tags($this->studentId));
        $this->course = htmlspecialchars(strip_tags($this->course));
        $stmt->execute();

        $result = $stmt;

        //get row count
        $num = $result->rowCount();
    
        //create student array
        $submissions = array();
        
        if($num > 0){
          while($row = $result->fetch(PDO::FETCH_OBJ)){
            array_push($submissions, $row);
          }
        }
      
        return $submissions ? $submissions : NULL;
    }

      //get submissions by course
    public function getSubmissionsByCourse(){
        $query = "SELECT * from $this->table WHERE course = :course";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize data
        $this->course = htmlspecialchars(strip_tags($this->course));
        // Bind Id
        $stmt->bindParam(":course", $this->course);
        // execute query
        $stmt->execute();

        $result = $stmt;

        //get row count
        $num = $result->rowCount();
    
        //create student array
        $submissions = array();
        
        if($num > 0){
          while($row = $result->fetch(PDO::FETCH_OBJ)){
            array_push($submissions, $row);
          }
        }
      
        return $submissions ? $submissions : NULL;
    }

    // get single submissions
    public function getSingle(){
        $query = "SELECT * from $this->table 
        WHERE 
        student_id = :student_id
        AND
        task_id = :task_id
        ";
        $stmt = $this->conn->prepare($query);

        // Bind Id
        $stmt->bindParam(":student_id", $this->studentId);
        $stmt->bindParam(":task_id", $this->taskId);

        $this->taskId = htmlspecialchars(strip_tags($this->taskId));
        $this->studentId = htmlspecialchars(strip_tags($this->studentId));

        $stmt->execute();

        return $stmt;
    }

    //create submissions
    public function create(){
        $query = "INSERT INTO $this->table 
        SET
            task_id = :task_id,
            task_name = :task_name,
            student_id = :student_id,
            path = :path,
            course = :course
        ";
        $stmt = $this->conn->prepare($query);

        //  sanitize data
        $this->taskId = htmlspecialchars(strip_tags($this->taskId));
        $this->taskName = htmlspecialchars(strip_tags($this->taskName));
        $this->studentId = htmlspecialchars(strip_tags($this->studentId));
        $this->path = htmlspecialchars(strip_tags($this->path));
        $this->course = htmlspecialchars(strip_tags($this->course));

        // bind parameter
        $stmt->bindParam(':task_id', $this->taskId);
        $stmt->bindParam(':task_name', $this->taskName);
        $stmt->bindParam(':student_id', $this->studentId);
        $stmt->bindParam(':path', $this->path);
        $stmt->bindParam(':course', $this->course);

        if($stmt->execute()){
            return TRUE;
        } else {
            printf("Error %s \n", $stmt->error);
            return FALSE;
        }   
    }

  //update submission
  public function update(){
      $query = "UPDATE $this->table 
      SET
          path = :path
      WHERE student_id = :student_id AND task_id = :task_id AND course  = :course
      ";
      $stmt = $this->conn->prepare($query);

      //  sanitize data
      $this->taskId = htmlspecialchars(strip_tags($this->taskId));
      $this->studentId = htmlspecialchars(strip_tags($this->studentId));
      $this->path = htmlspecialchars(strip_tags($this->path));
      $this->course = htmlspecialchars(strip_tags($this->course));

      // bind parameter
      $stmt->bindParam(':task_id', $this->taskId);
      $stmt->bindParam(':student_id', $this->studentId);
      $stmt->bindParam(':path', $this->path);
      $stmt->bindParam(':course', $this->course);

      if($stmt->execute()){
          return TRUE;
      } else {
          printf("Error %s \n", $stmt->error);
          return FALSE;
      }  
  }
}


?>