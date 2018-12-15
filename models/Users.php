<?php
class Users {
  //database req
  private $conn;
  private $table = 'users';

  //student propertis
  public $id;
  public $firstName;
  public $lastName;
  public $password;
  public $email;
  public $advisorId;
  public $registered;
  public $evaluation;
  public $role;
  public $course;

  //constuctor
  public function __construct($db){
      $this->conn = $db;
  }

  public function authenticate(){
    // Get User
    $user = $this->getUserById();

    // Verify Password
    if(password_verify($this->password, $user->password)){
      // CHECK ROLES
      switch ($user->role) {
        case 'student':
                if($user->registered != NULL){
                  // SET session variables
                  $_SESSION['student'] = $user;
                  $_SESSION['course'] = $user->course;
                  // redirect to student page
                  header('Location: ./student/');
                  exit;
                } else {
                  echo "<script> launch_toast('You are not registered by the committee yet'); </script>";
                }
                break;
        case 'head':
                // SET session variables
                $_SESSION['head'] = $user;
                // redirect to staff head page
                header('Location: ./head/');
                exit;
                break;
        case 'staff':
                // SET session variables
                $_SESSION['staff'] = $user;
                $_SESSION['course'] = $user->course;
                // redirect to staff page
                header('Location: ./staff/');
                exit;
                break;
      }
    } else {
      echo "<script> launch_toast('Wrong password'); </script>";
    }
  }

    // Get student by Id
  public function getUserById(){
    $query = "SELECT * from $this->table WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    // Bind Id
    $stmt->bindParam(1, $this->id);

    $stmt->execute();

    $result = $stmt;

    //get row count
    $num = $result->rowCount();

    if($num > 0){
        $user = $result->fetch(PDO::FETCH_OBJ);
    }

    return $user ? $user : NULL;
  }

  // Get student by Id
  public function getStudentById(){
    $query = "SELECT * from $this->table WHERE id = ? AND role = student";
    $stmt = $this->conn->prepare($query);
    // Bind Id
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $result = $stmt;

    //get row count
    $num = $result->rowCount();

    if($num > 0){
        $student = $result->fetch(PDO::FETCH_OBJ);
    }

    return $student ? $student : NULL;
  }

  // get student by Advisor
  public function getStudentsByAdvisor(){
    $query = "SELECT * from $this->table WHERE advisor_id = :advisor AND course = :course";
    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize data
    $this->advisorId = htmlspecialchars(strip_tags($this->advisorId));
    $this->course = htmlspecialchars(strip_tags($this->course));            

    // Bind parameters
    $stmt->bindParam(":advisor", $this->advisorId);
    $stmt->bindParam(":course", $this->course);
    // execute query
    $stmt->execute();

    $result = $stmt;

    //get row count
    $num = $result->rowCount();

    //create student array
    $students = array();
    
    if($num > 0){
      while($row = $result->fetch(PDO::FETCH_OBJ)){
        array_push($students, $row);
      }
    }
  
    return $students ? $students : NULL;
  }

  // get student by Course
  public function getStudentsByCourse(){
    $query = "SELECT * from $this->table WHERE  course = :course AND role = 'student'";
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize data
    $this->course = htmlspecialchars(strip_tags($this->course));            
  
    // Bind parameters
    $stmt->bindParam(":course", $this->course);
    // execute query
    $stmt->execute();
  
    $result = $stmt;
  
    //get row count
    $num = $result->rowCount();
  
    //create student array
    $students = array();
    
    if($num > 0){
      while($row = $result->fetch(PDO::FETCH_OBJ)){
        array_push($students, $row);
      }
    }
  
    return $students ? $students : NULL;
  }

  //set an advisor
  public function setAdvisor(){
      $query = "UPDATE $this->table SET advisor_id = :advisor WHERE id = :id";
      $stmt = $this->conn->prepare($query);
      $this->id = htmlspecialchars(strip_tags($this->id));            
      $this->advisorId = htmlspecialchars(strip_tags($this->advisorId));

      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam(":advisor", $this->advisorId);

      if($stmt->execute()){
          return TRUE;
      } else {
          printf("Error %s \n", $stmt->error);
          return FALSE;
      }
  }

    //set an advisor
    public function setEvaluation(){
      $query = "UPDATE $this->table SET evaluation = :evaluation WHERE id = :id";
      $stmt = $this->conn->prepare($query);

      $this->id = htmlspecialchars(strip_tags($this->id));            
      $this->evaluation = htmlspecialchars(strip_tags($this->evaluation));
      
      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam(":evaluation", $this->evaluation);

      if($stmt->execute()){
          return TRUE;
      } else {
          printf("Error %s \n", $stmt->error);
          return FALSE;
      }
  }

  // Get All Students
  public function getAllStudents(){
      $query = "SELECT * from $this->table WHERE role = student";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      $result = $stmt;

      //get row count
      $num = $result->rowCount();

      //create student array
      $students = array();
      
      if($num > 0){
        while($row = $result->fetch (PDO::FETCH_OBJ)){
          array_push($students, $row);
        }
      }
    
      return $students ? $students : NULL;
  }

