<?php
  session_start();
?>
<?php
  include("config.php");
  include("header.php");

?>


<?php

displayEvent();

?>

<!--Comment form---------->

<h2 class='commentheader'>Comments</h2>

<form action="" method="POST">

  <textarea name="commentfield"></textarea>

      <input type="submit" name="postcomment" class="commentbutton" value="Submit" />


</form>

<!--making and displaying comments (see functions.php for functionality)---------->

<?php

if (isset($_POST['postcomment']) && !empty($_POST['commentfield'])) {
  makeComment($_POST['commentfield']);
}

getComment();

?>


<?php
  include("footer.php");
?>
