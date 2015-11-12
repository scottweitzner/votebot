<?php

    $data = json_encode(array("text" => "Hello " . "@" . $_POST[user_name]));                                                                  	         
   
	$ch = curl_init('https://hooks.slack.com/services/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');                                                                                                                                          
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
	curl_exec($ch);                                                                                                                                                                                                                                                                                                                        
	curl_close($ch);