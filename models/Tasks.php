<?php
class Tasks {

    //database req
    private $conn;
    private $table = 'tasks';
    
    //tasks properties
    public $id;
    public $name;
    public $description;
    public $course;
    public $due;
    
    //constuctor
    public function __construct($db){
        $this->conn = $db;
    }

    //get all tasks
    public function getAllTasks(){
        // Query
        $query = "SELECT * from $this->table";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // excute query
        $stmt->execute();

        $result = $stmt;

        //get row count
        $num = $result->rowCount();
        // create students array
        $tasks = array();
        // if num > 0
        if($num > 0){
          while($row = $result->fetch(PDO::FETCH_OBJ)){
            array_push($tasks, $row);
          }
        }
        // return
        return $tasks ? $tasks : NULL;
    }

      //get tasks by Course
    public function getTaskbyCourse(){
        // Query
        $query = "SELECT * from $this->table WHERE course = :course";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize data
        $this->course = htmlspecialchars(strip_tags($this->course));
        // bind parameter
        $stmt->bindParam(':course', $this->course);

        // excute query
        $stmt->execute();
  
        $result = $stmt;
  
        //get row count
        $num = $result->rowCount();
        // create students array
        $tasks = array();
        // if num > 0
        if($num > 0){
          while($row = $result->fetch(PDO::FETCH_OBJ)){
            array_push($tasks, $row);
          }
        }
        // return
        return $tasks ? $tasks : NULL;
    }

    //create Tasks
    public function create(){
        $query = "INSERT INTO $this->table 
        SET
            name = :name,
            description = :description,
            course = :course,
            due = :due
        ";
        $stmt = $this->conn->prepare($query);

        //  sanitize data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->due = htmlspecialchars(strip_tags($this->due));
        $this->course = htmlspecialchars(strip_tags($this->course));

        // bind parameter
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':due', $this->due);
        $stmt->bindParam(':course', $this->course);

        if($stmt->execute()){
            return TRUE;
        } else {
            printf("Error %s \n", $stmt->error);
            return FALSE;
        }   
    }

    //update task
    public function update(){
        $query = "UPDATE $this->table 
        SET
            name = :name,
            description = :description,
            due = :due
        WHERE id = :id
        ";
        $stmt = $this->conn->prepare($query);

        //  sanitize data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->due = htmlspecialchars(strip_tags($this->due));

        // bind parameter
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':due', $this->due);

        if($stmt->execute()){
            return true;
        } else {
            printf("Error %s \n", $stmt->error);
            return false;
        } 
    }

    //delete task (if neccessary)
    public function delete(){
        $query = " DELETE FROM $this->table
        WHERE id =:id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id)); 

        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return TRUE;
        } else {
            printf("Error %s \n", $stmt->error);
            return FALSE;
        }
    }


}


?>