<?php
  if(isset($_SESSION['student'])){
    // INCLUDES
    include_once "../config/database.php";
    include_once "../models/Tasks.php";
    include_once "../models/Submissions.php";

    // Get course from session
    $course = $_SESSION['course'];
    // Get course from session
    $student = $_SESSION['student'];
    
    // Instantiate DB connection
    $db = new Database();
    $conn = $db->connect();
    
    // Instantiate Task Class
    $Tasks = new Tasks($conn);
    // Instantiate Submission Class
    $Submission = new Submissions($conn);
  
    // set task course
    $Tasks->course = $course;
    // set submission props
    $Submission->course = $course;
    $Submission->studentId = $student->id;
    

    // get tasks
    $tasks = $Tasks->getTaskbyCourse();
    // get submissions
    $submissions = $Submission->getStudentSubmission();

    $filtered = array();

      // Loop tasks to find submitted
    foreach ($tasks as $t) {
      $t = (array)$t;
      $t['submitted'] = FALSE;
      $t = (object)$t;
      array_push($filtered, $t);

      // fi submissions exist
      if($submissions){
        // inner loop submissions
        foreach ($submissions as $s) {
          // find tasks submitted by student
          if($t->id == $s->task_id ){
            array_pop($filtered);
            $t = (array)$t;
            $t['submitted'] = TRUE;
            $t = (object)$t;
            array_push($filtered, $t);
          }
        }
      }
    }

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
<!-- Side nav -->
<?php include "../helpers/student.php"; ?>
<!-- Main content -->
<div class="main">
  <!-- If tasks exist -->
  <?php if($filtered): ?>
    <h3 class="title">Tasks</h3>
    <table>
      <tr>
        <th>Task Name</th>
        <th>Description</th>
        <th>Date Due</th>
        <th>Submit</th>
      </tr>
      <?php foreach($filtered as $t):?>
      <tr>
        <td><?php echo $t->name; ?></td>
        <td><?php echo $t->description; ?></td>
        <td><?php echo $t->due; ?></td>
        <td>
        <!-- If submitted show resubmit button -->
          <?php if($t->submitted): ?>
            <form action="" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo $t->id;?>">
              <input type="hidden" name="name" value="<?php echo $t->name;?>">
              <input type="file" name="file" id="<?php echo $t->id;?>" style="display: none;"
              onchange="document.getElementById('resubmit<?php echo $t->id;?>').click()">

              <button type="button" class="btn yellow" 
              onclick="document.getElementById('<?php echo $t->id;?>').click()">
              <i class="fas fa-upload"></i > reupload</button>

              <button type="submit" id="resubmit<?php echo $t->id;?>" name="reupload" class="btn yellow" style="display: none;">Upload</button>
            </form>
          <?php else: ?>
            <form action="" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo $t->id;?>">
              <input type="hidden" name="name" value="<?php echo $t->name;?>">
              <input type="file" name="file" id="<?php echo $t->id;?>" style="display: none;"
              onchange="document.getElementById('submit<?php echo $t->id;?>').click()">

              <button type="button" class="btn green" 
              onclick="document.getElementById('<?php echo $t->id;?>').click()">
              <i class="fas fa-upload"></i > upload</button>

              <button type="submit" id="submit<?php echo $t->id;?>" name="upload" class="btn green" style="display: none;">Upload</button>
            </form>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach;?>
    </table>
  <?php else:?>
    <h3 class="title">No Tasks Yet</h3>
  <?php endif;?>
  
</div>
<!-- TOAST MESSAGE -->
<div id="toast"><div id="desc"></div></div>
<!-- UI SCRIPT  -->
<script src="../js/ui.js"></script>
</body>
</html>

<?php
if(isset($_POST['upload'])){
  $task_id = $_POST['id'];
  $task_name = $_POST['name'];
 
  $file_name = basename($_FILES['file']['name']);
  $file_loc = $_FILES['file']['tmp_name'];
  // $file_size = $_FILES['file']['size'];
  // $file_type = $_FILES['file']['type'];

  //set folder path
  $folder="uploads/$course/$student->id/$task_name/";

  //Create folder
  if(!is_dir($folder)){
   mkdir("../".$folder,0777,true);
  }
  
  //upload the file
  if(move_uploaded_file($file_loc,"../".$folder.$file_name)){
      // map path to filename
      $path = $folder.$file_name;
      // set submission variables
      $Submission->path = $path;
      $Submission->course = $course;
      $Submission->studentId = $student->id;
      $Submission->taskId = $task_id;
      $Submission->taskName = $task_name;

      if($Submission->create()){
        echo "<script> launch_toast('Upload Successfull); </script>";
      } else {
        echo "<script> launch_toast('Somthing Went wrong'); </script>";
      }
      header('Refresh: 0');
      exit;
  } else {
    echo "<script> launch_toast('Upload Failed'); </script>";
  }
}

// On ReUpload
if(isset($_POST['reupload'])){

  $task_id = $_POST['id'];
  $task_name = $_POST['name'];
 
  $file_name = basename($_FILES['file']['name']);
  $file_loc = $_FILES['file']['tmp_name'];
  // $file_size = $_FILES['file']['size'];
  // $file_type = $_FILES['file']['type'];

  //set folder path
  $folder="uploads/$course/$student->id/$task_name/";

  $files = glob("../".$folder. '*', GLOB_MARK);
  foreach ($files as $file) {
      if (is_dir($file)) {
          self::deleteDir($file);
      } else {
          unlink($file);
      }
  }

  //upload the file
  if(move_uploaded_file($file_loc,"../".$folder.$file_name)){
      // map path to filename
      $path = $folder.$file_name;
      // set submission variables
      $Submission->path = $path;
      $Submission->course = $course;
      $Submission->studentId = $student->id;
      $Submission->taskId = $task_id;

      if($Submission->update()){
        echo "<script> launch_toast('Re Upload Successfull); </script>";
      } else {
        echo "<script> launch_toast('Somthing Went wrong'); </script>";
      }

  } else {
    echo "<script> launch_toast('Upload Failed'); </script>";
  }


}
?>