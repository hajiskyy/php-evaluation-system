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
  <title>Accounts</title>
</head>
<body>
  <!-- Side Nav -->
  <?php include "../helpers/head.php" ?>

  <!-- Main -->
<div class="main">
  <!-- Back button -->
<a href="./staffs.php" class="main-btn btn"><i class="fas fa-caret-left"></i> Back</a>

<div class="form-card">
  <form action="" method="post">
    <!-- Title -->
    <h3 class="title">Create Staff Account</h3>
    <input type="text" name="id" placeholder="ID" class="input-form" minlength="3" required>
    <input type="text" name="fname" id="" placeholder="First Name" class="input-form" minlength="2" required>
    <input type="text" name="lname" id="" placeholder="Last Name" class="input-form"
    minlength="3" required>
    <input type="email" name="email" id="" placeholder="Email" class="input-form" required>
    <input type="password" name="password" placeholder="Password" class="input-form" minlength="4" required>
    <input type="password" name="password2" placeholder="Confirm Password" class="input-form" minlength="4" required>
    <!-- Course -->
    <h4 class="center">Select Course</h4>
    <select name="course" id="course">
      <option value="403" selected>ITEC 403</option>
      <option value="404">ITEC 404</option>
    </select>
    <!-- BUTTONS -->
    <input type="submit" value="Register" name="register" class="btn green">
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
if(isset($_POST['register'])){
  //get post details
  $id = $_POST['id'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $course = $_POST['course'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];

  // Check if passwords match
  if($password === $password2){
    // INCLUDES
    include_once "../config/database.php";
    include_once "../models/Users.php";

    // Instantiate DB connection
    $db = new Database();
    $conn = $db->connect();

    // Instantiate Users Class
    $User = new Users($conn);

    // Set Properties
    $User->id = $id;
    $User->firstName = $fname;
    $User->lastName = $lname;
    $User->email = $email;
    $User->course = $course;
    $User->role = "staff";
    $User->password = $password;

    // Authenticate
    $User->registerUser();
  } else {

  }
}
?>
