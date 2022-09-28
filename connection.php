<?php

$hostname = "localhost";
$username = "root";
$password = "";
$db =  "mobile_otp_verification";
$conn = new mysqli($hostname,$username,$password,$db);
if($conn->connect_error){
die("connection error".$conn->connect_error);
// header('location: 404.html');
echo "<script>alert('connection failed!!')</script>";
}
session_start();
error_reporting('1');

?>