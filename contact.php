<?php
  include("config.php");
  include("header.php");

  session_start();
  if (!isset($_SESSION['username'])) {
    header("location:login.php");
  }
?>

<!--Idea is to send input to admin user e-mail-->
<form method="POST" name="contactform" action="contact.php">
  <div id="contactform">
      <h3>Contact Eventually</h3>
        <input type="name" name="name" placeholder="Name" required/>
        <input type="email" name="email" placeholder="E-Mail" required/>
        <textarea name="message" placeholder="Message"></textarea>
        <input type="submit" name="submit" value="Send" />
  </div>
</form>

<!--Some of the code below was taken from http://htmldog.com/techniques/formtoemail/ 2017-10-05-->

<?php

  $adminEmail = "paju1600@student.ju.se";

  if($_POST['submit']) {
      $to = $adminEmail;
      $subject = "Message from Eventually";
      $sender = $_POST["name"];
      $senderEmail = $_POST["email"];
      $message = $_POST["message"];

      $mailBody="Name: $sender\nEmail: $senderEmail\n\n$message";

      mail($to, $subject, $mailBody, "From: $sender <$senderEmail>");

      echo $thankYou="<p>Thank you! Your message has been sent.</p>";

  }

#This code should work but we suspect that you need to set up a mail server or have a published site
#Error, undefined index for submit, check this out!

  include("footer.php");
?>
