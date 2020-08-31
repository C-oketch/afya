
<?php
 $con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");
 $flag = array();
$result = mysqli_query($con,"select *  from triage_details INNER JOIN appointments on triage_details.appointment_id=appointments.id");
$rower=mysqli_fetch_assoc($result);
while($row = mysqli_fetch_assoc($result)){
$flag[] = $row;
}
//print (json_encode($rower['firstname']));

print(json_encode($flag));
mysqli_close($con);