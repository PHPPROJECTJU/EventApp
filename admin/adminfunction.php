<?php
function adminlogin(){

  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  if ($db->connect_error) {
  echo "could not connect: " . $db->connect_error;
  exit();
  }

  $getusername =  stripslashes($_POST['getusername']);
  $getpassword =  stripslashes($_POST['getpassword']);

  $getusername = htmlentities($getusername);
  $getpassword = htmlentities($getpassword);

  $query = "SELECT User.Password, User.Admin
            FROM User
            WHERE User.UserName = '{$getusername}'
            ";

            $stmt2 = $db->prepare($query);
            $stmt2->bind_result($hashedpassword, $isadmin);
            $stmt2->execute();
            $stmt2->store_result();

            $totalcount = $stmt2->num_rows();

            $stmt2->fetch();

            if(password_verify($getpassword, $hashedpassword) AND ($isadmin == 1)) {
                $_SESSION['adminusername'] = $getusername;
                header("location:index.php");
            } elseif (!password_verify($getpassword, $hashedpassword)) {
              echo "<p class='wrongpasstext'>Wrong username or password. Please try again.</p>";
            } elseif ($isadmin == 0) {
              echo "<p class='wrongpasstext'>User is not an admin</p>";
            }


}

?>
