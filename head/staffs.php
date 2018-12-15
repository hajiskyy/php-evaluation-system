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

    // get Staffs
    $staffs = $User->getAllStaff();
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
  <h3 class="title">Staffs</h3>
<a href="./accounts.php" class="main-btn btn"><i class="fas fa-plus"></i>  Add new</a>
  <!-- If staff exists -->
  <?php if($staffs): ?>
    <table>
      <tr>
        <th>Staff Id</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Course</th>
        <th>Evaluation</th>
        <th>Delete</th>
      </tr>
    <?php foreach($staffs as $s): ?>
      <tr>
        <td><?php echo $s->id; ?></td>
        <td><?php echo $s->firstName; ?></td>
        <td><?php echo $s->lastName; ?></td>
        <td><?php echo "ITEC $s->course"; ?></td>

        <!-- Assign Evaluation -->
        <td>
          <a href="<?php echo "assignEval.php?id=$s->id&course=$s->course"; ?>" class="btn"><i class="fas fa-user-plus"></i> Assign</a>
        </td>

        <!-- Delete button -->
        <td>
          <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $s->id; ?>">
            <button type="submit" class="btn red" name="delete"><i class="fas fa-trash"></i>   delete</button>
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
  if(isset($_POST['delete'])){
    // Get id 
    $id = $_POST['id'];
    // set id value
    $User->id = $id;
    // delete student
    if($User->deleteUser()){
      echo "<script> launch_toast('Staff Deleted'); </script>";
    } else {
      echo "<script> launch_toast('Something Went Wrong'); </script>";
    }
    header('Refresh: 0');
    exit;
  }

?>