<?php
  session_start();
?>
<?php
  include("config.php");
  include("header.php");
  #Can't really make the min date work?
  $date = date('Y-m-d');
?>

<!--Formfields should only be required if there is no input from before-->
<form action="editprofile.php" method="POST" enctype="multipart/form-data">
  <table id="registerform">
    <tr>
      <td>
        <input type="name" name="username" class="registerbar" placeholder="Username"/>
      </td>
    </tr>
    <tr>
      <td>
        <input type="name" name="password" class="registerbar" placeholder="Password"/>
      </td>
    </tr>
    <tr>
      <td>
        <input type="name" name="firstname" class="registerbar" placeholder="Firstname" />
      </td>
    </tr>
    <tr>
      <td>
        <input type="name" name="lastname" class="registerbar" placeholder="Lastname" />
      </td>
    </tr>
    <tr>
      <td>
        <input type="date" name="bday" class="registerbar" placeholder="Birthdate" />
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
      <td><input type="submit" class="registerbutton" name="submit" value="Register"></td>
    </tr>
  </table>
</form>



<!--Same code as in create profile but changed INSERT into UPDATE and took away required message-->
 <?php

function updatetheuser(){
 include("config.php");

 @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

 if ($db->connect_error) {
     echo "could not connect: " . $db->connect_error;
     printf("<br><a href=index.php>Return to home page </a>");
     exit();
 }

 $sessionuser = $_SESSION['username'];

 #Getting the image upload:
 if (isset($_FILES['fileupload'])) {

       $allowedextensions = array('jpg', 'jpeg', 'gif', 'png');

       $extension = strtolower(substr($_FILES['fileupload']['name'], strrpos($_FILES['fileupload']['name'], '.') + 1));

       $error = array ();

       if(in_array($extension, $allowedextensions) === false){
         $error[] = 'Not an allowed file format.';
       }

       if($_FILES['fileupload']['size'] > 1000000){
         $error[]='This file is over the 1MB limit.';
       }

       if(empty($error)){
         move_uploaded_file($_FILES['fileupload']['tmp_name'], "profilepics/user$UserID.$extension");
       } else {
           foreach ($error as $err){
             echo $err;
           }
       }
 } else {
   echo "not uploaded";
 }

 $Username = trim($_POST['username']);
 $Password = trim($_POST['password']);
 $firstname = trim($_POST['firstname']);
 $lastname = trim($_POST['lastname']);
 $bday = trim($_POST['bday']);
 $fileupload = "user".$UserID.".".$extension;
 $about = trim($_POST['about']);

 $Username = addslashes($Username);
 $Password = addslashes($Password);
 $firstname = addslashes($firstname);
 $lastname = addslashes($lastname);
 $bday = addslashes($bday);
 $fileupload = addslashes($fileupload);
 $about = addslashes($about);

 $stmt = $db->prepare("UPDATE User
                       SET UserName='$Username', Password='$Password', FirstName='$firstname', LastName='$lastname', Birthdate='$bday', ProfilePicture='profilepics/$fileupload', About='$about'
                       WHERE User.UserName=$username");
 $stmt->bind_param('sssssss', $Username, $Password, $firstname, $lastname, $bday, $fileupload, $about);
 $stmt->execute();

 ?>

 <script type="text/javascript" src="js/index.js"></script>
 <script>
     window.location.href = "index.php";
 </script>
 <?php
}

    if (isset($_POST['submit'])) {

    updatetheuser();
    }

    include ("footer.php");
 ?>
