<?php
 $con = mysqli_connect("localhost","root","afya2017","afyapepe") or die("connection error!");
 $flag = array();
$result = mysqli_query($con,"select *  from prescriptions INNER JOIN appointments on prescriptions.appointment_id=appointments.id INNER JOIN prescription_details on prescriptions.id=prescription_details.id INNER JOIN triage_details on appointments.id=triage_details.appointment_id INNER JOIN diagnoses on prescription_details.id=diagnoses.id INNER JOIN druglists on prescription_details.id=druglists.id INNER JOIN doctors on prescriptions.id=doctors.id ");
$rower=mysqli_fetch_assoc($result);
while($row = mysqli_fetch_assoc($result)){
$flag[] = $row;
}
//print (json_encode($rower['firstname']));

print(json_encode($flag));
mysqli_close($con);