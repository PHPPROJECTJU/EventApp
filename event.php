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
  <div id="logoutbox">
    <div id="logoutbuttonwrap">
      <input type="submit" name="postcomment" class="loginbutton" />
    </div>
  </div>

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
