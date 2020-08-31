
<?php
 $con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");
 $flag = array();
$result = mysqli_query($con,"select *  from patient_test_details INNER JOIN patient_test on patient_test_details.patient_test_id=patient_test.id INNER JOIN tests ON patient_test_details.patient_test_id = tests.id INNER JOIN doctors on prescriptions.id=doctors.id");
$rower=mysqli_fe($con);tch_assoc($result);
while($row = mysqli_fetch_assoc($result)){
$flag[] = $row;
}
//print (json_encode($rower['firstname']));

print(json_encode($flag));
mysqli_close