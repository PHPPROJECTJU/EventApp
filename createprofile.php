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
                <!--Don't really know how to fix this one, heh...-->
                <!--Uploaded pic should get the id of the user that uploaded the pic and be displayed-->

                    <input type="file" name="fileupload" id="fileupload">
                    <br />

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

  function finishtheuser(){
        include("config.php");

        @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

        if ($db->connect_error) {
            echo "could not connect: " . $db->connect_error;
            printf("<br><a href=index.php>Return to home page </a>");
            exit();
        }

        #Getting the image upload:
        if (isset($_FILES['fileupload'])) {

              $allowedextensions = array('jpg', 'jpeg', 'gif', 'png');

              $extension = strtolower(substr($_FILES['fileupload']['name'], strrpos($_FILES['fileupload']['name'], '.') + 1));

              $error = array ();

              if(in_array($extension, $allowedextensions) === false){
                $error[] = 'This is not an image, upload is allowed only for images.';
              }

              if($_FILES['fileupload']['size'] > 1000000){
                $error[]='The file exceeded the upload limit';
              }

              if(empty($error)){
                move_uploaded_file($_FILES['fileupload']['tmp_name'], "profilepics/{$_FILES['fileupload']['name']}");
              } else {
                  foreach ($error as $err){
                    echo $err;
                  }
              }

        } else {
          echo "not uploaded";
        }


        $UserID = $_SESSION['userid'];

        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $bday = trim($_POST['bday']);
        $fileupload = trim($_POST['fileupload']);
        $about = trim($_POST['about']);

        $firstname = addslashes($firstname);
        $lastname = addslashes($lastname);
        $bday = addslashes($bday);
        $fileupload = addslashes($fileupload);
        $about = addslashes($about);

        $stmt = $db->prepare("UPDATE User
                              SET FirstName='$firstname', LastName='$lastname', Birthdate='$bday', ProfilePicture='profilepics/$fileupload', About='$about'
                              WHERE UserID=$UserID");
        $stmt->bind_param('sssss', $firstname, $lastname, $bday, $fileupload, $about);
        $stmt->execute();
        printf("<p class='already'>Login with your new account!<a href='login.php' class='loginbutton'>Sign in</a></p><br>");
        //exit;
    }

  if (isset($_POST['submit'])) {

    finishtheuser();
  }

  ?>

</main>
