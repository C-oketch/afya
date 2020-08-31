<?php
 $con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");


// Report runtime errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Report all errors
error_reporting(E_ALL);

// Same as error_reporting(E_ALL);
ini_set("error_reporting", E_ALL);

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

$weight = 178;
$temperature = 123;           
$bp = 12;
$fasting_sugars = 13;

$before_meal_sugars= 145;
$postprondial_sugars = 45;
$dependents = 344;
$irritable = 'yes'; // yes/no
$diarrhoea = 'No';//yes/no

$difficult_feeding = 'No';//yes/no

$convulsion = 'no';//yes/no
$cry = 'yes';//yes/no

 $flag = array("error" => FALSE);
$result = mysqli_query($con,"INSERT INTO `self_report` (`afyauser_id`,`temperature`, `weight`, `bp`, `fasting_sugars`, `before_meal_sugars`, `postprondrial_sugars`, `dependents`, `irritable`, `diarrhoea`, `difficult_feeding`, `convulsion`, `cry`) VALUES ( 1 ,'$temperature','$weight', '$bp', '$fasting_sugars', '$before_meal_sugars', '$postprondrial_sugars', '$dependents', '$irritable','$diarrhoea', '$difficult_feeding', '$convulsion','$cry')") OR die(mysqli_error($con));

if($result!=true)

{
	$flag["error"]=TRUE;
	 $flag["error_msg"] = "Failed to store data ";
        echo json_encode($flag);



}

else
{

$flag["error"]=FALSE;
$flag["success"]="Data successfully uploaded";
echo json_encode($flag);


}

 mysqli_close($con);

?>










