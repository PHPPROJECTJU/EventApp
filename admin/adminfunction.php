<?php
function adminlogin(){

  include("../config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  if ($db->connect_error) {
  echo "could not connect: " . $db->connect_error;
  exit();
  }

  $getusername =  stripslashes($_POST['getusername']);
  $getpassword =  stripslashes($_POST['getpassword']);

  $getusername = htmlentities($getusername);
  $getpassword = htmlentities($getpassword);

  $query = "SELECT User.Password
            FROM User
            WHERE User.UserName = '{$getusername}'
            ";

            $stmt2 = $db->prepare($query);
            $stmt2->bind_result($hashedpassword);
            $stmt2->execute();
            $stmt2->store_result();

            $totalcount = $stmt2->num_rows();

            $stmt2->fetch();

            if(password_verify($getpassword, $hashedpassword)) {
              $_SESSION['adminusername'] = $getusername;
              header("location:index.php");
            } else {
              echo "<p class='wrongpasstext'>Wrong username or password. Please try again.</p>";
            }

}

?>
