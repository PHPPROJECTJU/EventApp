<?php
  ob_start();
  session_start();
?>

<?php
  include("../config.php");
  include("../functions.php");
  include("adminfunction.php");
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

<div>


    <div id="registerbox">

      <img src="img/eventually_admin.png" class="startlogo"/>

        <form action="" method="POST">
          <table id="registerform">
            <tr>
              <td><input type="text" name="getusername" class="registerbar" placeholder="Username" required></td>
            </tr>
            <tr>
              <td><input type="password" name="getpassword" class="registerbar" placeholder="Password" required></td>
            </tr>
              <td><input type="submit" class="signinbutton" name="submit" value="     Sign in"></td>
            </tr>
          </table>
        </form>

        <?php if(isset($_POST) && !empty($_POST)) {

          adminlogin();

          }
         ?>

        <p class="already">Not an admin? <a href="../index.php" class="transparentbutton">Go to main page</a></p>

    </div>

</div>

</main>
</body>
<script type="text/javascript" src="js/menu.js"></script>
</html>
