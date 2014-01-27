<?php
require("libs/init.php"); //Include the YourScannerSux core.
$yourscannersux = new yourscannersux(); //Create a new instance of YourScannerSux.
$yourscannersux->Initialise(); //Initialises the system and writes a userid and creates a formid.

echo $yourscannersux->CreateForm(); //Creates a hidden honeypot form.
?>