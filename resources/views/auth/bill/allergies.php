
<?php
 $con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");
 $flag = array();
$result = mysqli_query($con,"select allergies.name as allergy,  allergies_type.name as type,allergies_type.updated_at as date from allergies_type INNER JOIN allergies on allergies_type.allergies_id=allergies.id");
//$row=mysqli_fetch_assoc($result);
while($row = mysqli_fetch_assoc($result)){
$flag[] = $row;
}
//print (json_encode($rower['firstname']));

print(json_encode($flag));
mysqli_close($con);