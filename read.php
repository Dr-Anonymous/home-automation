<?php
$pin= $_GET["pin"];
system("gpio -g read $pin");
?>
