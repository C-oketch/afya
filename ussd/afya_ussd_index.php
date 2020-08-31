<?php

	ob_start ();
	date_default_timezone_set ( 'Africa/Nairobi' );
	error_reporting ( E_ALL );
	require_once '../classes/Processor.php';
	require_once '../classes/conn.php';
	require_once '../classes/AfricasTalkingGateway.php';
	//require_once('config.php');

	$db = new Database ();
	$username = "semanami";
	$apikey = "777b4a77238980b8e832720bb8802eaf3c4de76570f32b6a112d3c79d3e8c958";
	$sessionId = $_REQUEST ['sessionId'] ? $_REQUEST ['sessionId'] : '';
	$msisdn = $_REQUEST ['phoneNumber'] ? $_REQUEST ['phoneNumber'] : '';
	$scode = $_REQUEST ['serviceCode'] ? $_REQUEST ['serviceCode'] : '';
	$ussdString = $_REQUEST ['text'] ? $_REQUEST ['text'] : '';
	$msisdn = str_replace ( "+", "", $msisdn );
	$requestDate = date("Y-m-d H:m:s");
	$gateway = new AfricasTalkingGateway ( $username, $apikey );
	$regStatus = Processor::getRegistrationStatus ( $db, $msisdn );
	$prevInput = Processor::getSessionString ($db,$msisdn );
	$input = Processor::getInput ( $ussdString );
	$recipients = "+".$msisdn;

	$prevInput = $prevInput . "*" . $input;
	$menu = explode ( "*", $prevInput );
	$useme = explode ( "*", $prevInput );
	$level = count ( $menu );
	$from = "+254711082000";
	$to = $recipients;


	if (! $regStatus)
	{

	if ($ussdString == "")
	{
	Processor::clearSessions($db, $msisdn);
	Processor::createSessions ($db, $msisdn, $sessionId, $ussdString);

	$response = "CON Welcome to AFYA PEPE, a free health records management platform. ";
	$response.="\nPlease start by signing up.";
	$response .= "\nWhat is your first name?";

	}

	elseif ($level == 2)
	{

	if (!ctype_alpha($input))
	{
	$response="CON AFYA PEPE \nPlease use letters. ";
	$response .= "What is your first name?";

	unset ($useme[1]);
	$in = implode ( "*", $useme );
	Processor::updateSessions ( $db, $msisdn, $in );
	}

	else
	{

	$response = "CON AFYA PEPE\nWhat is your second name?";
	Processor::updateSessions($db,$msisdn,$prevInput);
	}

	}

	elseif ($level == 3)
	{

	if (!ctype_alpha($input))
	{
	$response="CON AFYA PEPE\n Please use letters.";
	$response .= "What is your second name?";

	unset ( $useme [2] );
	$in = implode ( "*", $useme );
	Processor::updateSessions ( $db, $msisdn, $in );

	}

	else
	{

	$response = "CON AFYA PEPE\nHow old are you? \nNote: This service is not allowed for people under the age of 13.";
	Processor::updateSessions($db, $msisdn, $prevInput );
	}

	}

	elseif ($level == 4)
	{

	if (! is_numeric($input))
	{

	$response = "CON  AFYA PEPE\nInvalid input.\n";

	$response .= "Please input a correct age.";
	unset ( $useme [3] );
	$in = implode ( "*", $useme );
	Processor::updateSessions ( $db, $msisdn, $in );

	}

	else if ($input <= 12 || $input > 120)
	{

	$response = "END AFYA PEPE\nYou are not eligible for this service.";
	Processor::updateSessions ( $db, $msisdn, $prevInput );

	}

	else
	{

	$response = "CON AFYA PEPE\nPlease select your gender.";
	$response .= "\n 1.Male";
	$response .= "\n 2.Female";
	Processor::updateSessions ( $db,$msisdn,$prevInput );

	}

	}

	elseif($level ==5)
	{
	$gender = "";
	switch ($input)
	{
	case 1 :
	$menu [4] = "Male";
	break;
	case 2 :
	$menu [4] = "Female";
	break;
	}



	Processor::updateSessions ( $db, $msisdn, $prevInput );
	if ($input <= 0 || $input > 2)
	{

	$response = "CON Invalid Option. Please choose your gender.";
	$response .= "\n1. Male";
	$response .= "\n2. Female";
	unset ( $useme [4] );
	$in = implode ( "*", $useme );
	Processor::updateSessions ( $db, $msisdn, $in );

	}

	else
	{

	$response = "CON AFYA PEPE\nEnter your 4 digit PIN.";
	Processor::updateSessions ( $db,$msisdn,$prevInput );

	}

	}


	elseif ($level == 6)
	{


	if ((!is_int($input) && strlen($input)> 4) || (!is_int($input) && strlen($input)< 4))
	{

	$response = "CON AFYA PEPE\nInvalid Option. Enter your 4 digit PIN using numbers.";

	unset ( $useme [5] );
	$in = implode ( "*", $useme );
	Processor::updateSessions ( $db, $msisdn, $in );

	}

	else
	{

	$fname = $menu [1];
	$lname = $menu [2];
	$age = $menu [3];
	$gender = $menu [4];
	$pi = md5($menu[5]);
	$pi2 = $menu[5];
	$phone = $msisdn;

	$id = $phone;
	$name = $fname." ".$lname;
	$username = $phone;
	$role = "user";
	$password = md5($phone);


	/*
	$query = mysqli_query($link,"INSERT INTO afya_users (firstname, secondName, gender, age, msisdn, pin) VALUES
	 ('$fname','$lname','$gender','$age','$phone','$pi') ");

	 if(!$query)
	 {
	 echo(mysqli_error($link));
	 }
	 */

	if (Processor::registerUser($db,$fname,$lname,$gender,$age,$phone,$pi) == true)
	{

	// sms is sent only if registration is successful

		$message = "Registration Successful.Your PIN is ".$pi2." Dial *384*4567# to use this service.";
		try {

			$results = $gateway->sendMessage ( $recipients, $message );
			foreach ( $results as $result )
			{
				// Note that only the Status "Success" means the message was sent
				$number = $result->number;
				$status = $result->status;
				$message = $result->messageId;
				$cost = $result->cost;

				$func3 = Processor::smsLogs ( $db, $recipients, $status, $message, $cost );


			}



		} catch ( AfricasTalkingGatewayException $e ) {
			$error1= $e->getMessage ();
		}

	$response = "END AFYAPEPE\nRegistration Successful!";

	Processor::updateSessions ( $db,$msisdn,$prevInput );
	Processor::clearSessions ( $db, $msisdn );

	}

	else
	{

	$response = "END AFYA PEPE\nThere was an error in the registration. Please try again";
	}
	}

	}


	}



	else
	{
	if($ussdString=="")
	{

	Processor::clearSessions($db, $msisdn);
	Processor::createSessions ($db, $msisdn, $sessionId, $ussdString);
	$response= "CON Welcome to AFYA PEPE, Karibu kwa huduma ya AFYA PEPE.\nChoose a language, Chagua lugha.\n1.English \n2.Kiswahili";

	}


	elseif (substr($ussdString, 0, 1) == "2")
	{

	if ($ussdString == "2")
	{

	Processor::clearSessions($db, $msisdn);
	Processor::createSessions ($db, $msisdn, $sessionId, $ussdString);

	}


	if($level==2)
	{

	$response="CON Andika nambari ya hospitali ama duka la dawa ambalo umeingia.";

	Processor::updateSessions($db,$msisdn,$prevInput);

	}

	if($level==3)
	{

	//NOTE ............ Hospital has 1 before the facility code.

	$temp_int = substr($input,1);//this is facility or hospital code.
	$int2 = substr($input,0,1);// first integer by user

	if($int2 == 1)
	{

	$res=$db->Select("SELECT FacilityCode FROM facilities WHERE FacilityCode='$temp_int'");

	if(count($res)==0 || count($res)<0)
	{

	$response="CON Nambari uliyoandika sio sahihi.Andika nambari ya hospitali ama duka la dawa ambalo umeingia.";
	unset($menu[2]);
	$in=implode("*",$menu);
	Processor::updateSessions($db,$msisdn,$in);

	}


	else
	{

	$response = "CON Andika nambari yako ya siri.";
	Processor::updateSessions($db,$msisdn,$prevInput);


	}
	}

	elseif($int2 == 2)
	{

	$res=$db->Select("SELECT PremiseID FROM pharmacy WHERE PremiseID = '$temp_int'");

	if(count($res)==0 || count($res)<0)
	{

	$response="CON Nambari uliyoandika sio sahihi.Andika nambari ya hospitali ama duka la dawa ambalo umeingia.";
	unset($menu[2]);
	$in=implode("*",$menu);
	Processor::updateSessions($db,$msisdn,$in);

	}


	else
	{

	$response = "CON Andika nambari yako ya siri..";
	Processor::updateSessions($db,$msisdn,$prevInput);


	}

	}

	else
	{

	$response="CON Nambari uliyoandika sio sahihi.Andika nambari ya hospitali ama duka la dawa ambalo umeingia.";
	unset($menu[2]);
	$in=implode("*",$menu);
	Processor::updateSessions($db,$msisdn,$in);

	}

	}

	elseif($level == 4)
	{

	$res= $db->Select("SELECT pin FROM afya_users WHERE msisdn = '".$msisdn."' ");
	$siri = $res[0]['pin'];
	$input = md5($input);

	if($siri != $input)
	{

	$response = "CON Andika nambari yako ya siri iliyo sahihi.";
	unset($menu[3]);
	$in=implode("*",$menu);
	Processor::updateSessions($db,$msisdn,$in);

	}

	else
	{

	$input = $menu[2];
	$temp = substr($input,0,1);
	$temp_int = substr($input,1);//this is facility or hospital code.It has 1 preprended to show its a hospital
	$message = $temp_int;

	Processor::addRecord($db,$msisdn,$sessionId,$message);

	Processor::updateSessions($db,$msisdn,$prevInput);

	if($temp == 1)
	{
	$res=$db->Select("SELECT FacilityName FROM facilities WHERE FacilityCode='$temp_int'");
	$hosi = $res[0]['FacilityName'];

	$response="END Asante kwa kuja ".$hosi." .Utahudumiwa hivi punde.";

	}

	elseif($temp == 2)
	{

	$res=$db->Select("SELECT Name FROM pharmacy WHERE PremiseID = '$temp_int'");
	$hosi = $res[0]['Name'];

	$response="END Asante kwa kuja ".$hosi." .Utahudumiwa hivi punde.";

	}


	}

	Processor::clearSessions($db, $msisdn);

	}

	}


	elseif(substr($ussdString,0,1)=="1")
	{

	if ($ussdString == "1")
	{

	Processor::clearSessions($db, $msisdn);
	Processor::createSessions ($db, $msisdn, $sessionId, $ussdString);

	}


	if($level==2)
	{

	$response="CON Enter the number of the facility you are visiting.";

	Processor::updateSessions($db,$msisdn,$prevInput);

	}

	if($level==3)
	{
	$input = $menu[2];

	$temp_int = substr($input,1);//this is facility or hospital code.
	$int2 = substr($input,0,1);// first integer by user

	if($int2 == 1)
	{

	$res=$db->Select("SELECT FacilityCode FROM facilities WHERE FacilityCode='$temp_int'");

	if(count($res)==0 || count($res)<0)
	{

	$response="CON Invalid input.\nEnter the number of the facility you are visiting.";
	unset($menu[2]);
	$in=implode("*",$menu);
	Processor::updateSessions($db,$msisdn,$in);

	}


	else
	{

	$response = "CON Enter your PIN.";
	Processor::updateSessions($db,$msisdn,$prevInput);


	}
	}

	elseif($int2 == 2)
	{

	$res=$db->Select("SELECT PremiseID FROM pharmacy WHERE PremiseID = '$temp_int'");

	if(count($res)==0 || count($res)<0)
	{

	$response="CON Invalid input.\nEnter the number of the facility you are visiting.";
	unset($menu[2]);
	$in=implode("*",$menu);
	Processor::updateSessions($db,$msisdn,$in);

	}


	else
	{

	$response = "CON Enter your PIN..";
	Processor::updateSessions($db,$msisdn,$prevInput);


	}

	}

	else
	{

	$response="CON Invalid input.\nEnter the number of the facility you are visiting.";
	unset($menu[2]);
	$in=implode("*",$menu);
	Processor::updateSessions($db,$msisdn,$in);

	}

	}

	if($level == 4)
	{

	$res= $db->Select("SELECT pin FROM afya_users WHERE msisdn = '".$msisdn."' ");
	$siri = $res[0]['pin'];
	$input = md5($input);

	if($siri != $input)
	{

	$response = "CON Incorrect input.\nEnter your PIN.";
	unset($menu[3]);
	$in=implode("*",$menu);
	Processor::updateSessions($db,$msisdn,$in);

	}

	else
	{

	$input = $menu[2];
	$temp = substr($input,0,1);
	$temp_int = substr($input,1);//this is facility or hospital code.
	$message = $temp_int;

	Processor::addRecord($db,$msisdn,$sessionId,$message);

	Processor::updateSessions($db,$msisdn,$prevInput);

	if($temp == 1)
	{
	$res=$db->Select("SELECT FacilityName FROM facilities WHERE FacilityCode='$temp_int'");
	$hosi = $res[0]['FacilityName'];

	$response="END  Thank you for visiting ".$hosi.". You will be attended to shortly.";

	}

	elseif($temp == 2)
	{

	$res=$db->Select("SELECT Name FROM pharmacy WHERE PremiseID = '$temp_int'");
	$hosi = $res[0]['Name'];

	$response="END  Thank you for visiting ".$hosi.". You will be attended to shortly.";

	}


	}

	Processor::clearSessions($db, $msisdn);

	}


	}

	else
	{

	if($ussdString !='*1' || $ussdString !='*2' )
	{
	$response= "END INVALID OPTION Please choose either \n1. For English \n2. For Kiswahili";
	}


	}



	}

	header('Content-type: text/plain');
	echo $response." ";
	$responseDate = date ( "Y-m-d H:m:s" );
	Processor::ussdLogs ( $db, $msisdn, $sessionId, $scode, $ussdString, $response, $requestDate, $responseDate );


	function validateDate($date)
	{

	$d = DateTime::createFromFormat('Y-m-d', $date);
	return $d && $d->format('Y-m-d') == $date;

	}


?>
