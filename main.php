<?php

# https://slack.com/api/METHOD

session_start();

$_SESSION['options'] = 0;

$command = $_POST[command]; //incoming command  

$rawData = [];                                                             	        

// initial vote command
if ($command == "/start-poll") { 
	$rawData = [
		"text" => "@" . $_POST[user_name] . " would like to vote on: \n" . "*" . $_POST[text] . "* \n Add voting options by using the _/add-option_ command"
	];
}

if ($command == "/add-options") {
	$optionsArr = explode(",", $_POST[text]); // split input string into array (delimeter is ',')

	$options = "";
	for( $i = 0; $i < count($optionsArr); $i++ ){
		$_SESSION["options"] = $_SESSION["options"] + 1;
		$options = $options . $_SESSION['options'] . ". " . trim($optionsArr[$i]) . "\n" ; // puts options into "1. example" format
	}
	$rawData = [
		"text" => "The current options are: " . "```" . $options . "```"
	];
}

$jsonData = json_encode($rawData); 

// Http POST for writing initial message
$ch = curl_init('https://hooks.slack.com/services/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');                                                                                                                                          
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // post encoded data
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // removes "ok" response
curl_exec($ch);                                                                                                                                                                                                                                                                                                                         
curl_close($ch);