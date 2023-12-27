<?php

$Host = "localhost";
$User = "root";
$Pass = "";
$dbName = "profile";

$conn=new mysqli($Host,$User,$Pass);
if($conn->connect_error)
	die("Connection Failed : ".$conn->connect_error."<br>");

$sql="CREATE DATABASE ".$dbName;
if($conn->query($sql)===TRUE)
	echo"Database Create Success<br>";
else
	echo"Database Create Fail".$conn->error."<br>";

$conn=new mysqli($Host,$User,$Pass,$dbName);
if($conn->connect_error)
	die("Connection Failed : ".$conn->connect_error."<br>");
	
	$sql=array(
	
	"CREATE TABLE tbluserloginacc(
	UserId VARCHAR(25) PRIMARY KEY,
	UserName VARCHAR(100),
	UserPsw VARCHAR(32),
	UserFname VARCHAR(100),
	LastLogin VARCHAR(25),
	AccStatus CHAR(1),
	UserPhoneNumber VARCHAR(20)
	)"

	);
foreach($sql as $s)
if($conn->query($s)===TRUE)
	echo"Table Create Success<br>";
else
	echo"Table ".$s."Create Fail".$conn->error."<br>";



	

?>