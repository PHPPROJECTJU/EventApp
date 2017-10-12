<?php
  include("config.php");
  include("header.php");
  include("myprofileheader.php");
  include("myeventsheader.php");

  if (!isset($_SESSION['username'])) {
    header("login.php");
  }
?>

<?php
  include("footer.php");
?>
