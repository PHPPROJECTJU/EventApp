<?php
  include("config.php");
  include("header.php");

?>

<form method="POST" name="contactform" action="contact.php">
  <div id="contactform">
      <h3>Contact Eventually</h3>
        <input type="name" name="name" placeholder="Name" required/>
        <input type="email" name="email" placeholder="E-Mail" required/>
        <textarea name="textarea" placeholder="Message"></textarea>
        <input type="submit" value="Send" />
  </div>
</form>

<?php
  include("footer.php");
?>
