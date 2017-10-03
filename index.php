<?php
  include("header.php");
  include("config.php");
?>


<form action="index.php" method="POST">
  <table id="searchevents">
    <tr>
      <td>Search events</td>
    </tr>
    <tr>
      <td><input type="text" name="searchevent" class="searchbar"></td>
      <td><INPUT type="submit" class="searchbutton" name="submit" value="GO"></td>
    </tr>
  </table>
</form>

<div id="browse">

  <div class="box">
    <h3 class="profiletitle">Bowling &amp; pizza</h3>
    <div class="specifics">
        <img src="img/place.png" /><h4>Munksjön Jönköping</h4>
    </div>
    <img src="img/ellen.jpg" class="profilepic"/>
    <p class="description">Some text about events event evsnesabdija
      cdasfaifhnjkn hfsfeoscndnvcdsoifjdsiccxjnzkcjnzjk
      Hje här ör lite text om ingenting för att elenne ska ska hur detta ser ut stavar jag ens rtt???
    </p>
  </div>

  <div class="box">
    <p class="description">ELLENS ÄNDRING
    </p>
  </div>

  <div class="box">
    <p class="description">Some text about events event evsnesabdija
      cdasfaifhnjkn hfsfeoscndnvcdsoifjdsiccxjnzkcjnzjk
    </p>
  </div>

  <div class="box">
    <p class="description">Some text about events event evsnesabdija
      cdasfaifhnjkn hfsfeoscndnvcdsoifjdsiccxjnzkcjnzjk
    </p>
  </div>

</div>


<?php
  include("footer.php");
?>
