<?php 
if(isset($_SESSION['head'])){

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
  <title>Create Tasks</title>
</head>
<body>
  <!-- Side Nav -->
  <?php include "../helpers/head.php" ?>

  <!-- Main -->
<div class="main">
  <!-- Back button -->
<a href="./tasks.php" class="main-btn btn"><i class="fas fa-caret-left"></i> Back</a>

<div class="form-card">
  <form action="" method="post">
    <!-- Title -->
    <h3 class="title">Add New Task</h3>
    <!-- Task name -->
    <input type="text" name="name" placeholder="Task Name" class="input-form" minlength="2" required>
    <!-- Task description -->
    <textarea name="description" cols="30" rows="10" placeholder="Task Description" class="form-textarea"></textarea>
    <!-- Task Due -->
    <label for="date" class="label">Task Due</label>
    <input type="date" id="date" class="input-form" name="date" placeholder="Due Date">
    <!-- Course -->
    <label for="course" class="label">Select Course</label>
    <select name="course" id="course">
      <option value="403" selected>ITEC 403</option>
      <option value="404">ITEC 404</option>
    </select>
    <!-- BUTTONS -->
    <input type="submit" value="Create" name="create" class="btn green">
  </form>
</div>
<!-- TOAST MESSAGE -->
<div id="toast"><div id="desc"></div></div>
<!-- UI SCRIPT  -->
<script src="../js/ui.js"></script>
</body>
</html>
<?php
// On Register
if(isset($_POST['create'])){
  //get post details
  $name = $_POST['name'];
  $description = $_POST['description'];
  $date = $_POST['date'];
  $course = $_POST['course'];

  // INCLUDES
  include_once "../config/database.php";
  include_once "../models/Tasks.php";

  // Instantiate DB connection
  $db = new Database();
  $conn = $db->connect();

  // Instantiate Users Class
  $Tasks = new Tasks($conn);

  // Set Properties
  $Tasks->name = $name;
  $Tasks->course = $course;
  $Tasks->description = $description;
  $Tasks->due = $date;

  // Add Task
  if( $Tasks->create()){
    echo "<script> launch_toast('Task Created'); </script>";
  } else {
    echo "<script> launch_toast('Something went wrong'); </script>";
  }

}
?>
