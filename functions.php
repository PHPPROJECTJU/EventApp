<?php


/*Header.php-------------------------------------------*/


#fetch regions

function getregions(){

    include ("config.php");
    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $getregion = "SELECT State.state_id, State.state_name
              FROM State
              ";

    $stmt3 = $db->prepare($getregion);
    $stmt3->bind_result($regionid, $showregion);
    $stmt3->execute();

    while ($stmt3->fetch()) {
          echo "<option value='$regionid'>$showregion</option>";
    }
};

#get cities

function getcity(){

    include ("config.php");
    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $getcityname = "SELECT City.city_name, City.city_id
              FROM City
              ";

    $stmt4 = $db->prepare($getcityname);
    $stmt4->bind_result($showcityname, $cityid);
    $stmt4->execute();

    while ($stmt4->fetch()) {
          echo "<option value='$cityid'>$showcityname</option>";
    }
};

#get categories

function getcategory(){

    include ("config.php");
    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $getcategory = "SELECT Category.Categoryname, Category.CategoryID
              FROM Category
              ORDER BY Category.Categoryname ASC
              ";

    $stmt = $db->prepare($getcategory);
    $stmt->bind_result($getcategoryname, $getcategoryid);
    $stmt->execute();

    while ($stmt->fetch()) {
          echo "<option value='$getcategoryid'>$getcategoryname</option>";
    }
};

#get UserID

function getUserID($username){
    include("config.php");

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
    echo "could not connect: " . $db->connect_error;
    printf("<br><a href=index.php>Return to home page </a>");
    exit();
    }

    $query = "SELECT UserID
              FROM User
              WHERE User.UserName = '{$username}'
              ";

    $stmt9 = $db->prepare($query);
    $stmt9->bind_result($userid);
    $stmt9->execute();
    $stmt9->store_result();
    $stmt9->fetch();

    echo '<INPUT type="hidden" name="userid" value=' . $userid . '>';

}

#creating a new event

function createEvent(){
    include("config.php");

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
    echo "could not connect: " . $db->connect_error;
    printf("<br><a href=index.php>Return to home page </a>");
    exit();
    }

    $userid = trim($_POST['userid']);
    $eventname = trim($_POST['eventname']);
    $adress = trim($_POST['adress']);
    $region = trim($_POST['region']);
    $cityID = trim($_POST['city']);
    $startdate = trim($_POST['startdate']);
    $enddate = trim($_POST['enddate']);
    $starttime = trim($_POST['starttime']);
    $endtime = trim($_POST['endtime']);
    $description = trim($_POST['description']);
    $categoryID = trim($_POST['categoryID']);

    checkDateTime();

    $userid = addslashes($userid);
    $eventname = htmlentities($eventname);
    $adress = htmlentities($adress);
    $region = addslashes($region);
    $cityID = addslashes($cityID);
    $startdate = addslashes($startdate);
    $enddate = addslashes($enddate);
    $starttime = addslashes($starttime);
    $endtime = addslashes($endtime);
    $description = htmlentities($description);
    $categoryID = addslashes($categoryID);


    $stmt = $db->prepare("INSERT INTO Event (Event.UserID, Event.Title, Event.StreetAdress, Event.state_id, Event.city_id, Event.StartDate, Event.EndDate, Event.StartTime, Event.EndTime, Event.Information, Event.CategoryID)
    									 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('issiisssssi', $userid, $eventname, $adress, $region, $cityID, $startdate, $enddate, $starttime, $endtime, $description, $categoryID);
    $stmt->execute();

    printf("Event created!");

    unset($_POST);
    ?>
      <script>
          window.location.href = "index.php";
      </script>
      <?php

}

function checkDateTime(){
  $startdate = trim($_POST['startdate']);
  $enddate = trim($_POST['enddate']);
  $starttime = trim($_POST['starttime']);
  $endtime = trim($_POST['endtime']);

  if($startdate > $enddate){
    echo "<p>Make sure the end date is not before the start date.</p>";
    exit();
  } elseif($starttime >= $endtime){
    echo "<p>Hey, it's hard to end an event before it starts!</p>";
    exit();
  }
}


