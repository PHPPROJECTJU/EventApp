<?php
  include("config.php");
  include("header.php");
  include("myprofileheader.php");

  if (!isset($_SESSION['username'])) {
    header("login.php");
  }
?>

<?php
    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $query = "SELECT User.UserName, User.Password, User.EmailAdress, User.FirstName, User.LastName, User.Birthdate, User.About, User.ProfilePicture
              FROM User";


    $stmt = $db->prepare($query);
    $stmt->bind_result($UserName, $Password, $EmailAdress, $FirstName, $LastName, $Birthdate, $About, $ProfilePicture);
    $stmt->execute();

    while ($stmt->fetch()) {
        echo "<div class='profilebox'>";
        echo "<img src='$ProfilePicture' id='personalprofilepic'/>";
        echo "</br><h3 class='personalusername'>$UserName</h3></br></br>";
        echo "Name:</br> $FirstName $LastName</br>";
        echo "</br>Birthdate:</br>$Birthdate</br>";
        echo "</br>Email:</br> $EmailAdress</br>";
        echo "</br>About:</br>$About</br>";
        echo "</br></br><a class='profilebutton' href='editprofile.php'>Link to edit profile</a>";
        echo "</div>";
    }

?>
<a href="createprofile.php">Link to create profile</a>
<a href="editprofile.php">Link to edit profile</a>

<?php
  include("footer.php");
?>
