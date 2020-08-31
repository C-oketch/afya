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
	date_default_timezone_set('Africa/Nairobi');
	$created_at= date('Y-m-d H:i:s');
	$updated_at=date('Y-m-d H:i:s');
	//$is_active=$_POST['is_active'];
	$is_active='yes';

	$insert = "INSERT INTO inventory(supplier,drug_id,drugname,strength,strength_unit,quantity,price,recommended_retail_price,outlet_id,submitted_by,created_at,updated_at,is_active)
	 		VALUES ('$supplier','$drug_id','$drugname','$strength','$strength_unit','$quantity','$price','$recommended_retail_price','$outlet_id','$submitted_by','$created_at','$updated_at','$is_active')";


//INSERT INTO inventory(supplier,drug_id,drugname,strength,strength_unit,quantity,price,recommended_retail_price,outlet_id,submitted_by) 
	 		//VALUES ('$supplier',0,'$drugname',0,'$strength_unit',0,0,0,0,0)


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