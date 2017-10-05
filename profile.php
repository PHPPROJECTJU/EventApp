<?php
  include("config.php");
  include("header.php");

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
        echo "Name:</br> $FirstName</br></br>Lastname:</br> $LastName</br></br>Birthdate:</br>$Birthdate</br></br>Username:</br>$UserName</br></br>Password:</br>$Password</br> $EmailAdress</br>   $About</br> $ProfilePicture";
        echo "</div>";
    }

?>


<a href="createprofile.php">Link to edit profile</a>

<?php
  include("footer.php");
?>
