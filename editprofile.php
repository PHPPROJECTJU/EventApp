<?php
  session_start();
?>
<?php
  include("config.php");
  include("header.php");
  #Can't really make the min date work?
  $date = date('Y-m-d');
?>

<?php
    $username = $_SESSION['username'];

    include("config.php");

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
    echo "could not connect: " . $db->connect_error;
    printf("<br><a href=index.php>Return to home page </a>");
    exit();
    }

    $query = ("SELECT User.UserName, User.FirstName, User.LastName, User.Birthdate, User.About
              FROM User
              WHERE User.UserName = '{$username}'
              ");

    $stmt11 = $db->prepare($query);
    $stmt11->bind_result($showusername, $showfirstname, $showlastname, $showbirthdate, $showabout);
    $stmt11->execute();
    $stmt11->store_result();
    $stmt11->fetch();
?>

<form action="editprofile.php" method="POST" enctype="multipart/form-data">
  <table id="registerform">
    <tr>
      <td><h4 class="eventheaders">Firstname</h4>
        <input type="name" name="firstname" class="eventregisterbar" placeholder="<?php echo $showfirstname; ?>" />
      </td>
    </tr>
    <tr>
      <td><h4 class="eventheaders">Lastname</h4>
        <input type="name" name="lastname" class="eventregisterbar" placeholder="<?php echo $showlastname; ?>" />
      </td>
    </tr>
    <tr>
          <td>
              <p>Choose a profile picture:</p>
              <div class="fileUpload">
                <div class="uploadbuttondark">Upload</div>
                <input type="file" name="fileupload">
              </div>
                  <br/>
          </td>
    </tr>
    <tr>
        <td>
            <textarea type="text" name="about" class="eventregisterbar80" style="height: 100px;"><?php echo $showabout; ?></textarea>
        </td>
    </tr>
    <tr>
      <td><input type="submit" class="colorbutton" name="submit" value="Update profile"></td>
    </tr>
  </table>
</form>



<!--Same code as in create profile but changed INSERT into UPDATE and took away required message-->
 <?php

    if (isset($_POST['submit'])) {

    updatetheuser();
    }

    include ("footer.php");
 ?>
