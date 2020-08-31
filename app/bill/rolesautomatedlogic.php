<?php
$con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");

//$email = $_POST["email"];
//$password = $_POST['password'];
$email= "register@afyapepe.com";
$password="register1";
$result='';
$response = array("error" => FALSE);

$query = mysqli_query($con,"select * from users where email='$email'");

//echo $email." - ".$password;

if(mysqli_num_rows($query) > 0){
$row = mysqli_fetch_assoc($query);
if(password_verify($password,$row['password']) == true){
	
	
		
	
	
	
		
	
	$response['roles']= $row['role'];
	
	$response['user'] = $row;
	$response['error'] = FALSE;
	 $response["uid"] ="";
	$response['success'] = "Successfully logged in";
	
	echo json_encode($response);
	 $result="true";
	 
	 
	
	
	
	
}else{
	$response['error'] = TRUE;
	$response['error_msg'] = "Wrong Password";
	echo json_encode($response);
	 $result="false";
}
}else{
	$response['error'] = TRUE;
	$response['error_msg'] = "Wrong Credentials";
	echo json_encode($response);
	
	 $result="true";
	
	}
?>
