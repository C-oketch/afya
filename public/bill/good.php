<?php
$con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");

//$email = $_POST['username'];
//$password = $_POST['password'];
$email= "register@afyapepe.com";
$password="register1";
$result='';
$response = array();

$query = mysqli_query($con,"select * from users where email='$email'");
if(mysqli_num_rows($query) > 0){
$row = mysqli_fetch_assoc($query);
if(password_verify($password,$row['password']) == true){
	$response['error']=FALSE;
	$response['user'] = $row;
	$response['success'] = "Successfully logged in";
	
	echo json_encode($response);
	 $result="true";
}else{
	response['error']=FALSE;
	$response['error_msg'] = "Wrong Credentials";
	echo json_encode($response);
	 $result="false";
}
}else{
	response['error']=FALSE;
	$response['error_msg'] = "Wrong Credentials";
	echo json_encode($response);
	
	 $result="true";
	
	}
?>
