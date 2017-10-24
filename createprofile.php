<?php
  session_start();
  if (!isset($_SESSION['username'])) {
    //header("location:login.php");
  }
?>
<?php
  include("config.php");
  #Can't really make the min date work?
  $date = date('Y-m-d');
?>

<!DOCTYPE html>
	  <html lang="en">
	  <head>
		    <meta charset="UTF-8">
	      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	      <link rel="stylesheet" href="css/main.css">
	      <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans:300,400,600|Roboto:300,400,600,700" rel="stylesheet">
	  </head>

<!--Formfields are required when creating user because all profiles should look the same-->
<main>
<div id="createprofile">
  <h1>Welcome!<br> Finish your profile</h1>
  <form action="index.php" method="POST">
    <table id="registerform">
      <tr>
        <td>
          <input type="name" name="firstname" class="registerbar" placeholder="Firstname" required/>
        </td>
      </tr>
      <tr>
        <td>
          <input type="name" name="lastname" class="registerbar" placeholder="Lastname" required/>
        </td>
      </tr>
      <tr>
        <td>
          <input type="date" name="bday" class="registerbar" placeholder="Birthdate" required/>
        </td>
      </tr>
      <tr>
            <td>
                <p>Choose a profile picture:</p>
                <!--Don't really know how to fix this one, heh...-->
                <!--Uploaded pic should get the id of the user that uploaded the pic and be displayed-->
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="file" name="fileupload" id="fileupload">
                    <br />
                </form>
            </td>
      </tr>
      <tr>
          <td>
              <textarea name="about" placeholder="Tell me something about yourself!" class="registerbar"></textarea>
          </td>
      </tr>
      <tr>
        <td><input type="submit" class="registerbutton" name="submit" value="Register"></td>
      </tr>
    </table>
  </form>
</div>

  </html>

  <?php
  if (isset($_POST['submit'])) {
      // This is the postback so add the book to the database
      # Get data from form
      $firstname = trim($_POST['firstname']);
      $lastname = trim($_POST['email']);
      $bday = trim($_POST['bday']);
      $fileupload = trim($_POST['fileupload']);
      $about = trim($_POST['about']);

      $firstname = addslashes($firstname);
      $lastname = addslashes($lastname);
      $bday = addslashes($bday);
      $fileupload = addslashes($fileupload);
      $about = addslashes($about);

      # Open the database using the "librarian" account
  @ $db = new mysqli('localhost', 'root', '', 'EventApp');

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      // Prepare an insert statement and execute it
      $stmt = $db->prepare("UPDATE User SET FirstName='$firstname', LastName='$lastname', Birthdate='$bday', ProfilePicture='$fileupload', About='$about' WHERE UserID=13");
      $stmt->bind_param('sssss', $firstname, $lastname, $bday, $fileupload, $about);
      $stmt->execute();
      printf("<br><br><br><br>Congratulations!<br>You have now created your Eventually-account.");
      //exit;
  }

  // Not a postback, so present the book entry form
  ?>

</main>
