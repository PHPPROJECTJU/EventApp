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


    <div id="registerbox">
      <div id="aboutbutton" onclick="showAbout()">About</div>
      <div id="aboutBox">
          <div class="arrow"></div>
          <div id="about">
              <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit</p>
          </div>
      </div>

        <form action="">
          <table id="registerform">
            <tr>
              <td><input type="text" name="username" class="registerbar" placeholder="username" required></td>
            </tr>
            <tr>
              <td><input type="password" name="password" class="registerbar" placeholder="password" required></td>
            </tr>
              <td><input type="submit" class="registerbutton" name="submit" value="login"></td>
            </tr>
          </table>
        </form>

    </div>

</div>

</main>
</body>
<script type="text/javascript" src="js/menu.js"></script>
</html>