  // Get All Staffs
  public function getAllStaff(){
    $query = "SELECT * from $this->table WHERE role = 'staff'";
    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    $result = $stmt;

    //get row count
    $num = $result->rowCount();

    //create staff array
    $staffs = array();
    
    if($num > 0){
      while($row = $result->fetch(PDO::FETCH_OBJ)){
        array_push($staffs, $row);
      }
    }
  
    return $staffs ? $staffs : NULL;
  }

  // Get All Staffs
  public function getStaffsbyCourse(){
    $query = "SELECT * from $this->table WHERE role = 'staff' AND course =:course";
    $stmt = $this->conn->prepare($query);
       
    $this->course = htmlspecialchars(strip_tags($this->course));
    $stmt->bindParam(":course", $this->course);

    $stmt->execute();

    $result = $stmt;

    //get row count
    $num = $result->rowCount();

    //create staff array
    $staffs = array();
    
    if($num > 0){
      while($row = $result->fetch(PDO::FETCH_OBJ)){
        array_push($staffs, $row);
      }
    }
  
    return $staffs ? $staffs : NULL;
  }

  // get unregitsered students
  public function getUnregisteredStudents(){
      // Query
      $query = "SELECT * from $this->table WHERE role = 'student' AND registered IS NULL";
      //prepare query
      $stmt = $this->conn->prepare($query);
      // execute query
      $stmt->execute();

      $result = $stmt;

      //get row count
      $num = $result->rowCount();
      // create students array
      $students = array();
      // if num > 0
      if($num > 0){
        while($row = $result->fetch(PDO::FETCH_OBJ)){
          array_push($students, $row);
        }
      }
      // return
      return $students ? $students : NULL;
  }

  // get regitsered students
  public function getRegisteredStudents(){
      $query = "SELECT * from $this->table WHERE role = 'student' AND registered = 1";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      $result = $stmt;
      //get row count
      $num = $result->rowCount();
      // create students array
      $students = array();
      // if num > 0
      if($num > 0){
        while($row = $result->fetch(PDO::FETCH_OBJ)){
          array_push($students, $row);
        }
      }
      // return
      return $students ? $students : NULL;
  }

  // register user
  public function registerUser(){

    if($this->verifyRegister()){
      // Query
      $query = "INSERT INTO $this->table 
      SET
          id = :id,
          firstName = :fname,
          lastName = :lname,
          password = :pass,
          email = :email,
          role = :role,
          course = :course
        ";

      $stmt = $this->conn->prepare($query);

      //sanitize data
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->firstName = htmlspecialchars(strip_tags($this->firstName));
      $this->lastName = htmlspecialchars(strip_tags($this->lastName));
      $this->password = htmlspecialchars(strip_tags($this->password));
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->role = htmlspecialchars(strip_tags($this->role));
      $this->course = htmlspecialchars(strip_tags($this->course));

      //hash password
      $hash = password_hash($this->password, PASSWORD_BCRYPT);

      // bind parameter
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':fname', $this->firstName);
      $stmt->bindParam(':lname', $this->lastName);
      $stmt->bindParam(':pass', $hash);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':role', $this->role);
      $stmt->bindParam(':course', $this->course);

      //if query is executed
      if($stmt->execute()){
        if($this->role == "student"){
          header("Location: ./success.php");
          exit;
        } else {
          echo "<script> launch_toast('Account Created'); </script>";
        }

      } else {
          printf("Error %s \n", $stmt->error);
      }
    } else {
      echo "<script> launch_toast('Account alreay exists!!'); </script>";
    }
  }

  // verify user registeration
  private function verifyRegister(){
    //Query
    $query = "SELECT id, email FROM $this->table WHERE (id = :id) OR (email = :email)";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':email', $this->email);

    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->email = htmlspecialchars(strip_tags($this->email));

    $stmt->execute();

    $result = $stmt;
  
    //get row count
    $num = $result->rowCount();
    
    //return false is user already exists
    if($num > 0){
        return FALSE;
    } else {
        return TRUE;
    }

  }

  // Validate student registeration
  public function registerStudent(){
      // query
      $query = "UPDATE $this->table SET registered = 1 WHERE id =:id ";
      //prepare
      $stmt = $this->conn->prepare($query);
      // sanitise data
      $this->id = htmlspecialchars(strip_tags($this->id)); 
      // bind paramenters
      $stmt->bindParam(":id", $this->id);
      //excute query
      if($stmt->execute()){
          return TRUE;
      } else {
          printf("Error %s \n", $stmt->error);
          return FALSE;
      }
  }

  // Delete Student
  public function deleteUser(){
      $query = "DELETE FROM $this->table WHERE id =:id";
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

  // Change user password
  public function changePassword(){

    $query = "UPDATE $this->table SET password = :password WHERE id =:id ";
    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->password = htmlspecialchars(strip_tags($this->password));

    //hash password
    $hash = password_hash($this->password, PASSWORD_BCRYPT) ;

    //bind paramenters
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":password", $hash);

    if($stmt->execute()){
        return TRUE;
    } else {
        printf("Error %s \n", $stmt->error);
        return FALSE;
    }
  }
}
?>