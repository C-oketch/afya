<?php 
	//$con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");
$con = mysqli_connect("localhost","root","","afyapepe") or die("connection error!");

	//$inventory_id = $_POST['inventory_id']; 

	$getdata = mysqli_query($con,"SELECT * FROM inventory WHERE inventory_id ='$inventory_id'");
	$rows = mysqli_num_rows($getdata);

	$delete = "DELETE FROM inventory WHERE inventory_id ='$inventory_id'";
	$exedelete = mysqli_query($con,$delete);

	$respose = array();

	if($rows > 0)
	{
		if($exedelete)
		{
			$respose['code'] =1;
			$respose['message'] = "Delete Success";
		}
		else
		{
		$respose['code'] =0;
		$respose['message'] = "Failed to Delete";
		}
	}
	else
	{
		$respose['code'] =0;
		$respose['message'] = "Failed Delete, data not found";
	}
	


	echo json_encode($respose);

 ?>