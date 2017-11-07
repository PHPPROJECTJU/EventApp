<?php
  ob_start();
  session_start();
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
	      <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,600,700,900|Noto+Sans:300,400,700" rel="stylesheet">
	  </head>

<!--PHP TERRITORY---------------->
<?php

function login(){
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
                $_SESSION['username'] = $getusername;
                header("location:index.php");
              } else {
                echo "<p class='wrongpasstext'>Wrong username or password. Please try again.</p>";
              }

}

?>


<!--PHP TERRITORY end---------------->


	  <body id="notloggedin">
		    <main id="main">

<div>


    <div id="registerbox">
      <div id="aboutbutton" onclick="showAbout()">About</div>
      <div id="aboutBox">
          <div class="arrow"></div>
          <div id="about">
              <p><b>Welcome to Eventually!</b><br>This is a web application where you can see events hosted nearby. Register and create an event you too. Eventually you'll get some new friends!</p>
          </div>
      </div>
      <img src="img/event_ually.png" class="startlogo"/>

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

          login();

          }
         ?>

        <p class="already">Not a member? <a href="register.php" class="transparentbutton">Register here</a></p>

    </div>

</div>

</main>
</body>
<script type="text/javascript" src="js/menu.js"></script>
</html>