/*Event.php-------------------------------------------*/

#showing the event card

function displayEvent(){
  include("config.php");


  $EventID = trim($_GET['EventID']);


      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $query = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.Title, Event.Status, DATE_FORMAT(StartDate, '%D %M, %Y') AS `StartDate`, DATE_FORMAT(`StartTime`, '%H:%i') AS `StartTime`, DATE_FORMAT(`EndTime`, '%H:%i') AS `EndTime`, Event.Information, Event.StreetAdress, City.city_name
                FROM User
                JOIN Event
                ON User.UserID=Event.UserID
                JOIN City
                ON Event.city_id=City.city_id
                WHERE Event.EventID=$EventID
                ";

      $stmt = $db->prepare($query);
      $stmt->bind_result($UserName, $ProfilePicture, $UserID, $Title, $Status, $StartDate, $StartTime, $EndTime, $Information, $StreetAdress, $cityname);
      $stmt->execute();


      while ($stmt->fetch()) {
          if ($Status == 1) {

            echo "<div class='firsteventbox'>";
            echo "<h3 class='profiletitle'>$Title</h3>";
            echo "<span class='pictureandname'>";
            echo "<img src='$ProfilePicture' class='profilepic'/>";
            echo "<a class='username' href='user.php?UserID= " . urlencode($UserID) . " '> $UserName </a>";
            echo "</span>";
            echo "<div class='specifics'>";
            echo "<p><img src='img/place-black.png' />$StreetAdress,<br /> $cityname</p> <br />";
            echo "<p><img src='img/time-black.png' />$StartDate<br /> kl $StartTime - $EndTime</p>";
            echo "</div>";
            echo "<p class='description'>$Information</p>";
            echo "<div class='eventbuttonbox'>";
            echo "<form action='' method='POST' name='attendsave'>";
            echo "<input type='submit' class='attendsaveblock' name='save' value='Save'>";
            echo "<input type='submit' class='attendsaveblock' name='attend' value='Attend'>";
            echo '<INPUT type="hidden" name="eventhostid" value=' . $UserID . '>';

            $username = $_SESSION['username'];
            getUserID($username);

            echo "</form>";
            echo "</div>";
            echo "</div>";
            }

          }


/*
No matter if we want to save or attend the event,
we need to get the logged in user's ID to insert
into the middle table Event_User. We get it by using
our previous function getUserID (see above) to echo
out a hidden input with the desired ID. When the form
is submitted, we can capture the id to use and pass
with either the function saveEvent or attendEvent.
(se below) Note: We also need the ID of the Event host,
hence the hidden input "eventhostid"
*/

        if (isset($_POST['save']) OR isset($_POST['attend'])) {
            $myuserid = trim($_POST['userid']);
            $eventhostid = trim($_POST['eventhostid']);
        }

        if (isset($_POST['save'])) {
            saveEvent($myuserid, $EventID, $eventhostid);
        }
        else if (isset($_POST['attend'])) {
            attendEvent($myuserid, $EventID, $eventhostid);
        }

}

#saving an event

function saveEvent($myuserid, $EventID, $eventhostid){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
  }

  $query = "INSERT INTO Event_User (UserID, SavedID, HostID)
            VALUES ($myuserid, $EventID, $eventhostid)
            ";

  $stmt = $db->prepare($query);
  $stmt->execute();

  unset($_POST);
  ?>
    <script>
        window.location.href = "event.php?EventID=<?php echo $EventID?>";
    </script>
  <?php

};

#attending an event

function attendEvent($myuserid, $EventID, $eventhostid){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
  }

  $query = "INSERT INTO Event_User (UserID, AttendedID, HostID)
            VALUES ($myuserid, $EventID, $eventhostid)
            ";

  $stmt = $db->prepare($query);
  $stmt->execute();

  unset($_POST);
  ?>
    <script>
        window.location.href = "event.php?EventID=<?php echo $EventID?>";
    </script>
  <?php
};

/*---Hostedevents.php--------------------*/

