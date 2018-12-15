<?php $result = ""; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/style.css">
  <title>Login</title>
</head>
<body>
  <nav>
    <span>Login</span>
    <a href="/haji">SCT project manager</a>
  </nav>

  <div class="form-card">
    <form action="" method="post">
      <h3 class="title">Login to Project Manager</h3>
      <input type="text" name="id" placeholder="ID" class="input-form">
      <input type="password" name="password" placeholder="Password" class="input-form">
      <input type="submit" value="Login" name="login" class="btn block green">
      <a href="./register.php" class="btn block">Register</a>
    </form>
  </div>
  <!-- TOAST MESSAGE -->
  <div id="toast"><div id="desc"></div></div>
  <!-- UI SCRIPT -->
  <script src="./js/ui.js"></script>
</body>
</html>
<?php
// On Login
if(isset($_POST['login'])){
  //get post details
  $id = $_POST['id'];
  $password = $_POST['password'];

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
  $User->password = $password;

  // Authenticate
  $User->authenticate();

}

?>