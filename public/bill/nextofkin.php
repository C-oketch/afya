
<?php
 $con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");
 $flag = array();
$result = mysqli_query($con,"select *  from kin_details INNER JOIN afya_users on kin_details.afya_user_id=afya_users.id");
$rower=mysqli_fetch_assoc($result);
while($row = mysqli_fetch_assoc($result)){
$flag[] = $row;
}
//print (json_encode($rower['firstname']));

print(json_encode($flag));
mysqli_close($con);