function getHostedEvents($myuserid){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
  }


  $query = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.EventID, Event.Status, Event.Title, DATE_FORMAT(StartDate, '%D %M, %Y') AS `StartDate`, DATE_FORMAT(`StartTime`, '%H:%i') AS `StartTime`, Event.Information, Event.StreetAdress, City.city_name
            FROM Event
            JOIN User
            ON Event.UserID=User.UserID
            JOIN City
            ON Event.city_id=City.city_id
            WHERE Event.UserID=$myuserid
            ORDER BY Event.EventID DESC
            ";
            $stmt = $db->prepare($query);
            $stmt->bind_result($UserName, $ProfilePicture, $UserID, $EventID, $Status, $Title, $StartDate, $StartTime, $Information, $StreetAdress, $cityname);
            $stmt->execute();

            while ($stmt->fetch()) {


                if ($Status == 1) {

                  echo "<div class='eventpagebox'>";
                  echo "<h3 class='profiletitle'>$Title</h3>";
                  echo "<span class='pictureandname'>";
                  echo "<img src='$ProfilePicture' class='profilepic'/>";
                  echo "<a class='username' href='user.php?UserID= " . urlencode($UserID) . " '> $UserName </a>";
                  echo "</span>";
                  echo "<div class='specifics'>";
                  echo "<p><img src='img/place-black.png' />$StreetAdress,<br /> $cityname</p> <br />";
                  echo "<p><img src='img/time-black.png' />$StartDate<br /> kl $StartTime</p>";
                  echo "</div>";
                  echo "<p class='description'>$Information</p>";
                  //echo "<p class='description'>Attenders: ";
                  //howManyAttenders($EventID);
                  echo "</p>";
                  echo "<br />";
                  echo "<br />";
                  echo "<form action='' method='POST' name='hostedbuttons'>";
                  echo '<INPUT type="hidden" name="eventid" value='.$EventID.'>';
                  echo "<a class='attendsaveblock' href='event.php?EventID= " . urlencode($EventID) . " '>See event page</a>";
                  echo "<input type='submit' class='cancelbutton' name='cancelevent' value='Cancel event'>";
                  echo "</div>";
                  echo "</form>";
                  echo "</div>";
              }

                }

            if (isset($_POST['cancelevent'])) {
              $EventID = ($_POST['eventid']);
              ?>
              <script>
                  var question = confirm("Do you really want to cancel this event?");
                  if (question == true) {
                    <?php
                    cancelEvent($EventID);
                    unset($_POST);
                    ?>
                  }
                      window.location.href = "hostedevents.php";
                  </script>
                <?php
            }
}

function howManyAttenders($EventID){
    include("config.php");

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $query = "SELECT * FROM Event_User
              WHERE Event_User.AttendedID = $EventID
            ";

            $stmt8 = $db->prepare($query);
            $stmt8->execute();
            $stmt8->store_result();

            $totalcount = $stmt8->num_rows();
            echo $totalcount;
}

function cancelEvent($EventID){
            include("config.php");

            @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

            if ($db->connect_error) {
                echo "could not connect: " . $db->connect_error;
                printf("<br><a href=index.php>Return to home page </a>");
                exit();
            }

            $query = "UPDATE
                      Event
                      SET Status=0
                      WHERE
                      Event.EventID = $EventID
                      ";

                      $stmt = $db->prepare($query);
                      $stmt->execute();

};

/*---Attendedevents.php--------------------*/

