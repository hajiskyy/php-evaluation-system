<?php 
if(isset($_SESSION['head']) && isset($_GET['id']) && isset($_GET['course'])){

    // INCLUDES
    include_once "../config/database.php";
    include_once "../models/Users.php";
  
    // Instantiate DB connection
    $db = new Database();
    $conn = $db->connect();
  
    // Instantiate Users Class
    $User = new Users($conn);

    // Assign course
    $course = $_GET['course'];
    $User->course = $course;

    // get Staffs
    $staffs = $User->getStaffsbyCourse();
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
  <?php include "../helpers/head.php" ?>

  <!-- Main -->
<div class="main">
  <!-- <h3 class="title">Staffs</h3> -->
<a href="./index.php" class="main-btn btn"><i class="fas fa-caret-left"></i>  back</a>
  <!-- If staff exists -->
  <?php if($staffs): ?>
  <h3 class="title">Select Staff To Assign</h3>
    <table>
      <tr>
        <th>Staff Id</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Course</th>
        <th>Select</th>
      </tr>
    <?php foreach($staffs as $s): ?>
      <tr>
        <td><?php echo $s->id; ?></td>
        <td><?php echo $s->firstName; ?></td>
        <td><?php echo $s->lastName; ?></td>
        <td><?php echo "ITEC $s->course"; ?></td>


        <!-- Select button -->
        <td>
          <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $s->id; ?>">
            <button type="submit" class="btn green" name="select"><i class="fas fa-check"></i>   Select</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </table>
  <?php else: ?>
    <h3 class="title">No Staff Yet</h3>
  <?php endif; ?>
</div>
<!-- TOAST MESSAGE -->
<div id="toast"><div id="desc"></div></div>
<!-- UI SCRIPT  -->
<script src="../js/ui.js"></script>
</body>
</html>
<?php
  // On delete click
  if(isset($_POST['select'])){
    // Get staff id from post
    $User->advisorId = $_POST['id'];

    // get student id from params
    $User->id = $_GET['id'];

    // delete student
    if($User->setAdvisor()){
      echo "<script> launch_toast('Staff Assinged'); </script>";
    } else {
      echo "<script> launch_toast('Something Went Wrong'); </script>";
    }
  }

?>