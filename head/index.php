<?php 
if(isset($_SESSION['head'])){

    // INCLUDES
    include_once "../config/database.php";
    include_once "../models/Users.php";
  
    // Instantiate DB connection
    $db = new Database();
    $conn = $db->connect();
  
    // Instantiate Users Class
    $User = new Users($conn);

    // get unregistered Students
    $unRegStudents = $User->getUnregisteredStudents();
    // get registered Students
    $regStudents = $User->getRegisteredStudents();

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
  <title>Home</title>
</head>
<body>
  <!-- Side Nav -->
  <?php include "../helpers/head.php" ?>

  <!-- Main -->
<div class="main">
  <!-- If Unregistered Students exists -->
  <?php if($unRegStudents): ?>
  <h3 class="title">Unregistered Students</h3>
    <table>
      <tr>
        <th>Student Id</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Course</th>
        <th>Register</th>
        <th>Delete</th>
      </tr>
    <?php foreach($unRegStudents as $s): ?>
      <tr>
        <td><?php echo $s->id; ?></td>
        <td><?php echo $s->firstName; ?></td>
        <td><?php echo $s->lastName; ?></td>
        <td><?php echo "ITEC $s->course"; ?></td>

        <!-- Register button -->
        <td>
          <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $s->id; ?>">
            <button type="submit" class="btn green" name="register"><i class="fas fa-user-plus"></i> register</button>
          </form>
        </td>

        <!-- Delete button -->
        <td>
          <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $s->id; ?>">
            <button type="submit" class="btn red" name="delete"><i class="fas fa-trash"></i> delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </table>
  <?php else: ?>
    <h3 class="title">No Unregistered Students yet</h3>
  <?php endif; ?>
  <br/>
  <?php if($regStudents): ?>
  <h3 class="title">Registered Students</h3>
    <table>
      <tr>
        <th>Student Id</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Course</th>
        <th>Assign to Staff</th>
      </tr>
    <?php foreach($regStudents as $s): ?>
      <tr>
        <td><?php echo $s->id; ?></td>
        <td><?php echo $s->firstName; ?></td>
        <td><?php echo $s->lastName; ?></td>
        <td><?php echo "ITEC $s->course"; ?></td>

        <!-- Assign Staff button -->
        <td>
          <a href="<?php echo "assignStaff.php?id=$s->id&course=$s->course"; ?>" class="btn"><i class="fas fa-user-plus"></i> Assign</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </table>
  <?php else: ?>
    <h3 class="title">No Registered Students yet</h3>
  <?php endif; ?>
</div>
<!-- TOAST MESSAGE -->
<div id="toast"><div id="desc"></div></div>
<!-- UI SCRIPT  -->
<script src="../js/ui.js"></script>
</body>
</html>
<?php
  // On Register click
  if(isset($_POST['register'])){
    // Get id 
    $id = $_POST['id'];
    // set id value
    $User->id = $id;
    // register student
    if($User->registerStudent()){
      echo "<script> launch_toast('Student Registered'); </script>";
    } else {
      echo "<script> launch_toast('Something Went Wrong'); </script>";
    }
    header('Refresh: 0');
    exit;
  }

  // On delete click
  if(isset($_POST['delete'])){
    // Get id 
    $id = $_POST['id'];
    // set id value
    $User->id = $id;
    // delete student
    if($User->deleteUser()){
      echo "<script> launch_toast('Student Deleted'); </script>";
    } else {
      echo "<script> launch_toast('Something Went Wrong'); </script>";
    }
    header('Refresh: 0');
    exit;
  }

?>