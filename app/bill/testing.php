<?php

//This script is designed by Android-Examples.com
//Define your host here.
$hostname = "mysql.hostinger.in";
//Define your database username here.
$username = "u727224026_demo";
//Define your database password here.
$password = "1234567890";
//Define your database name here.
$dbname = "u727224026_demo";
  
  $con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");
  
  /*
  $name = $_POST['name'];
  $email = $_POST['email'];
  $website = $_POST['website'];
  */
  $weight = 160;
$temperature = 45;    
  
   $Sql_Query = "insert into self_report (weight,temperature) values ('$weight','$temperature')";
   
  if(mysqli_query($con,$Sql_Query)){
	  
    echo 'Data Inserted Successfully';
	
  }
  else{
	  
    echo 'Try Again';
	
  }
  mysqli_close($con);
?>