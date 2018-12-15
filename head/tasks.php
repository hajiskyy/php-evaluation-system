<?php 
if(isset($_SESSION['head'])){

    // INCLUDES
    include_once "../config/database.php";
    include_once "../models/Tasks.php";
  
    // Instantiate DB connection
    $db = new Database();
    $conn = $db->connect();
  
    // Instantiate Tasks Class
    $Tasks = new Tasks($conn);

    // get Tasks
    $tasks = $Tasks->getAllTasks();
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
  <title>Tasks</title>
</head>
<body>
  <!-- Side Nav -->
  <?php include "../helpers/head.php" ?>

  <!-- Main -->
<div class="main">
<a href="./addTask.php" class="main-btn btn"><i class="fas fa-plus"></i>  Add new</a>
  <!-- If staff exists -->
  <?php if($tasks): ?>
  <h3 class="title">Tasks</h3>
    <table>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Course</th>
        <th>Delete</th>
      </tr>
    <?php foreach($tasks as $t): ?>
      <tr>
        <td><?php echo $t->name; ?></td>
        <td><?php echo $t->description; ?></td>
        <td><?php echo "ITEC $t->course"; ?></td>

        <!-- Delete button -->
        <td>
          <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $t->id; ?>">
            <button type="submit" class="btn red" name="delete"><i class="fas fa-trash"></i>   delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </table>
  <?php else: ?>
    <h3 class="title">No Tasks Yet</h3>
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
    $Tasks->id = $id;
    // delete student
    if($Tasks->delete()){
      echo "<script> launch_toast('Tasks Deleted'); </script>";
    } else {
      echo "<script> launch_toast('Something Went Wrong'); </script>";
    }
    header('Refresh: 0');
    exit;
  }

?>