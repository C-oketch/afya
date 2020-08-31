<?php 

$con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");

	$supplier=$_POST['supplier'];//shold insert number
	$drug_id=$_POST['drug_id'];
	$drugname=$_POST['drugname'];
	$strength=$_POST['strength'];
	$strength_unit=$_POST['strength_unit'];
	$quantity=$_POST['quantity'];
	$price=$_POST['price'];
	$recommended_retail_price=$_POST['recommended_retail_price'];
	$outlet_id=$_POST['outlet_id'];
	$submitted_by=$_POST['submitted_by'];

	$insert = "INSERT INTO inventory(supplier,drug_id,drugname,strength,strength_unit,quantity,price,recommended_retail_price,outlet_id,submitted_by)
	 		VALUES ('$supplier','$drug_id','$drugname','$strength','$strength_unit','$quantity','$price','$recommended_retail_price','$outlet_id','$submitted_by')";

	$exeinsert = mysqli_query($con,$insert);

	$response = array();

	if($exeinsert)
	{
		$response['code'] =1;
		$response['message'] = "Success ! Data added";
	}
	else
	{
		$response['code'] =0;
		$response['message'] = "Failed ! Data not added";
	}

		echo json_encode($response);

 ?>