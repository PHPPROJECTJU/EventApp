<?php
session_start();
ob_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
}
?>

<!DOCTYPE html>
	  <html lang="en">
	  <head>
		    <meta charset="UTF-8">
	      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	      <link rel="stylesheet" href="css/main.css">
	      <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,600,700,900|Noto+Sans:300,400,700" rel="stylesheet">
	  </head>

<body id="notloggedin">
		<main id="main">

              <?php
                  session_destroy();
                  unset($_SESSION['username']);
              ?>
              <div class="logoutbox">
                <div class="logouttext">
                  You are now logged out.
                </div>
                <div class="logoutbuttonwrap">
                  <a href=login.php class="logoutbutton">Return to login page.</a>
                </div>
              </div>
              <br  />

              <footer class="logoutfooter">

                  
              </footer>


    </main>
</body>
<script type="text/javascript" src="js/menu.js"></script>
</html>
