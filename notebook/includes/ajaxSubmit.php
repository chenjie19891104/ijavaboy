<?php

/*  RECEIVE POST   */
$email=$_POST['email']; $name=$_POST['name']; $message=$_POST['message']; $youremail=$_POST['ctyouremail']; $subject=$_POST['ctsubject'];

/* RETURN ERROR */

$arrayError[0][0] = "#email";			// FIELDID 
$arrayError[0][1] = "Your email do not match.. whatever it need to match"; 	// TEXT ERROR	
$arrayError[0][2] = "error";			// BOX COLOR

$arrayError[1][0] = "#age";				// FIELD
$arrayError[1][1] = "Your email do not match.. whatever it need to match"; 	// TEXT ERROR	
$arrayError[1][2] = "error";			// BOX COLOR

$isValidate = true;  // RETURN TRUE FROM VALIDATING, NO ERROR DETECTED

/* THIS NEED TO BE IN YOUR FILE NO MATTERS WHAT */
if($isValidate == true){
	$to = "$youremail";
	$subject = "$subject";
	$msg = "$message";
	$headers = "From: $name <$email>" . "\r\n" .
		"Reply-To: $email" . "\r\n" .
		"X-Mailer: PHP/" . phpversion();
	mail ($to, $subject, $msg, $headers);
	echo "true";
}else{
	echo '{"jsonValidateReturn":'.json_encode($arrayError).'}';		// RETURN ARRAY WITH ERROR
}
?>