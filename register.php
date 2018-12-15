<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/style.css">
  <title>Register</title>
</head>
<body>
  <nav>
    <span>Register</span>
    <a href="/haji">SCT project manager</a>
  </nav>
  <div class="form-card">
    <form action="" method="post">
      <!-- Title -->
      <h3 class="title">Register to Project Manager</h3>
      <input type="text" name="id" placeholder="ID" class="input-form" minlength="3" required>
      <input type="text" name="fname" id="" placeholder="First Name" class="input-form" minlength="2" required>
      <input type="text" name="lname" id="" placeholder="Last Name" class="input-form"
      minlength="3" required>
      <input type="email" name="email" id="" placeholder="Email" class="input-form" required>
      <input type="password" name="password" placeholder="Password" class="input-form" minlength="4" required>
      <input type="password" name="password2" placeholder="Confirm Password" class="input-form" minlength="4" required>
      <!-- Course -->
      <label for="course" class="label">Select Course</label>
      <select name="course" id="course">
        <option value="403" selected>ITEC 403</option>
        <option value="404">ITEC 404</option>
      </select>
      <!-- BUTTONS -->
      <input type="submit" value="Register" name="register" class="btn green">
    </form>
    <p class="center">Already have an account? <a href="./index.php">Log in</a></p>
  </div>
  
  <!-- TOAST MESSAGE -->
  <div id="toast"><div id="desc"></div></div>
  <!-- UI SCRIPT -->
  <script src="./js/ui.js"></script>
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
    include_once "./config/database.php";
    include_once "./models/Users.php";

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
    $User->role = "student";
    $User->password = $password;

    // Authenticate
    $User->registerUser();
  } else {

  }

}
?>