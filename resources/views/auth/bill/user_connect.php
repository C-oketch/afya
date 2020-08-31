<?php
define('HOST','178.62.14.243');
define('USER','root');
define('PASS','afya2017');
define('DB','afyapepe');
 
$con = mysqli_connect(HOST,USER,PASS,DB);
 
$email = $_POST['email'];
$password = $_POST['password'];
 
$sql = "select * from afya_users where username='$email' and password='$password'";
 
$res = mysqli_query($con,$sql);
 
$check = mysqli_fetch_array($res);
 
if(isset($check)){
 /*$json['success']="Succesful Login";*/
 $json['success']=$email;
}else{
 $json['error']=$password;
 
 
}
 
mysqli_close($con);
?>