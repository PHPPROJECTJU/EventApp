<form action="" method="POST">
  <div id="eventform">
        <div class="row">
             Name of Event<input type="text" name="eventname" class="eventregisterbar" placeholder="Name of Event" required>
        </div>

        <div class="row">
            <div class="innerdatewrap"><p>Start date</p><input type="date" name="startdate" class="test" placeholder="Time for event" required></div>
            <div class="innerdatewrap"><p>Start time</p><input type="time" name="starttime" class="test" placeholder="Time for event" required></div>

        </div>
        <div class="row">
            <div class="innerdatewrap"><p>End date</p><input type="date" name="enddate" class="test" placeholder="Time for event" required></div>
            <div class="innerdatewrap"><p>End time</p><input type="time" name="endtime" class="test" placeholder="Time for event" required></div>
        </div>
        <div class="row">
          Describe your event<textarea rows="4" cols="80" type="textarea" name="description" class="eventregisterbartext" placeholder="Description of event" required></textarea>
        </div>
         <div>
             <input type="submit" class="blockbutton" name="createevent" value="Create event">
         </div>
   </div>

</form>
</div>


</div>

</div>

<?php


function createEvent(){
include("config.php");

@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

if ($db->connect_error) {
echo "could not connect: " . $db->connect_error;
printf("<br><a href=index.php>Return to home page </a>");
exit();
}

$eventname = trim($_POST['eventname']);
$startdate = trim($_POST['startdate']);
$enddate = trim($_POST['enddate']);
$starttime = trim($_POST['starttime']);
$endtim = trim($_POST['endtime']);
$description = trim($_POST['description']);

$eventname = addslashes($eventname);
$startdate = addslashes($startdate);
$enddate = addslashes($enddate);
$starttime = addslashes($starttime);
$endtim = addslashes($endtim);
$description = addslashes($description);



$stmt = $db->prepare("INSERT INTO Event (Event.Title, Event.StartDate, Event.EndDate, Event.StartTime, Event.EndTime, Event.Information)
                   VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param('ssssss', $eventname, $startdate, $enddate, $starttime, $endtim, $description);
$stmt->execute();
printf("Event created!");
}

if (isset($_POST['createevent'])) {
createEvent();
}
?>
