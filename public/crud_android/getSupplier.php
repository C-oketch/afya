<?php  
	//include_once('connection.php'); 
$con = mysqli_connect("localhost","root","","afyapepe") or die("connection error!");

$drugname=$_POST['drugname'];

// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt select query execution
$sql = "SELECT * FROM druglists";
if($result = mysqli_query($con, $sql)){
    if(mysqli_num_rows($result) > 0){
      
        while($row = mysqli_fetch_array($result)){
          //  echo "<tr>";
                echo  "drugname : ". $row['drugname'] . " ";
               // echo $drugname;
        }
      
        echo json_encode($result);

    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
}
 
// Close connection
mysqli_close($con);
?>