function getAttendedEvents($myuserid){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
  }

  $query = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.EventID, Event.Status, Event.Title, DATE_FORMAT(StartDate, '%D %M, %Y') AS `StartDate`, DATE_FORMAT(`StartTime`, '%H:%i') AS `StartTime`, Event.Information, Event.StreetAdress, City.city_name
            FROM Event_User
            JOIN Event
            ON Event_User.AttendedID=Event.EventID
            JOIN User
            ON Event_User.HostID=User.UserID
            JOIN City
            ON Event.city_id=City.city_id
            WHERE Event_User.UserID=$myuserid
            ";
            $stmt = $db->prepare($query);
            $stmt->bind_result($UserName, $ProfilePicture, $UserID, $EventID, $Status, $Title, $StartDate, $StartTime, $Information, $StreetAdress, $cityname);
            $stmt->execute();


            while ($stmt->fetch()) {
              if ($Status == 1) {

                echo "<div class='eventpagebox'>";
                echo "<h3 class='profiletitle'>$Title</h3>";
                echo "<span class='pictureandname'>";
                echo "<img src='$ProfilePicture' class='profilepic'/>";
                echo "<a class='username' href='user.php?UserID= " . urlencode($UserID) . " '> $UserName </a>";
                echo "</span>";
                echo "<div class='specifics'>";
                echo "<p><img src='img/place-black.png' />$StreetAdress,<br /> $cityname</p> <br />";
                echo "<p><img src='img/time-black.png' />$StartDate<br /> kl $StartTime</p>";
                echo "</div>";
                echo "<p class='description'>$Information</p>";
                echo "<br />";
                echo "<form action='' method='POST' name='attendedbuttons'>";
                echo '<INPUT type="hidden" name="eventid" value='.$EventID.'>';
                echo "<a class='attendsaveblock' href='event.php?EventID= " . urlencode($EventID) . " '>See event page</a>";
                echo "<input type='submit' class='cancelbutton' name='unattend' value='Unattend'>";

                $username = $_SESSION['username'];
                getUserID($username);

                echo "</form>";
                echo "</div>";
                }

              }

              if (isset($_POST['unattend'])) {
                $EventID = ($_POST['eventid']);
                $myuserid = ($_POST['userid']);
                unattendEvent($EventID, $myuserid);
                unset($_POST);
                ?>
                  <script>
                      window.location.href = "attendedevents.php";
                  </script>
                <?php
              }
}

function unattendEvent($EventID, $myuserid){
            include("config.php");

            @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

            if ($db->connect_error) {
                echo "could not connect: " . $db->connect_error;
                printf("<br><a href=index.php>Return to home page </a>");
                exit();
            }

            $query = "DELETE FROM
                      Event_User
                      WHERE
                      AttendedID = ?
                      AND
                      UserID = ?
                      ";
                      $stmt = $db->prepare($query);
                      $stmt->bind_param('ii', $EventID, $myuserid);
                      $response = $stmt->execute();


};

/*---Savedevents.php--------------------*/

function getSavedEvents($myuserid){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
  }

  $query = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.EventID, Event.Status, Event.Title, DATE_FORMAT(StartDate, '%D %M, %Y') AS `StartDate`, DATE_FORMAT(`StartTime`, '%H:%i') AS `StartTime`, Event.Information, Event.StreetAdress, City.city_name
            FROM Event_User
            JOIN Event
            ON Event_User.SavedID=Event.EventID
            JOIN User
            ON Event_User.HostID=User.UserID
            JOIN City
            ON Event.city_id=City.city_id
            WHERE Event_User.UserID=$myuserid
            ";
            $stmt = $db->prepare($query);
            $stmt->bind_result($UserName, $ProfilePicture, $UserID, $EventID, $Status, $Title, $StartDate, $StartTime, $Information, $StreetAdress, $cityname);
            $stmt->execute();


            while ($stmt->fetch()) {
              if ($Status == 1) {

                echo "<div class='eventpagebox'>";
                echo "<form action='' method='POST'>";

                $username = $_SESSION['username'];
                getUserID($username);

                echo '<INPUT type="hidden" name="eventid" value=' . $EventID . '>';
                echo "<input type='submit' class='closedark' name='unsave' value='×'>";
                echo "</form>";
                echo "<h3 class='profiletitle'>$Title</h3>";
                echo "<span class='pictureandname'>";
                echo "<img src='$ProfilePicture' class='profilepic'/>";
                echo "<a class='username' href='user.php?UserID= " . urlencode($UserID) . " '> $UserName </a>";
                echo "</span>";
                echo "<div class='specifics'>";
                echo "<p><img src='img/place-black.png' />$StreetAdress,<br /> $cityname</p> <br />";
                echo "<p><img src='img/time-black.png' />$StartDate<br /> kl $StartTime</p>";
                echo "</div>";
                echo "<p class='description'>$Information</p>";
                echo "<a class='attendsaveblock' href='event.php?EventID= " . urlencode($EventID) . " '>See event page</a>";
                echo "</div>";
                }
              }

              if (isset($_POST['unsave'])) {
                $EventID = ($_POST['eventid']);
                $myuserid = ($_POST['userid']);
                unsaveEvent($EventID, $myuserid);
                unset($_POST);
                ?>
                  <script>
                      window.location.href = "savedevents.php";
                  </script>
                <?php
              }
};

