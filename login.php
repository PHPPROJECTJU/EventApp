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

  session_start();

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
        if (sha1($getpassword) == $password)
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
              <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit</p>
          </div>
      </div>

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

    </div>

</div>

</main>
</body>
<script type="text/javascript" src="js/menu.js"></script>
</html>
