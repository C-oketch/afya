
<?php
 $con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");
 $flag = array();
$result = mysqli_query($con,"select *  from afya_users INNER JOIN allergies_type on afya_users.id=allergies_type.allergies_id INNER JOIN consultation_fees on allergies_type.allergies_id=consultation_fees.id");
$rower=mysqli_fetch_assoc($result);
while($row = mysqli_fetch_assoc($result)){
$flag[] = $row;
}
//print (json_encode($rower['firstname']));

print(json_encode($flag));
mysqli_close($con);