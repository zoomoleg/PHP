<?php
$username = "root";
$password = "";
$hostname = "localhost";
$DbName = "work";
$TabName = "staff";
$TabNameProductBall = "ProductBall";
$TabNameSale = "sale";
$TabNamePlan = "plan";
$TabNameOffice = "office";
$Host = "localhost";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

$selected = mysql_select_db("$DbName",$dbhandle) 
  or die("Could not select schools");
  mysql_query("SET NAMES 'UTF8'"); // Устанавливаем кодировку в БД
