<?php
  session_start();
?>
<?php
  include("config.php");
  include("header.php");

?>


<?php

adminDisplayEvent();

?>

<!--Comment area---------->

<section class='commentarea'>

<h2 class='commentheader'>Comments</h2>


<!--making and displaying comments (see functions.php for functionality)---------->

<?php


adminGetComment();

?>
</section>

<script type="text/javascript" src="js/attendedmodal.js"></script>

<?php
  include("footer.php");
?>
