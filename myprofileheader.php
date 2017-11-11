<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("location:login.php");
}
?>
<header id="myprofileheader">
    <nav id="profileorevents">
        <ul>
            <li><a id="<?php echo ($current_page == 'profile.php') ? 'active' : NULL ?>" href="profile.php">View profile</a></li>
            <li><a id="<?php echo ($current_page == 'hostedevents.php') ? 'active' : NULL ?>" href="hostedevents.php">My events</a></li>
        </ul>
    </nav>
</header>
