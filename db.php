<?php

$Host = "localhost";
$User = "root";
$Pass = "";
$dbName = "profile";
	
$mysqli=new mysqli($Host,$User,$Pass,$dbName);
if($mysqli->connect_error)
	die("Connection Failed : ".$mysqli->connect_error."<br>");

?>