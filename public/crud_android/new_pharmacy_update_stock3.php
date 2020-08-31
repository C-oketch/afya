<?php  
	//include_once('connection.php'); 
$con = mysqli_connect("localhost","root","","afyapepe") or die("connection error!");


$id = 1;
$drug_id = 55;
$quantity = 2010;
$submitted_by = 1;
$outlet_id = 1;
$status = 1;
// $created_at = $_POST['created_at'];
// $updated_at = $_POST['updated_at'];
//$strength = $_POST['strength'];

 // $id = 2;

	// $quantity =300;

	$getdata = mysqli_query($con,"SELECT * FROM inventory_updates WHERE id ='$id'"); 
	$rows = mysqli_num_rows($getdata);
	
	$respose = array();

	if($rows > 0 )
	{
		$query = "INSERT  INTO inventory_updates (quantity,drug_id,outlet_id,submitted_by,status)
		VALUES('$quantity','$drug_id','$outlet_id','$submitted_by','$status')";

		$exequery = mysqli_query($con,$query);
		if($exequery)
		{
				$respose['code'] =1;
				$respose['message'] = " Success";
			 $getdata2 = mysqli_query($con,"SELECT * FROM inventory "); 
			// $rows2 = mysqli_num_rows($getdata2);

			 // $respose = array();

			 // 	// 	if($rows2 > 0 )
				// 	// { 
				// 		$query2 = "SELECT * FROM inventory WHERE id = '$id'"; 
				// 		$exequery2 = mysqli_query($con,$query2);
					// }
					// 	$respose['exequery2'] = $exequery2;

		}
		else
		{
				$respose['code'] =0;
				$respose['message'] = "Failed . Please try again";
		}
	// }
	// else
	// {
	// 			$respose['code'] =0;
	// 			$respose['message'] = "Failed Update : inventory does not exist";
	}
	

	echo json_encode($respose);
?>

