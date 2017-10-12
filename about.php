<?php
  include("config.php");
  include("header.php");

  if (!isset($_SESSION['username'])) {
    header("login.php");
  }

?>

<div class="about">
  <img src="img/about.png">

  <cite>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</cite>
  <br>
  <br>

  <p>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet nunc erat. Nunc mattis purus sed nulla malesuada dictum. Nullam et malesuada velit. Ut vitae massa tellus. Pellentesque at libero gravida, ultricies turpis sit amet, cursus tortor. Mauris sollicitudin sagittis elit, non luctus felis tempus ut. Duis vel dapibus eros. Cras tortor dolor, rhoncus et tellus eget, luctus cursus arcu. Phasellus vulputate pharetra est, at tincidunt justo ultrices eget. Duis tincidunt nibh eget lacus hendrerit, et tempus ligula bibendum. Aliquam consectetur eleifend magna. Donec id lectus rutrum, euismod nibh sit amet, euismod nisl. Phasellus mattis lobortis tincidunt. Nullam sit amet orci in tortor cursus hendrerit ut sit amet ante. Aenean venenatis turpis eget mauris aliquet, ac venenatis est aliquam. Pellentesque in nibh nibh.
    <br>
    <br>
    Suspendisse non risus vulputate, imperdiet urna nec, tempus ligula. Maecenas mauris leo, interdum at odio a, aliquet vestibulum risus. Pellentesque et augue cursus, convallis libero nec, varius eros. Etiam mollis ut odio id lacinia. Sed tristique, elit nec suscipit dictum, lorem enim posuere sapien, sit amet laoreet augue ligula quis nisi. Aenean blandit feugiat quam vel euismod. Curabitur aliquam vel mauris nec sodales. Nulla viverra ipsum at feugiat ullamcorper. Phasellus aliquam ut diam sed venenatis. Aenean ut nisl ex. Proin fringilla lectus in porttitor sollicitudin. Quisque purus sapien, fringilla at lacinia non, suscipit et massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras porta ex at sem blandit efficitur. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.
  </p>

  <br>
  <p><a href="contact.php">Contact us!</a></p>
</div>

<?php
  include("footer.php");
?>
