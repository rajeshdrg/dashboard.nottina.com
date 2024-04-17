<?php
$file = fopen("/dados/cap/status/vpnsp_o4.hugtak.com.j", "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
while(!feof($file))
  {
  echo fgets($file). "<br>";
  }
fclose($file);
?>
