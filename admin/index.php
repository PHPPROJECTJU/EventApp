<?php
  session_start();
  if (!isset($_SESSION['username'])) {
    header("location:login.php");
  }
?>

<?php
include("config.php");
include("header.php");
$title = "Delete event";
?>

                <?php
                if (isset($_GET['EventID'])) {
                    $eventid = trim($_GET['EventID']);
                    $eventid = addslashes($eventid);

                    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

                    if ($db->connect_error) {
                        echo "could not connect: " . $db->connect_error;
                        printf("<br><a href=index.php>Return to home page </a>");
                        exit();
                    }

                        $stmt = $db->prepare("delete from Event where EventID = ?");
                        $stmt->bind_param('i', $eventid);
                        $response = $stmt->execute();
                        printf("<br>Event deleted!");
                        printf("<br><a href=index.php>Return to home page </a>");

                    exit;
                }
                ?>

                <h3>BROWSE EVENTS</h3>

										<form action="index.php" method="POST">
										  <table id="searchevents">

										    <tr>
										      <td><INPUT type="text" class="registerbar" name="searchtitle" placeholder="Title"></td>
										      <td><INPUT type="submit" class="searchbutton" name="submit" value="GO"></td>
												</tr>
												<tr>
													<td><INPUT type="text" class="registerbar" name="searchuser" placeholder="User"></td>
													<td><INPUT type="submit" class="searchbutton" name="submit" value="GO"></td>
										    </tr>
										  </table>
										</form>
                </div>

                <div id="eventlist">
                    <h3>EVENT LIST</h3>

                    <?php

                    $searchtitle = "";
                    $searchuser = "";
                    $searchtitle = htmlentities($searchtitle);
                    $searchuser = htmlentities($searchuser);

                    if (isset($_GET) && !empty($_GET)) {
                    echo $searchuser;

                    $searchtitle = trim($_GET['searchtitle']);
                    $searchuser = trim($_GET['searchuser']);
                    }

                    $searchtitle = addslashes($searchtitle);
                    $searchuser = addslashes($searchuser);

                    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

                    if ($db->connect_error) {
                    echo "could not connect: " . $db->connect_error;
                    printf("<br><a href=index.php>Return to home page </a>");
                    exit();
                    }

                    $query = " select * from Event";
                    if ($searchtitle && !$searchuser) {
                    $query = $query . " where Title like '%" . $searchtitle . "%'";
                    }
                    if (!$searchtitle && $searchuser) {
                    $query = $query . " where User like '%" . $searchauthor . "%'";
                    }
                    if ($searchtitle && $searchuser) {
                    $query = $query . " where Title like '%" . $searchtitle . "%' and User like '%" . $searchuser . "%'";
                    }

                    $stmt = $db->prepare($query);
                    $stmt->bind_result($ISBN, $title, $pages, $edition, $published, $author, $reserved);
                    $stmt->execute();

                    echo '<table bgcolor="#dddddd" cellpadding="6">';
                    echo '<tr><b><td>Title</td> <td>User</td> <td>Delete</td> </b> </tr>';
                    while ($stmt->fetch()) {
                        echo "<tr>";
                        echo "<td> $title </td><td> $user </td>";
                        echo '<td><a href="index.php?EventID=' . urlencode($eventid) . '"> Delete </a></td>';
                        echo "</tr>";
                    }
                    echo "</table>";

                    ?>

                </div>
        </main>
    </body>
</html>

<?php


include("footer.php");

 ?>
