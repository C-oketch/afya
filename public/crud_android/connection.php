<?php 

// <?php
// $con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");
	define('HOSTNAME', 'localhost');
	define('USERNAME', 'root');
	define('PASSWORD', '');
	define('DB_SELECT', 'db_crud');



	$koneksi = new mysqli(HOSTNAME,USERNAME,PASSWORD,DB_SELECT) or die (mysqli_errno());
	
	
	
	//echo "string";


 ?>