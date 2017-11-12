<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("location:login.php");
}
?>
<?php
  include("config.php");
  include("header.php");
  include("myprofileheader.php");
  include("myeventsheader.php");

?>

<?php
  include("footer.php");
?>