function unsaveEvent($EventID, $myuserid){
            include("config.php");

            @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

            if ($db->connect_error) {
                echo "could not connect: " . $db->connect_error;
                printf("<br><a href=index.php>Return to home page </a>");
                exit();
            }

            $query = "DELETE FROM
                      Event_User
                      WHERE
                      SavedID = ?
                      AND
                      UserID = ?
                      ";
                      $stmt = $db->prepare($query);
                      $stmt->bind_param('ii', $EventID, $myuserid);
                      $response = $stmt->execute();


};

/*---usersevent.php--------------------*/

function getUsersEvents($UserID){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
  }

  $query = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.Title, DATE_FORMAT(StartDate, '%D %M, %Y') AS `StartDate`, DATE_FORMAT(`StartTime`, '%H:%i') AS `StartTime`, Event.Information, Event.StreetAdress, Event.EventID
            FROM Event
            JOIN User
            ON Event.UserID = User.UserID
            WHERE Event.UserID = $UserID
            ";
            $stmt = $db->prepare($query);
            $stmt->bind_result($UserName, $ProfilePicture, $UserID, $Title, $StartDate, $StartTime, $Information, $StreetAdress, $EventID);
            $stmt->execute();

/*--------Counter to give first object on page a unique class------*/
            $count = 0;

            while ($stmt->fetch()) {
                //echo "<div class='eventpagebox'>";

                echo '<div class="eventpagebox ';
                if($count == 0) {
                    echo 'firsteventbox">';
                }
                else{
                    echo '">';
                }
                echo "<h3 class='profiletitle'>$Title</h3>";
                echo "<span class='pictureandname'>";
                echo "<img src='$ProfilePicture' class='profilepic'/>";
                echo "<a class='username' href='user.php?UserID= " . urlencode($UserID) . " '> $UserName </a>";
                echo "</span>";
                echo "<div class='specifics'>";
                echo "<p><img src='img/place-black.png' />$StreetAdress,<br /> $cityname</p> <br />";
                echo "<p><img src='img/time-black.png' />$StartDate<br /> kl $StartTime</p>";
                echo "</div>";
                echo "<p class='description'>$Information</p>";
                echo "<a class='seemore' href='event.php?EventID=" . urlencode($EventID) . " '>more...</a>";
                echo "<form action='' method='POST' name='attendsave'>";
                echo "</form>";
                echo "</div>";
            /*--- incrementing counter-----*/
            $count++;
            }
};

/*---Register.php-----------------------------------------*/

function registerUser(){
    include("config.php");


    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

        if ($db->connect_error) {
            echo "could not connect: " . $db->connect_error;
            printf("<br><a href=index.php>Return to home page </a>");
            exit();
        }

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $repeatpassword = trim($_POST['repeatpassword']);

        $username = addslashes($username);
        $email = addslashes($email);
        $password = addslashes($password);
        $repeatpassword = addslashes($repeatpassword);

        checkUsername();

        checkpasswordstrength();

        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);



        $stmt = $db->prepare("INSERT INTO User (User.Username, User.EmailAdress, User.Password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $email, $hashedpassword);
        $stmt->execute();
        $stmt->close();

        session_start();

        $UserID = mysqli_insert_id($db);
        $_SESSION['userid'] = $UserID;


        printf("<br><br><br><br>User Added!");
        $_SESSION['username'] = $username;
        header("location:createprofile.php");

}

