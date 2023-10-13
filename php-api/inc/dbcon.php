<?php

$host="localhost";
$username="root";
$password="";
$dbname="company";

$conn=mysqli_connect($host, $username, $password, $dbname);

if(!$conn){

    die("connection failed".mysql_connect_error());
}

?>