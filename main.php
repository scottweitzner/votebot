<?php

# https://slack.com/api/METHOD
$_SESSION["optionsCount"] = 0;
$_SESSION["optionsString"] = "";
session_start();

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

	for( $i = 0; $i < count($optionsArr); $i++ ){
		$_SESSION["optionsCount"] = $_SESSION["optionsCount"] + 1;
		$_SESSION["optionsString"] = $_SESSION["optionsString"] . $_SESSION['optionsCount'] . ". " . trim($optionsArr[$i]) . "\n" ; // puts options into "1. example" format
	}
	$rawData = [
		"text" => "The current options are: " . "```" . $_SESSION["optionsString"] . "```"
	];
}

$jsonData = json_encode($rawData); 

// Http POST for writing initial message
$ch = curl_init('https://hooks.slack.com/services/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');                                                                                                                                          
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // post encoded data
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // removes "ok" response
curl_exec($ch);                                                                                                                                                                                                                                                                                                                         
curl_close($ch);

session_write_close();