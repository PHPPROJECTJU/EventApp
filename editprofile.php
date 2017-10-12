<?php
  include("config.php");
  include("header.php");
  #Can't really make the min date work?
  $date = date('Y-m-d');
?>

<!--Formfields should only be required if there is no input from before-->
<div id="createprofile">
    <form method="POST" name="createprofile" action="createprofile.php">
        <h1>User:<!--use php to get usr name--><br>Edit your profile</h1>
          <br>
          <input type="name" name="firstname" placeholder="Firstname"/>
          <br>
          <input type="name" name="lastname" placeholder="Lastname"/>
          <br>
          <input type="date" name="bday" min="<?php $date ?>"/>
          <br>

          <p>Upload your own profile picture:</p>
          <!--Don't really know how to fix this one, heh...-->
          <!--Uploaded pic should get the id of the usr that uploaded the pic and be displayed-->
          <input type="file" name="fileupload" id="fileupload">

          <h3>About me</h3>
          <textarea name="about" placeholder="Tell me something about yourself!"></textarea>
          <br>
          <input type="submit" name="submit" value="Update" />
    </form>
</div>

<?php
include ("footer.php");
 ?>

<!--Same code as in create profile but changed INSERT into UPDATE and took away required message-->
 <?php
/*
   #Checks if data has been submitted
   if (isset($_POST['username'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['bday'], $_POST['fileupload'], $_POST['about'])) {
   #Get data from form
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

       $stmt = $db->prepare("UPDATE User ('UserID', 'Username', 'Password', 'EmailAdress', 'FirstName', 'LastName', 'Birthdate', 'About', 'ProfilePicture')
                             VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?)");
       $stmt->bind_param('isssssiss', $Username, $Password, $FirstName, $LastName, $Email, $Bday, $ProfilePicture, $About);
       $stmt->execute();
       printf("<br>User added!");
       printf("<br><a href=index.php>Return to home page </a>");
     }
*/
 ?>
