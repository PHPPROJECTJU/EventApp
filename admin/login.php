<?php
  ob_start();
  session_start();
  if (!isset($_SESSION['adminusername'])) {
    //header("location:login.php");
  }
?>

<?php
  include("config.php");
?>

<!DOCTYPE html>
	  <html lang="en">
	  <head>
		    <meta charset="UTF-8">
	      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	      <link rel="stylesheet" href="css/main.css">
	      <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans:300,400,600|Roboto:300,400,600,700" rel="stylesheet">
	  </head>

<!--PHP TERRITORY---------------->



<?php if(isset($_POST) && !empty($_POST)) : ?>

<?php

@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

if ($db->connect_error) {
  echo "could not connect: " . $db->connect_error;
  exit();
}

	$getusername =  stripslashes($_POST['getusername']);
	$getpassword =  stripslashes($_POST['getpassword']);

  $getusername = htmlentities($getusername);
  $getpassword = htmlentities($getpassword);

  $query = ("SELECT User.Admin FROM User WHERE UserName = '{$getusername}' "."AND Password = '{$getpassword}'");


  $stmt2 = $db->prepare($query);
  $stmt2->bind_result($isadmin);
  $stmt2->execute();
  $stmt2->store_result();

  $totalcount = $stmt2->num_rows();

  $stmt2->fetch();


?>

<?php endif;?>

<!--PHP TERRITORY end---------------->


	  <body>
		    <main class="red" id="main">

<div id="content">


    <div id="registerbox">

      <img src="img/eventually_admin.png" class="adminstartlogo"/>
        <form action="" method="POST">
          <table id="adminloginform">
            <tr>
              <td><input type="text" name="getusername" class="registerbar" placeholder="username" required></td>
            </tr>
            <tr>
              <td><input type="password" name="getpassword" class="registerbar" placeholder="password" required></td>
            </tr>
              <td><input type="submit" class="registerbutton" name="submit" value="Sign in"></td>
            </tr>
          </table>
        </form>

        <?php


        if (isset($totalcount)) {
              if ($totalcount == 0) {
                  echo "<p class='wrongpasstext'>Wrong username or password. Please try again.</p>";
                  session_destroy();

              } elseif ($isadmin == 0) {
                  echo "<p class='wrongpasstext'>Not an admin.</p>";
                  session_destroy();

              } else {
                $_SESSION['adminusername'] = $getusername;
                header("location:index.php");
              }
        }





         ?>

        <p class="already"><a href="../index.php" class="loginbutton">Go to main page</a></p>

    </div>

</div>

</main>
</body>
<script type="text/javascript" src="js/menu.js"></script>
</html>
