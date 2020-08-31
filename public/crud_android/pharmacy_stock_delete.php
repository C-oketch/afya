<?php 
	//$con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");
$con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");

$id = $_POST['id'];
//$id = 13;

				// 	//$npm = $_POST['npm']; 
				// SELECT
				//   inventory.quantity
				// FROM
				//   inventory
				//   INNER JOIN druglists on inventory.id = druglists.drug_id
				//   INNER JOIN strength on strength.strength = inventory.strength;

				// $getdata = mysqli_query($con,"SELECT * FROM inventory INNER JOIN druglists on 'inventory.id' = 'druglists.drug_id'
				//   INNER JOIN strength on 'strength.strength' = 'inventory.strength'	WHERE 'inventory.id' ='$inventory.id'");
				// 	$rows = mysqli_num_rows($getdata);


	$getdata = mysqli_query($con,"SELECT * FROM inventory WHERE id ='$id'");
	$rows = mysqli_num_rows($getdata);

	$delete = "DELETE FROM inventory WHERE id ='$id'";
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
	//echo $rows;


 ?>