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
    <hr />
    <img src="img/ellen.jpg" class="profilepic"/>
    <div class="specifics">
        <p><img src="img/place.png" />Jönköping centrum</p>
        <br />
        <br />
        <p><img src="img/time.png" />24/7 kl 10.00</p>
    </div>
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
