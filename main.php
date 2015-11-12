<?php

    $voteTopic = array(
			"text" => "@" . $_POST[user_name] . " would like to vote on: \n" . "*" . $_POST[text] . "*",
			"mrkdwn" => true
		);

    $data = json_encode($voteTopic);                                                                  	         
   
	$ch = curl_init('https://hooks.slack.com/services/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');                                                                                                                                          
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  #removes "ok" response
	$output = curl_exec($ch);                                                                                                                                                                                                                                                                                                                         
	curl_close($ch);