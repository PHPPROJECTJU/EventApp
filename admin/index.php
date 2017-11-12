<?php
  session_start();
  if (!isset($_SESSION['adminusername'])) {
    header("location:login.php");
  }
?>

<?php
include("config.php");
include("header.php");
?>

<?php

$username = ($_SESSION['adminusername']);

 ?>
 <div id="headerwrap">
       <h2 id="aboutheader">Welcome, <?=$username?>!</h2>
 </div>

                <?php
                @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

                if ($db->connect_error) {
                    echo "could not connect: " . $db->connect_error;
                    printf("<br><a href=index.php>Return to home page </a>");
                    exit();
                }

/*---showing some info about how many users/events there are right now-----*/

                $howmanyusers = "SELECT COUNT(*) FROM User";

                $stmt = $db->prepare($howmanyusers);
                $stmt->bind_result($numberofusers);
                $stmt->execute();

                while ($stmt->fetch()) {
                    echo "<div class='about'>";
                    echo "<p class='aboutintro'>";
                    echo "There are currently ";
                    echo $numberofusers . " registered users ";
                }

                $howmanyevents = "SELECT COUNT(*) FROM Event";

                $stmt = $db->prepare($howmanyevents);
                $stmt->bind_result($numberofevents);
                $stmt->execute();

                while ($stmt->fetch()) {
                    echo "and " . $numberofevents . " active events";
                    echo " on Eventually.";
                    echo "</p>";
                    echo "</div>";
                }
                    ?>

                </div>
        </main>
    </body>
</html>

<?php


include("footer.php");

 ?>
