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

<?php

if (isset($_POST['createevent'])) {
createEvent();
}

?>
