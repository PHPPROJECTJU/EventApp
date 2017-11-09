<?php
  session_start();
?>
<?php
  include("config.php");
  include("header.php");
?>

<!--Idea is to send input to admin user e-mail-->
<?php

$username = $_SESSION['username'];

include("config.php");

@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

if ($db->connect_error) {
echo "could not connect: " . $db->connect_error;
printf("<br><a href=index.php>Return to home page </a>");
exit();
}

$query = "SELECT User.EmailAdress
          FROM User
          WHERE User.UserName = '{$username}'
          ";

$stmt = $db->prepare($query);
$stmt->bind_result($email);
$stmt->execute();
$stmt->store_result();
$stmt->fetch();

?>

<div id="headerwrap">
      <h2 id="aboutheader">Send us a message</h2>
</div>

<form method="POST" name="contactform" action="contact.php">

  <table id="contactform">
    <tr>
      <td><input type="text" name="username" class="registerbar" value="<?php echo $username; ?>" required></td>
    </tr>
    <tr>
      <td><input type="text" name="email" class="registerbar" value="<?php echo $email; ?>" required></td>
    </tr>
    <tr>
      <td><textarea name="message" class="registerbar" placeholder="Message"></textarea></td>
    </tr>
    <tr>
      <td><input type="submit" class="colorblockbutton" name="submit" value="Send"></td>
    </tr>
  </table>

</form>



<!--Some of the code below was taken from http://htmldog.com/techniques/formtoemail/ 2017-10-05-->

<?php

  $adminEmail = "paju1600@student.ju.se";

  if (isset($_POST['submit'])) {
      $to = $adminEmail;
      $subject = "Message from Eventually";
      $sender = $_POST["username"];
      $senderEmail = $_POST["email"];
      $message = $_POST["message"];

      $mailBody="Name: $sender\nEmail: $senderEmail\n\n$message";

      mail($to, $subject, $mailBody, "From: $sender <$senderEmail>");

      echo $thankYou="<p>Thank you! Your message has been sent.</p>";

  }

#This code should work but we suspect that you need to set up a mail server or have a published site

  include("footer.php");
?>
