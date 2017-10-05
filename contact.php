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

<!--This code was taken from a thread 2017-10-05 https://stackoverflow.com/questions/20927980/using-html-and-php-to-send-form-data-to-an-email written by user Ferrakkem Bhuiyan-->

<?PHP
  $email = $_POST["email"];
  $to = "paju1600@student.ju.se";
  $subject = "New Email Address for Mailing List";
  $headers = "From: $email\n";
  $message = "A visitor to your site has sent the following message.\n";
  mail($to,$subject,$message,$headers);
?>
