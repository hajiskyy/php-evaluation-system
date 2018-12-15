<?php 
  $student = $_SESSION['student'];
  $course = $_SESSION['course'];
?>
<nav>
  <span><?php echo "$student->firstName $student->lastName "; ?>| ID: <?php echo "$student->id"; ?></span>
  <a href="#"><?php echo "ITEC $course " ?>Project Manager</a>
</nav>
<div class="side-menu">
  <ul>
    <li><a href="./index.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
    <li><a href="./staffs.php" class="nav-link"><i class="fas fa-poll-h"></i> Grades</a></li>
    <li><a href="./profile.php" class="nav-link"><i class="fas fa-user"></i> Profile</a></li>
    <li><a href="./logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
  </ul>
</div>