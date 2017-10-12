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

<!--formfields should only be required if there is no input from before-->
<div id="createprofile">
    <form method="POST" name="createprofile" action="createprofile.php">
        <h1>Welcome!<br> Create your profile</h1>
          <br>
          <input type="name" name="username" placeholder="Username" required/>
          <br>
          <input type="name" name="password" placeholder="Password" required/>
          <br>
          <input type="name" name="firstname" placeholder="Firstname" required/>
          <br>
          <input type="name" name="lastname" placeholder="Lastname" required/>
          <br>
          <input type="name" name="email" placeholder="Email" required/>
          <br>
          <input type="date" name="bday" min="<?php $date ?>" required/>
          <br>

          <p>Choose a profile picture:</p>
          <!--Don't really know how to fix this one, heh...-->
          <!--Uploaded pic should get the id of the user that uploaded the pic and be displayed-->
          <form action="" method="POST" enctype="multipart/form-data">
              <input type="file" name="fileupload" id="fileupload">
              <br />
          </form>

          <h3>About me</h3>
          <textarea name="about" placeholder="Tell me something about yourself!"></textarea>
          <br>
          <input type="submit" name="submit" value="Submit" />
    </form>
</div>

</html>

<?php

  if (isset($_POST['username'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['bday'], $_POST['fileupload'], $_POST['about'])) {
  # Get data from form
      $Username = trim($_POST['username']);
      $Password = sha1($_POST['password']);
      $FirstName = trim($_POST['firstname']);
      $LastName = trim($_POST['lastname']);
      $Email = trim($_POST['email']);
      $Bday = trim($_POST['bday']);
      $ProfilePicture = trim($_POST['fileupload']);
      $About = trim($_POST['about']);


      if (!$Username || !$password || !$FirstName || !$LastName || !$Email || !$Bday || !$ProfilePicture || !$About) {
        printf("You must fill in all fields in order to create your profile.");
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
      }
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
      $stmt->bind_param('isssssiss', $Username, $Password, $FirstName, $LastName, $Email, $Bday, $ProfilePicture, $About);
      $stmt->execute();
      printf("<br>User added!");
      printf("<br><a href=index.php>Return to home page </a>");
    }
?>
