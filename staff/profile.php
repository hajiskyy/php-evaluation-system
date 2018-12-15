<?php 
if(isset($_SESSION['staff'])){
  $profile  = $_SESSION['staff'];
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
  <?php include "../helpers/staff.php" ?>

  <!-- Main -->
<div class="main">
  <h3 class="title">Your Profile</h3>
    <table>
      <tr>
        <td><b>ID:</b> <?php echo $profile->id; ?></td>
      </tr>
      <tr>
        <td><b>Name:</b> <?php echo $profile->firstName." ".$profile->lastName; ?></td>
      </tr>
      <tr>
        <td><b>Role:</b> <?php echo $profile->role; ?></td>
      </tr>
      <tr>
        <td><b>Email:</b> <?php echo $profile->email; ?></td>
      </tr>
      <tr>
      <form action="" method="post">
        <td>
          <label for="password" class="label">Change Password</label>
            <input type="password" name="password" id="password" class="input-form" placeholder="Enter new password">
        </td>
      </tr>
      <tr>
        <td>
          <button type="submit" class="btn green" name="change">Change</button>
        </td>
        </form>
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
  // On delete click
  if(isset($_POST['change'])){
    // INCLUDES
    include_once "../config/database.php";
    include_once "../models/Users.php";
  
    // Instantiate DB connection
    $db = new Database();
    $conn = $db->connect();
  
    // Instantiate Users Class
    $User = new Users($conn);

    // set paramenters
    $User->id = $profile->id;
    $User->password = $_POST['password'];

    // Change Password
    if($User->changePassword()){
      echo "<script> launch_toast('Password Changed'); </script>";
    } else {
      echo "<script> launch_toast('Something went wrong'); </script>";
    }
  }

?>