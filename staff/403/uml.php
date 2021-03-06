<?php 
  if(isset($_SESSION['staff']) && isset($_GET['id'])){
      // INCLUDES
    include_once "../../config/database.php";
    include_once "../../models/Users.php";

    // Get variables
    $staff = $_SESSION['staff'];
    $course = $_SESSION['course']; 
    $studentId = $_GET['id'];

    // Instantiate DB connection
    $db = new Database();
    $conn = $db->connect();

    // Instantiate Users Class
    $User = new Users($conn);
    $User->id = $studentId;

    $student = $User->getUserById();

  } else {
    header('Location: ../../index.php');
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>UML</title>
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
    crossorigin="anonymous">
  <style>
    tr{
      border: 1px solid black;
    }
    td,th {
      border: 1px solid black;
    }
    table{
      margin: 30px auto;
    }
    textarea{
      width: 100%;
    }
    .main-btn {
      margin-left: 30px;
    }
  </style>
</head>
<body>
  <a href="../index.php" class="main-btn btn"><i class="fas fa-caret-left"></i> Back</a>
<?php if($staff->evaluation === "uml"): ?>
  <table>
    <form action="" method="post">
      <tr>
        <th colspan="2">Student ID:</th>
        <td colspan="4"><?php echo $student->id; ?></td>
      </tr>
      <tr>
        <th colspan="2">Name:</th>
        <td colspan="4"><?php echo "$student->firstName $student->lastName"; ?></td>
      </tr>
      <tr>
        <th>CRITERIA</th>
        <th>Guidlines</th>
        <th>%</th>
        <th>Bad 1/4</th>
        <th>Average 1/2</th>
        <th>Good 1</th>
      </tr>
      <tr>
        <td rowspan="6" class="criteria">Use Case Diagram</td>
        <td>General Use Case</td>
        <td>0.5</td>
        <td><input type="radio" name="ch1" value="0.125" checked></td>
        <td><input type="radio" name="ch1" value="0.25"></td>
        <td><input type="radio" name="ch1" value="0.5"></td>
      </tr>
      <tr>
        <td>Partial Use Case</td>
        <td>0.5</td>
        <td><input type="radio" name="ch2" value="0.125" checked></td>
        <td><input type="radio" name="ch2" value="0.25"></td>
        <td><input type="radio" name="ch2" value="0.5"></td>
      </tr>
      <tr>
        <td>System Boundary</td>
        <td>1.0</td>
        <td><input type="radio" name="ch3" value="0.25" checked></td>
        <td><input type="radio" name="ch3" value="0.5"></td>
        <td><input type="radio" name="ch3" value="1.0"></td>
      </tr>
      <tr>
        <td>Include Relationship</td>
        <td>1.0</td>
        <td><input type="radio" name="ch4" value="0.25" checked></td>
        <td><input type="radio" name="ch4" value="0.5"></td>
        <td><input type="radio" name="ch4" value="1.0"></td>
      </tr>
      <tr>
        <td>Extends Relationship</td>
        <td>1.0</td>
        <td><input type="radio" name="ch5" value="0.25" checked></td>
        <td><input type="radio" name="ch5" value="0.5"></td>
        <td><input type="radio" name="ch5" value="1.0"></td>
      </tr>
      <tr>
        <td>Generalization Relationship</td>
        <td>1.0</td>
        <td><input type="radio" name="ch6" value="0.25" checked></td>
        <td><input type="radio" name="ch6" value="0.5"></td>
        <td><input type="radio" name="ch6" value="1.0"></td>
      </tr>
      <tr>
        <td rowspan="4" class="criteria">Activity Diagram</td>
        <td>Swimlane</td>
        <td>1.0</td>
        <td><input type="radio" name="ch7" value="0.25" checked></td>
        <td><input type="radio" name="ch7" value="0.5"></td>
        <td><input type="radio" name="ch7" value="1.0"></td>
      </tr>
      <tr>
        <td>Fork/Join</td>
        <td>1.0</td>
        <td><input type="radio" name="ch8" value="0.25"checked></td>
        <td><input type="radio" name="ch8" value="0.5"></td>
        <td><input type="radio" name="ch8" value="1.0"></td>
      </tr>
      <tr>
        <td>Normal Flow</td>
        <td>1.0</td>
        <td><input type="radio" name="ch9" value="0.25" checked></td>
        <td><input type="radio" name="ch9" value="0.5"></td>
        <td><input type="radio" name="ch9" value="1.0"></td>
      </tr>
      <tr>
        <td>Alternative Flow</td>
        <td>1.0</td>
        <td><input type="radio" name="ch10" value="0.25" checked></td>
        <td><input type="radio" name="ch10" value="0.5"></td>
        <td><input type="radio" name="ch10" value="1.0"></td>
      </tr>
      <tr>
        <td rowspan="4" class="criteria">Use Case Templates</td>
        <td>Completeness</td>
        <td>1.0</td>
        <td><input type="radio" name="ch11" value="0.25" checked></td>
        <td><input type="radio" name="ch11" value="0.5"></td>
        <td><input type="radio" name="ch11" value="1.0"></td>
      </tr>
      <tr>
        <td>Normal Flow</td>
        <td>1.5</td>
        <td><input type="radio" name="ch12" value="0.375" checked></td>
        <td><input type="radio" name="ch12" value="0.75"></td>
        <td><input type="radio" name="ch12" value="1.5"></td>
      </tr>
      <tr>
        <td>Alternative Flow</td>
        <td>1.5</td>
        <td><input type="radio" name="ch13" value="0.375" checked></td>
        <td><input type="radio" name="ch13" value="0.75"></td>
        <td><input type="radio" name="ch13" value="1.5"></td>
      </tr>
      <tr>
        <td>Numbering</td>
        <td>1.0</td>
        <td><input type="radio" name="ch14" value="0.25" checked></td>
        <td><input type="radio" name="ch14" value="0.5"></td>
        <td><input type="radio" name="ch14" value="1.0"></td>
      </tr>
      <tr>
        <td class="criteria">Domain Class Diagram</td>
        <td>Completeness</td>
        <td>3.0</td>
        <td><input type="radio" name="ch15" value="0.75" checked></td>
        <td><input type="radio" name="ch15" value="1.5"></td>
        <td><input type="radio" name="ch15" value="3.0"></td>
      </tr>
      <tr>
        <td class="criteria">Interface Sketches</td>
        <td>Completeness</td>
        <td>5.0</td>
        <td><input type="radio" name="ch16" value="1.25" checked></td>
        <td><input type="radio" name="ch16" value="2.5"></td>
        <td><input type="radio" name="ch16" value="5.0"></td>
      </tr>
      <tr>
        <td class="criteria">Project Management Plan & Gantt Chart</td>
        <td>Completeness</td>
        <td>3.0</td>
        <td><input type="radio" name="ch17" value="0.75" checked></td>
        <td><input type="radio" name="ch17" value="1.5"></td>
        <td><input type="radio" name="ch17" value="3.0"></td>
      </tr>
      <tr>
        <td colspan="6">
          <textarea name="comments" placeholder="Comments" cols="30" rows="10"></textarea>
        </td>
      </tr>
      <tr>
        <td>
          <input type="submit" value="Submit" name="submit" class="btn green">
        </td>
      </tr>
    </form>
  </table>
<?php else: ?>
  <h4 class="title">You are not assigned to this Citeria!</h4>
<?php endif; ?>
<!-- TOAST MESSAGE -->
<div id="toast"><div id="desc"></div></div>
<!-- UI SCRIPT  -->
<script src="../../js/ui.js"></script>
</body>
</html>
<?php
  if(isset($_POST['submit'])){
    $ch1 = (float) $_POST['ch1'];
    $ch2 = (float) $_POST['ch2'];
    $ch3 = (float) $_POST['ch3'];
    $ch4 = (float) $_POST['ch4'];
    $ch5 = (float) $_POST['ch5'];
    $ch6 = (float) $_POST['ch6'];
    $ch7 = (float) $_POST['ch7'];
    $ch8 = (float) $_POST['ch8'];
    $ch9 = (float) $_POST['ch9'];
    $ch10 = (float) $_POST['ch10'];
    $ch11 = (float) $_POST['ch11'];
    $ch12 = (float) $_POST['ch12'];
    $ch13 = (float) $_POST['ch13'];
    $ch14 = (float) $_POST['ch14'];
    $ch15 = (float) $_POST['ch15'];
    $ch16 = (float) $_POST['ch16'];
    $ch17 = (float) $_POST['ch17'];

    $comments = $_POST['comments'];

    $score = $ch1 + $ch2 + $ch3 + $ch4 + $ch5 + $ch6 + $ch7 + $ch8 + $ch9 + $ch10 + $ch11 + $ch12 + $ch13 + $ch14 + $ch15 + $ch16 + $ch17;

    $id = "uml$course$studentId";
    // Include Grades
    include_once "../../models/Grades.php";
    // instantiate Grades
    $Grades = new Grades($conn);

    // Set paramenters
    $Grades->id = $id;
    $Grades->staffId = $staff->id;
    $Grades->studentId = $studentId;
    $Grades->criteriaId = 1;
    $Grades->score = $score;
    $Grades->course = $course;
    $Grades->comments = $comments;

    if ($Grades->put()) {
      echo "<script> launch_toast('Evaluation Saved'); </script>";
    } else {
      echo "<script> launch_toast('Something Went Wrong'); </script>";
    }

  }

?>