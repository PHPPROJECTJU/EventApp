<?php
  session_start();
  if (!isset($_SESSION['username'])) {
    header("location:login.php");
  }
?>
<?php
  include("config.php");
  include("functions.php");

  #Can't really make the min date work?
  $date = date('Y-m-d');
?>

<!DOCTYPE html>
	  <html lang="en">
	  <head>
		    <meta charset="UTF-8">
	      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	      <link rel="stylesheet" href="css/main.css">
	      <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,600,700,900|Noto+Sans:300,400,700" rel="stylesheet">
	  </head>

<!--Formfields are required when creating user because all profiles should look the same-->
<body id="notloggedin">

<main>
<div id="createprofile">
  <h2 id="pageheader">Welcome!<br> Finish your profile</h2>
  <form action="createprofile.php" method="POST" enctype="multipart/form-data">
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
                    <div class="fileUpload">
                      <div class="uploadbutton">Upload</div>
                      <input type="file" name="fileupload">
                    </div>


            </td>
      </tr>
      <tr>
          <td>
              <textarea name="about" placeholder="Tell me something about yourself!" class="registerbar"></textarea>
          </td>
      </tr>
      <tr>
        <td><input type="submit" class="blockbutton" name="submit" value="Register"></td>
      </tr>
    </table>
  </form>
</div>

  </html>

  <?php

  if (isset($_POST['submit'])) {

    finishtheuser();
  }

  ?>

</main>
</body>
