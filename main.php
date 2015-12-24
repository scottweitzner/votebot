<?php

# https://slack.com/api/METHOD
session_start();

$command = $_POST[command]; //incoming command  
$channel = $_POST[channel_name];

$rawData["channel"] = "#" . $channel;   

file_put_contents('gs://#default#/' . $channel . '.txt', $rawData);

// initial vote command
if ($command == "/start-poll") { 

	$data = fopen('gs://#default#/' . $channel . '.txt', 'r');
	if ($data = false) {
		$rawData["text"]= "@" . $_POST[user_name] . " would like to vote on: \n" . "*" . $_POST[text] . "* \n Add voting options by using the _/add-option_ command";
	} else {
		$rawData["text"] = "There is already a poll open in this channel. You must close that poll first before starting a new one";
	}
}

if ($command == "/add-options") {
	$optionsArr = explode(",", $_POST[text]); // split input string into array (delimeter is ',')

	for( $i = 0; $i < count($optionsArr); $i++ ){
		$_SESSION["optionsCount"] = $_SESSION["optionsCount"] + 1;
		$_SESSION["optionsString"] = $_SESSION["optionsString"] . "*" . $_SESSION['optionsCount'] . ".* " . trim($optionsArr[$i]) . "\n" ; // puts options into "1. example" format
	}
	$rawData["text"] = "The current options are: \n" . ">>>" . $_SESSION["optionsString"] ;
}

$jsonData = json_encode($rawData); 

// Http POST for writing initial message
$ch = curl_init('https://hooks.slack.com/services/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');                                                                                                                                          
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // post encoded data
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // removes "ok" response
curl_exec($ch);                                                                                                                                                                                                                                                                                                                         
curl_close($ch);


session_write_close();