<?php
require_once('AfricasTalkingGateway.php');
if(isset($_POST["recipient"])){

$username   = "ben10";
$apikey     = "198b485e59a325b210b31c4858e2e7689166a8aa19e78a4f1b1fd77aa80746c0";


$cc = isset($_POST["cc"]) ? $_POST["cc"] : "+254";
$subject = isset($_POST["subject"]) ? $_POST["subject"]."\r\n" : null;
$recipients = $cc.$_POST["recipient"];

$message    = "Thank you for subscribing to Empty 
Jouneys. \r\n We have recieved your payment Ksh 200. Your account has now been activated.";
$message = isset($_POST["message"]) ? $_POST["message"] : $message;

$gateway    = new AfricasTalkingGateway($username, $apikey);


try 
{ 
  $results = $gateway->sendMessage($recipients, $subject.$message);
			
  foreach($results as $result) {
	$handler = fopen("akclogs.txt","a");
	fwrite($handler," Number: " .$result->number);
	fwrite($handler," Status: " .$result->status);
	fwrite($handler," MessageId: " .$result->messageId);
	fwrite($handler," Cost: "   .$result->cost."\r\n");
	fclose($handler);
  }
}
catch ( AfricasTalkingGatewayException $e )
{
  echo "Encountered an error while sending: ".$e->getMessage();
}

}