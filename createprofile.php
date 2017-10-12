<?php
  session_start();
  if (!isset($_SESSION['username'])) {
    header("location:login.php");
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
  <form action="">
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
    #Checks if data has been submitted
    if (isset($_POST['submit'])) {
    #Get data from form
    $Username = addslashes($_POST['username']);
    $FirstName = addslashes($_POST['firstname']);
    $LastName = addslashes($_POST['lastname']);
    $Email = addslashes($_POST['email']);
    $Bday = addslashes($_POST['bday']);
    $ProfilePicture = addslashes($_POST['fileupload']);
    $About = addslashes($_POST['about']);


        $Username = trim($_POST['username']);
        $Password = sha1($_POST['password']);
        $FirstName = trim($_POST['firstname']);
        $LastName = trim($_POST['lastname']);
        $Email = trim($_POST['email']);
        $Bday = trim($_POST['bday']);
        $ProfilePicture = trim($_POST['fileupload']);
        $About = trim($_POST['about']);


  //--------------DATABASE CONNECTION--------------//
        @ $db = new mysqli('localhost', 'root', '', 'EventApp');

        if ($db->connect_error) {
            echo "could not connect: " . $db->connect_error;
            printf("<br><a href='index.php'>Return to home page </a>");
            exit();
        }
  //-----------------------------------------------//

        $stmt = $db->prepare("INSERT INTO User ('UserID', 'Username', 'Password', 'EmailAdress', 'FirstName', 'LastName', 'Birthdate', 'About', 'ProfilePicture')
                              VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('isssssiss', $Username, $Password, $FirstName, $LastName, $Email, $Bday, $About, $ProfilePicture);
        $stmt->execute();
        printf("<br>User added!");
        printf("<br><a href=index.php>Return to home page </a>");
      }
  ?>

</main>
