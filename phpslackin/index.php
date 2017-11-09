<?php
if ( ! empty($_POST['email']) )
{
	include "config.php";

	$data =
	[
		'email' => $_POST['email'],
		'channels' => '',
		'first_name' => '',
		'token' => trim( $token ),
		'set_active' => 'true',
		'_attempts' => '1',
	];
	$fields_string = '';
	foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	$fields_string = rtrim($fields_string, '&');
	#die($fields_string);

	$ch = curl_init();
	$url =  'https://' . $group .'.slack.com/api/users.admin.invite?t=1';
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($data));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	$result = curl_exec($ch);
	curl_close($ch);
}
?><!DOCTYPE html>
<html>
	<head>
		<title>¡Únete a la comunidad de KumbiaPHP en Slack!</title>
		<link href="style.css" rel="stylesheet">
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
	</head>
	<body>
		<div class="splash">
			<div class="logos">
				<div class="logo org"></div>
				<div class="logo slack"></div>
			</div>

			<p>Únase a <b>KumbiaPHP</b> en Slack.</p>

			<p class="status"><b class="active">???</b> usuarios en línea de <b class="total">????</b> registrados.</p>

			<form id="invite" method="post">
				<input type="email" autofocus="true" class="form-item" name="email" placeholder="tu@dominio.com">
				<button>Obtener mi invitación</button>
			</form>

			<p class="signin">o <a href="https://kumbiaphp.slack.com/" target="_top">registrarse</a>.</p>

			<footer>powered by <a href="https://www.kumbiaphp.com/" target="_blank">KumbiaPHP</a></footer>
		</div>
	</body>
</html>