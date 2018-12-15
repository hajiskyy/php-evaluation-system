<?php
if(isset($_SESSION['staff'])){
  // INCLUDES
  include_once "../config/database.php";
  include_once "../models/Users.php";
  include_once "../models/Attendance.php";

  // Get variables
  $staff = $_SESSION['staff'];
  $course = $_SESSION['course'];

  // Instantiate DB connection
  $db = new Database();
  $conn = $db->connect();

  // Instantiate Users Class
  $User = new Users($conn);
  // Instantiate Attendance Class
  $Attendance = new Attendance($conn);

  // Set properties
  $User->course = $course;
  $User->advisorId = $staff->id;

  // get student Students
  $students = $User->getStudentsByAdvisor();
  // get attendance Students
  $attendance = $Attendance->getAll();

} else {
  header('Location: ../index.php');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
    crossorigin="anonymous">
  <title>Home</title>
</head>
<body>
<!-- Side Nav -->
<?php include "../helpers/staff.php" ?>
<!-- Main Page -->
<div class="main">
<?php if($students): ?>
  <table>
    <h3 class="title">Your Students</h3>
      <tr>
        <th>Student ID</th>
        <th>Name</th>
        <th>Course</th>
        <th></th>
      </tr>
      <?php foreach($students as $s): ?>
        <tr>
          <td><?php echo $s->id; ?></td>
          <td><?php echo "$s->firstName $s->lastName"; ?></td>
          <td><?php echo $s->course; ?></td>
          <td>
            <form action="" method="post">
              <input type="hidden" name="id" value="<?php echo $s->id; ?>">
                <label class="container">
                <input type="checkbox" name="check[]" value="<?php echo $s->id; ?>">
                <span class="checkmark"></span>
            </label>
          </td>
        </tr>
      <?php endforeach; ?>
      <tr>
        <td>
          <button type="submit" name="save" class="btn green">Save</button>
          </form>
        </td>
      </tr>
  </table>
<?php else: ?>
  <h3 class="title">You don't Advise any student</h3>
<?php endif;?>
<table>
  <tr>
    <td>
      See All students 
      <a href="./students.php" class="btn green">Go</a>
    </td>
  </tr>
</table>
</div>
<!-- TOAST MESSAGE -->
<div id="toast"><div id="desc"></div></div>
<!-- UI SCRIPT  -->
<script src="../js/ui.js"></script>
</body>
</html>
<?php 
if(isset($_POST['save'])){
  $checks = $_POST['check'];

  $Attendance->staffId = $staff->id;
  $Attendance->course = $course;

  if($Attendance->put($checks)){
    echo "<script> launch_toast('Attendance Saved'); </script>";
  } else {
    echo "<script> launch_toast('Something went wrong'); </script>";
  }
}
?>