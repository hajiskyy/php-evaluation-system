<?php 
if(isset($_SESSION['student'])){
  $student  = $_SESSION['student'];
  $course  = $_SESSION['course'];
  // INCLUDES
  include_once "../config/database.php";
  include_once "../models/Grades.php";
  include_once "../models/Attendance.php";
  
  // Instantiate DB connection
  $db = new Database();
  $conn = $db->connect();
  
  // Instantiate Grades Class
  $Grades = new Grades($conn);
  $Attendance = new Attendance($conn);

  // set properties
  $Grades->studentId = $student->id;
  $Grades->course = $course;
  $Attendance->studentId = $student->id;
  $Attendance->course = $course;

  // get grades
  $grades = $Grades->single();
  $attendance = $Attendance->single();

  $attendancePercentage = (float) $attendance->attended/16 * 100;

} else {
  header('Location: ../index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
    crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <title>Staffs</title>
</head>
<body>
  <!-- Side Nav -->
  <?php include "../helpers/student.php" ?>

  <!-- Main -->
<div class="main">
  <?php if($grades): ?>
    <h3 class="title">Your Grades</h3>
      <table>
        <tr>
          <th>Name</th>
          <th>Score</th>
          <th>Total</th>
        </tr>
    <?php foreach($grades as $g): ?>
      <tr>
        <td><?php echo strtoupper($g->name); ?></td>
        <td><?php echo $g->score; ?></td>
        <td><?php echo $g->total; ?></td>
      </tr>
    <?php endforeach; ?>
      </table>

  <?php else: ?>
    <h3 class="title">No Grades Posted Yet</h3>
  <?php endif; ?>

  <?php if($attendance): ?>
  <h3 class="title" style="margin-top: 40px;">Your Attendance </h3>
  <table>
    <tr>
      <th>Attended</th>
      <th>Percentage</th>
    </tr>
    <tr>
      <td><?php echo $attendance->attended; ?></td>
      <td><?php echo $attendancePercentage; ?></td>
    </tr>
  </table>
  <?php else: ?>
  <h3 class="title">No Attendance Record</h3>
  <?php endif; ?>

</div>
</body>
</html>