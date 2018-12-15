<?php
if(isset($_SESSION['staff'])){
  // INCLUDES
  include_once "../config/database.php";
  include_once "../models/Users.php";

  // Get variables
  $staff = $_SESSION['staff'];
  $course = $_SESSION['course'];

  // Instantiate DB connection
  $db = new Database();
  $conn = $db->connect();

  // Instantiate Users Class
  $User = new Users($conn);
  // Set properties
  $User->course = $course;
  // get student Students
  $students = $User->getStudentsByCourse();
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
    <h3 class="title"> All <?php echo "ITEC $course"?> Students</h3>
      <tr>
        <td>Student ID</td>
        <td>Name</td>
        <td>Course</td>
        <td>View Submission</td>
      </tr>
      <?php foreach($students as $s): ?>
        <tr>
          <td><?php echo $s->id; ?></td>
          <td><?php echo "$s->firstName $s->lastName"; ?></td>
          <td><?php echo $s->course; ?></td>
          <td><a href="./submissions.php?id=<?php echo $s->id; ?>" class="btn"><i class="fas fa-eye"></i> Submission</a> </td>
        </tr>
      <?php endforeach; ?>
  </table>
<?php else: ?>
  <h3 class="title">No student registered for this course yet</h3>
<?php endif;?>
</div>
  <!-- UI SCRIPT  -->
  <script src="../js/ui.js"></script>
</body>
</html>