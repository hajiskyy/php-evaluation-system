<?php 
  $staff = $_SESSION['staff'];
  $course = $_SESSION['course'];
?>
<nav>
  <span><?php echo "$staff->firstName $staff->lastName "; ?>| ID: <?php echo "$staff->id"; ?></span>
  <a href="./index.php"><?php echo "ITEC $course " ?>Project Manager</a>
</nav>
<div class="side-menu">
  <ul>
    <li><a href="./index.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
    <li><a href="./students.php" class="nav-link"><i class="fas fa-users"></i> Students</a></li>
    <li><a href="./attendance.php" class="nav-link"><i class="far fa-check-square"></i> Attendance</a></li>
    <li><a href="./profile.php" class="nav-link"><i class="fas fa-user"></i> Profile</a></li>
    <li><a href="./logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
  </ul>
</div>