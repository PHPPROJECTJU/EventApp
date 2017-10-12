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

	  <body>
		    <main class="red" id="main">

<div id="content">

      <div id="aboutbutton" onclick="showAbout()">About</div>
      <div id="aboutBox">
          <div class="arrow"></div>
          <div id="about">
              <p>Welcome to Eventually!<br>This is a web application where you can see events hosted nearby. Register and create an event you too. Eventually you'll get some new friend!</p>
          </div>
      </div>
        <img src="img/event_ually.png" class="startlogo"/>

        <form action="">
          <table id="registerform">
            <tr>
              <td><input type="text" name="username" class="registerbar" placeholder="Username" required></td>
            </tr>
            <tr>
              <td><input type="text" name="username" class="registerbar" placeholder="E-mail address" required></td>
            </tr>
            <tr>
              <td><input type="password" name="password" class="registerbar" placeholder="Password" required></td>
            </tr>
            <tr>
              <td><input type="password" name="password" class="registerbar" placeholder="Repeat password" required></td>
            </tr>
              <td><input type="submit" class="registerbutton" name="submit" value="Register"></td>
            </tr>
          </table>
        </form>

              <p class="already">Already registered? <a href="login.php" class="loginbutton">Sign in</a></p>

    </div>

    <?php
    if (isset($_POST['newbooktitle'])) {
        // This is the postback so add the book to the database
        # Get data from form
        $newbooktitle = trim($_POST['newbooktitle']);
        $newbookauthor = trim($_POST['newbookauthor']);
        $newisbn = trim($_POST['newisbn']);

        if (!$newbooktitle || !$newbookauthor || !$newisbn) {
            printf("You must specify title, an author and isbn number!");
            printf("<br><a href=index.php>Return to home page </a>");
            exit();
        }

        $newbooktitle = addslashes($newbooktitle);
        $newbookauthor = addslashes($newbookauthor);
        $newisbn = addslashes($newisbn);

        # Open the database using the "librarian" account
    @ $db = new mysqli('localhost', 'root', '', 'EventApp');

        if ($db->connect_error) {
            echo "could not connect: " . $db->connect_error;
            printf("<br><a href=index.php>Return to home page </a>");
            exit();
        }

        // Prepare an insert statement and execute it
        $stmt = $db->prepare("INSERT INTO User VALUES (null, ?, ?, ?, false)");
        $stmt->bind_param('sss', $newbooktitle, $newbookauthor, $newisbn);
        $stmt->execute();
        printf("<br><br><br><br>Book Added!");
        printf("<br><a href=index.php>Return to admin home page </a>");
        //exit;
    }

    // Not a postback, so present the book entry form
    ?>

</main>
</body>
<script type="text/javascript" src="js/menu.js"></script>
</html>
