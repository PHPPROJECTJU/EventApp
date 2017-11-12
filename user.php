<?php
  session_start();
?>
<?php
  include("config.php");
  include("header.php");
?>

<?php

#This page is for viewing other users

$UserID = trim($_GET['UserID']);

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $query = "SELECT User.UserName, User.Password, User.EmailAdress, User.FirstName, User.LastName, User.Birthdate, User.About, User.ProfilePicture
              FROM User
              WHERE UserID = $UserID
              ";


    $stmt = $db->prepare($query);
    $stmt->bind_result($UserName, $Password, $EmailAdress, $FirstName, $LastName, $Birthdate, $About, $ProfilePicture);
    $stmt->execute();

    while ($stmt->fetch()) {
        echo "<div class='userbox'>";
        echo "<img src='$ProfilePicture' id='personalprofilepic'/>";
        echo "</br><h3 class='personalusername'>$UserName</h3></br></br>";
        echo "Name:</br> $FirstName $LastName</br>";
        echo "</br>Birthdate:</br>$Birthdate</br>";
        echo "</br>Email:</br> $EmailAdress</br>";
        echo "</br>About:</br>$About</br>";
        echo "</br></br><a class='colorbutton' href='usersevent.php?UserID= " . urlencode($UserID) . " '>Hosted events</a>";
        echo "</div>";
    }

?>

<?php
  include("footer.php");
?>
