<?php
  session_start();
?>
<?php
  include("config.php");
  include("header.php");
  include("myprofileheader.php");

?>

<?php

$username = $_SESSION['username'];


    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $query = "SELECT
              User.EmailAdress, User.FirstName, User.LastName, User.Birthdate, User.About, User.ProfilePicture
              FROM User
              WHERE User.UserName = '$username'
              ";


    $stmt = $db->prepare($query);
    $stmt->bind_result($EmailAdress, $FirstName, $LastName, $Birthdate, $About, $ProfilePicture);
    $stmt->execute();

    while ($stmt->fetch()) {
        echo "<div class='profilebox'>";
        echo "<img src='$ProfilePicture' id='personalprofilepic'/>";
        echo "</br><h3 class='personalusername'>$username</h3></br></br>";
        echo "Name:</br> $FirstName $LastName</br>";
        echo "</br>Birthdate:</br>$Birthdate</br>";
        echo "</br>Email:</br> $EmailAdress</br>";
        echo "</br>About:</br>$About</br>";
        echo "</br></br><a class='profilebutton' href='editprofile.php'>Edit profile</a>";
        echo "</div>";
    }

?>


<?php
  include("footer.php");
?>
