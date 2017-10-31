<?php
  session_start();
?>
<?php
  include("config.php");
  include("header.php");
?>

<?php

  $UserID = trim($_GET['UserID']);

  $query = "SELECT UserID
            FROM User
            WHERE User.UserID = '{$UserID}'
            ";

  $stmt9 = $db->prepare($query);
  $stmt9->bind_result($UserID);
  $stmt9->execute();
  $stmt9->store_result();
  $stmt9->fetch();


  getUsersEvents($UserID);
?>

<?php
  include("footer.php");
?>
