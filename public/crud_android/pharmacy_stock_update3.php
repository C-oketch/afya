<?php  
	//include_once('connection.php'); 
$con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");


$id = $_POST['id'];
$drug_id = $_POST['drug_id'];
$quantity = $_POST['quantity'];
$submitted_by = $_POST['submitted_by'];
$outlet_id = $_POST['outlet_id'];
$status = $_POST['status'];
$created_at = $_POST['created_at'];
$updated_at = $_POST['updated_at'];
//$strength = $_POST['strength'];

 // $id = 2;

	// $quantity =300;

	$getdata = mysqli_query($con,"SELECT * FROM inventory_updates WHERE id ='$id'"); 
	$rows = mysqli_num_rows($getdata);
	
	$respose = array();

	if($rows > 0 )
	{//$query = "UPDATE tb_mahasiswa SET nama='$nama',prodi='$prodi',fakultas='$fakultas' WHERE npm='$npm'";


		$query = "UPDATE inventory_updates SET quantity='$quantity',  WHERE id='$id'";
		$exequery = mysqli_query($con,$query);
		if($exequery)
		{
				$respose['code'] =1;
				$respose['message'] = "Update Success";
		}
		else
		{
				$respose['code'] =0;
				$respose['message'] = "Failed Update. Please try again";
		}
	}
	else
	{
				$respose['code'] =0;
				$respose['message'] = "Failed Update : inventory does not exist";
	}
	

	echo json_encode($respose);
?>