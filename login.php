<?php
  ob_start();
  session_start();
  if (!isset($_SESSION['username'])) {
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

<!--username: testuser. password: testing-->

<?php if(isset($_POST) && !empty($_POST)) : ?>

<?php

	$getusername =  stripslashes($_POST['getusername']);
	$getpassword =  stripslashes($_POST['getpassword']);


	@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

	if ($db->connect_error) {
		echo "could not connect: " . $db->connect_error;
		exit();
	}

	$stmt = $db->prepare("SELECT UserName, Password FROM User WHERE UserName = ?");
	$stmt->bind_param('s', $getusername);
	$stmt->execute();

    $stmt->bind_result($username, $password);


    while ($stmt->fetch()) {
        if ($getpassword == $password)
		{
			$_SESSION['username'] = $getusername;
			header("location:index.php");
			exit();
		}
    }


?>

<?php endif;?>

<!--PHP TERRITORY end---------------->


	  <body>
		    <main class="red" id="main">

<div id="content">


    <div id="registerbox">
      <div id="aboutbutton" onclick="showAbout()">About</div>
      <div id="aboutBox">
          <div class="arrow"></div>
          <div id="about">
              <p>Welcome to Eventually!<br>This is a web application where you can see events hosted nearby. Register and create an event you too. Eventually you'll get some new friend!</p>
          </div>
      </div>
      <img src="img/event_ually.png" class="startlogo"/>
        <form action="" method="POST">
          <table id="registerform">
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
        <p class="already">Not a member? <a href="register.php" class="loginbutton">Register here</a></p>

    </div>

</div>

</main>
</body>
<script type="text/javascript" src="js/menu.js"></script>
</html>
