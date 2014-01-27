<?php
$risk_low = 0; //risk is bigger than.
$risk_medium = 3; //risk is bigger or equals.
$risk_high = 10; //risk is bigger or equals.


//Access premissions 1=low 2=medium 3=high 0=disabled
$warning_risk = 2; //displays warning in http headers.
$lockout_risk = 3; //blocks user from accessing the website.'
$lockout_message = "<h1>400 Bad Request</h1><hr /><h2>You have being blocked. Please leave</h2>"; //html message shown to blocked users

$write_log = true; //logs warnings and blocks to file.
$log_directory = "yss_logs"; //the log directory.
$allow_public_log_access = false; //makes log directory public (Directory Listing) -- After changing this. you must delete the existing log folder

?>