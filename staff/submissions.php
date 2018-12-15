<?php
if(isset($_SESSION['staff']) && isset($_GET['id'])){
  // INCLUDES
  include_once "../config/database.php";
  include_once "../models/Submissions.php";

  // Get variables
  $staff = $_SESSION['staff'];
  $course = $_SESSION['course'];
  $id = $_GET['id'];

  // Instantiate DB connection
  $db = new Database();
  $conn = $db->connect();

  // Instantiate Users Class
  $Submission = new Submissions($conn);
  // Set properties
  $Submission->course = $course;
  $Submission->studentId = $id;

  // get student Students
  $submissions = $Submission->getStudentSubmission();
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
<?php if($submissions): ?>
  <table>
    <h3 class="title">Student Submission</h3>
    <a href="./index.php" class="main-btn btn"><i class="fas fa-caret-left"></i> Back</a>

    <?php if($staff->evaluation != NULL): ?>
      <a href="<?php echo "./$course/$staff->evaluation.php?id=$id"; ?>" class="main-btn btn green right"><i class="far fa-check-square"></i> Evaluate</a>
    <?php endif;?>
      <tr>
        <td>Task Name</td>
        <td>Download</td>
      </tr>
      <?php foreach($submissions as $s): ?>
        <tr>
          <td><?php echo $s->task_name; ?></td>
          <td><a href="<?php echo "../$s->path"; ?>" class="btn"><i class="fas fa-download" download></i> Download</a> </td>
        </tr>
      <?php endforeach; ?>
  </table>
<?php else: ?>
  <h3 class="title">Student has no submission</h3>
<?php endif;?>
</div>
  <!-- UI SCRIPT  -->
  <script src="../js/ui.js"></script>
</body>
</html>