function checkUsername(){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
  }

  $username = trim($_POST['username']);
  $username = addslashes($username);

  $query = "SELECT *
            FROM User
            WHERE User.UserName = '{$username}'
            ";

  $stmt8 = $db->prepare($query);
  $stmt8->execute();
  $stmt8->store_result();

  $totalcount = $stmt8->num_rows();

  $stmt8->fetch();

  if (isset($totalcount)) {
        if ($totalcount != 0) {
          echo "<br><p class='wrongpasstext'>&rarr; Username already exists";
          exit();
        }
  }
};


function checkpasswordstrength(){

  $password = trim($_POST['password']);
  $repeatpassword = trim($_POST['repeatpassword']);

  $temppass = strlen($password);
  $temppass2 = strlen($repeatpassword);

  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number    = preg_match('@[0-9]@', $password);

  if (isset($_POST['submit'])) {

        if(!$uppercase || !$lowercase || !$number) {
         echo "<br><p class='wrongpasstext2'><br>Too weak password.<br>
         &rarr;Use at least one uppercase capital letter.<br>
         &rarr;Use at least one lowercase capital letter.<br>
         &rarr;Use at least one number between 0-9. </p>";
         unset($_POST);
         exit();
        } else {

            if ($repeatpassword != $password){
              echo "<br><p class='wrongpasstext'>&rarr; Passwords don't match</p>";
              unset($_POST);
              exit();
            }

            if ($temppass < 8 || $temppass2 < 8){
              echo "<br><p class='wrongpasstext'>&rarr; Use 8 or more characters as password.</p>";
              unset($_POST);
              exit();
            }
        }
  }
}


/*-------------------------createprofile.php--------------------------*/

