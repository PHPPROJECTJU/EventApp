<?php
  session_start();
  if (!isset($_SESSION['adminusername'])) {
    header("location:login.php");
  }
?>

<?php
  include("config.php");
  include("header.php");

?>




<?php
  include("footer.php");
?>
