<?php
  include("config.php");
  include("functions.php");

  ob_start();
?>

<!DOCTYPE html>
	  <html lang="en">
	  <head>
		    <meta charset="UTF-8">
	      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	      <link rel="stylesheet" href="css/main.css">
	      <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans:300,400,600|Roboto:300,400,600,700" rel="stylesheet">
	  </head>

	  <body>
		    <main class="red" id="main">

<div>

      <div id="aboutbutton" onclick="showAbout()">About</div>
      <div id="aboutBox">
          <div class="arrow"></div>
          <div id="about">
              <p>Welcome to Eventually!<br>This is a web application where you can see events hosted nearby. Register and create an event you too. Eventually you'll get some new friend!</p>
          </div>
      </div>
        <img src="img/event_ually.png" class="startlogo"/>

        <form action="register.php" method="POST">
          <table id="registerform">
            <tr>
              <td><input type="text" name="username" class="registerbar" placeholder="Username" required></td>
            </tr>
            <tr>
              <td><input type="text" name="email" class="registerbar" placeholder="E-mail address" required></td>
            </tr>
            <tr>
              <td><input type="password" name="password" class="registerbar" placeholder="Password" required></td>
            </tr>
            <tr>
              <td><input type="password" name="repeatpassword" class="registerbar" placeholder="Repeat password" required></td>
            </tr>
              <td><input type="submit" class="registerbutton" name="submit" value="Register"></td>
            </tr>
          </table>
        </form>

              <p class="already">Already registered? <a href="login.php" class="loginbutton">Sign in</a></p>

    </div>

    <?php
    if (isset($_POST['submit'])) {

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $repeatpassword = trim($_POST['repeatpassword']);

        $username = addslashes($username);
        $email = addslashes($email);
        $password = addslashes($password);
        $repeatpassword = addslashes($repeatpassword);

        checkUsername();

        if ($repeatpassword != $password){
          echo "Passwords don't match";
          exit();
        }


    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

        if ($db->connect_error) {
            echo "could not connect: " . $db->connect_error;
            printf("<br><a href=index.php>Return to home page </a>");
            exit();
        }

        $stmt = $db->prepare("INSERT INTO User (User.Username, User.EmailAdress, User.Password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $email, $password);
        $stmt->execute();
        $stmt->close();

        session_start();

        $UserID = mysqli_insert_id($db);
        $_SESSION['userid'] = $UserID;


        printf("<br><br><br><br>User Added!");
        $_SESSION['username'] = $username;
        header("location:createprofile.php");
        //exit;
    }

    ?>

</main>
</body>
<script type="text/javascript" src="js/menu.js"></script>
</html>
