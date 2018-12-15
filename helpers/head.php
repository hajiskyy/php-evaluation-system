<?php 
  $head = $_SESSION['head'];
?>
<nav>
  <span><?php echo "$head->firstName $head->lastName "; ?>| ID: <?php echo "$head->id"; ?></span>
  <a href="#">Project Manager</a>
</nav>
<div class="side-menu">
  <ul>
    <li><a href="./index.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
    <li><a href="./tasks.php" class="nav-link"><i class="fas fa-tasks"></i> Tasks</a></li>
    <li><a href="./staffs.php" class="nav-link"><i class="fas fa-users"></i> Staffs</a></li>
    <li><a href="./profile.php" class="nav-link"><i class="fas fa-user"></i> Profile</a></li>
    <li><a href="./logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
  </ul>
</div>