function finishtheuser(){
      include("config.php");

      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $UserID = $_SESSION['userid'];

      #Getting the image upload:
      if (isset($_FILES['fileupload'])) {

            $allowedextensions = array('jpg', 'jpeg', 'gif', 'png');

            $extension = strtolower(substr($_FILES['fileupload']['name'], strrpos($_FILES['fileupload']['name'], '.') + 1));

            $error = array ();

            if(in_array($extension, $allowedextensions) === false){
              $error[] = 'Not an allowed file format.';
            }

            if($_FILES['fileupload']['size'] > 1000000){
              $error[]='This file is over the 1MB limit.';
            }

            if(empty($error)){
              move_uploaded_file($_FILES['fileupload']['tmp_name'], "profilepics/user$UserID.$extension");
            } else {
                foreach ($error as $err){
                  echo $err;
                }
            }
      } else {
        echo "not uploaded";
      }

      $firstname = trim($_POST['firstname']);
      $lastname = trim($_POST['lastname']);
      $bday = trim($_POST['bday']);
      $fileupload = "user".$UserID.".".$extension;
      $about = trim($_POST['about']);

      $firstname = addslashes($firstname);
      $lastname = addslashes($lastname);
      $bday = addslashes($bday);
      $fileupload = addslashes($fileupload);
      $about = addslashes($about);

      $stmt = $db->prepare("UPDATE User
                            SET FirstName='$firstname', LastName='$lastname', Birthdate='$bday', ProfilePicture='profilepics/$fileupload', About='$about'
                            WHERE UserID=$UserID");
      $stmt->bind_param('sssss', $firstname, $lastname, $bday, $fileupload, $about);
      $stmt->execute();

      ?>
        <script>
            window.location.href = "index.php";
        </script>
        <?php
  }

  /*-----------------login.php------------------*/


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


  /*-----------------update the user------------------*/


  function updatetheuser(){
   include("config.php");

   @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

   if ($db->connect_error) {
       echo "could not connect: " . $db->connect_error;
       printf("<br><a href=index.php>Return to home page </a>");
       exit();
   }

   $sessionuser = $_SESSION['username'];

   #Getting the image upload:
   if (isset($_FILES['fileupload'])) {

         $allowedextensions = array('jpg', 'jpeg', 'gif', 'png');

         $extension = strtolower(substr($_FILES['fileupload']['name'], strrpos($_FILES['fileupload']['name'], '.') + 1));

         $error = array ();

         if(in_array($extension, $allowedextensions) === false){
           $error[] = 'Not an allowed file format.';
         }

         if($_FILES['fileupload']['size'] > 1000000){
           $error[]='This file is over the 1MB limit.';
         }

         if(empty($error)){
           move_uploaded_file($_FILES['fileupload']['tmp_name'], "profilepics/user$UserID.$extension");
         } else {
             foreach ($error as $err){
               echo $err;
             }
         }
   } else {
     echo "not uploaded";
   }


   $firstname = trim($_POST['firstname']);
   $lastname = trim($_POST['lastname']);
   $bday = trim($_POST['bday']);
   $fileupload = "user".$UserID.".".$extension;
   $about = trim($_POST['about']);


   $firstname = addslashes($firstname);
   $lastname = addslashes($lastname);
   $bday = addslashes($bday);
   $fileupload = addslashes($fileupload);
   $about = addslashes($about);

   $stmt = $db->prepare("UPDATE User
                         SET FirstName='$firstname', LastName='$lastname', Birthdate='$bday', ProfilePicture='profilepics/$fileupload', About='$about'
                         WHERE UserName=$sessionuser");
   $stmt->bind_param('ssss', $firstname, $lastname, $bday, $fileupload, $about);
   $stmt->execute();

   ?>
   <script>
       window.location.href = "index.php";
   </script>
   <?php
  }

  /*-----------------edit profile-------------------*/


/*Event comments*/

#post a new comment

function makeComment($comment){

  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }


  $myusername = $_SESSION['username'];
  $EventID = trim($_GET['EventID']);

    $comment = $comment;
    $comment = htmlentities($comment);

    $commentquery = ("INSERT INTO Comments (Text, EventID, UserName)
                  VALUES (?, ?, ?)
                  ");

    $stmt2 = $db->prepare($commentquery);
    $stmt2->bind_param('sis', $comment, $EventID, $myusername);
    $stmt2->execute();

    unset($_POST);
    ?>
      <script>
          window.location.href = "event.php?EventID=<?php echo $EventID?>";
      </script>
      <?php
}

#getting and displaying comments

function getComment(){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $myusername = $_SESSION['username'];

      $EventID = trim($_GET['EventID']);

      $getcomment = ("SELECT Comments.CommentID, Comments.Text, Comments.UserName, User.UserID, User.ProfilePicture
                FROM Comments
                JOIN User
                ON Comments.UserName=User.UserName
                WHERE EventID=$EventID
                ORDER BY CommentID DESC
                ");
      $stmt3 = $db->prepare($getcomment);
      $stmt3->bind_result($Commentid, $Text, $Commenter, $UserID, $Profilepic);
      $stmt3->execute();


      while ($stmt3->fetch()) {
          echo "<div class='comment'>";
          echo "<img src='$Profilepic' class='commenterpic'/>";
          echo "<a href='user.php?UserID= " . urlencode($UserID) . " '> $Commenter </a> says:";
          echo "<div id='commentBox'>";

          #If this is our own comment we want to be able to delete it
          if ($Commenter == $myusername) {
            echo "<form action='' method='POST'>";
            echo '<INPUT type="hidden" name="commentid" value=' . $Commentid . '>';
            echo "<input type='submit' class='closedark' name='deletecomment' value='×'>";
            echo "</form>";
          }

          echo "<div class='commentarrow'></div>";
          echo "<div id='commenttext'><p>";
          echo $Text;
          echo "</p></div>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
      }

      if (isset($_POST['deletecomment'])) {
        $Commentid = ($_POST['commentid']);
        deleteComment($Commentid);
        unset($_POST);
        ?>
        <script>
            window.location.href = "event.php?EventID=<?php echo $EventID?>";
        </script>
        <?php
      }
}

function deleteComment($Commentid){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

  $deletecomment = "DELETE FROM
                  Comments
                  WHERE
                  Comments.CommentID = ?
                  ";

                  $stmt = $db->prepare($deletecomment);
                  $stmt->bind_param('i', $Commentid);
                  $response = $stmt->execute();
}

?>
