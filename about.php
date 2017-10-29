<?php
  session_start();
?>

<?php
  include("config.php");
  include("header.php");

  $myusername = $_SESSION['username'];


?>
<div id="whitecontent">

<div id="headerwrap">
  <div class="onwrap">
      <h2 class="aboutheader">Good to see you, <?php echo $myusername?>!</h2>
  </div>
</div>

<div class="about">
  <p>
    <h2>
    Welcome to Eventually!
    This is a web application where you can see events hosted nearby. Register and create an event you too. Eventually you'll get some new friends!
    </h2>
    <br>
    <br>
    <h3>FAQ</h3>

  </p>

  <br>
  <p><a href="contact.php">Contact us!</a></p>
</div>

<?php
  include("footer.php");
?>
</div>
