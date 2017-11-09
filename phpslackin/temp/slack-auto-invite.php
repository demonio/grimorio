<?php
	$_POST['email'] = 'raul.montejano@multisitio.es';
	
		// slack invite
	$group = 'phpslackin'; // team name
	$token = 'xoxp-264958587570-265034018724-264329618448-bc7d28282a093e8f8ecdd6cb9af6f55d'; // admin token generated at https://api.slack.com/docs/oauth-test-tokens
	$data = array(
		'email' => $_POST['email'],
		'channels' => '',
		'first_name' => '',
		'token' => trim( $token ),
		'set_active' => 'true',
		'_attempts' => '1',
	);
	$slack_url =  'https://' . $group .'.slack.com';
	$url = $slack_url . '/api/users.admin.invite?t=1';
//url-ify the data for the POST
	foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
//open connection
	$ch = curl_init();
//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
//execute post
	$result = curl_exec($ch);
//close connection
	curl_close($ch);