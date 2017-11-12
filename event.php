<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("location:login.php");
}
?>
<?php
  include("config.php");
  include("header.php");

?>


<?php

displayEvent();

?>

<!--Comment form---------->

<section class='commentarea'>

<h2 class='commentheader'>Comments</h2>

<form action="" method="POST">

  <textarea class='registerbar' rows='4'  maxlength="200" name="commentfield"></textarea>

      <input type="submit" name="postcomment" class="commentbutton" value="Submit" />


</form>

<!--making and displaying comments (see functions.php for functionality)---------->

<?php

if (isset($_POST['postcomment']) && !empty($_POST['commentfield'])) {
  makeComment($_POST['commentfield']);
}

getComment();

?>
</section>

<script type="text/javascript" src="js/attendedmodal.js"></script>

<?php
  include("footer.php");
?>
