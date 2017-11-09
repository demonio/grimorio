<?php
	/**
	 * This is a simple script to invite users to your slack
	 * Replace the subdomain and token in the variables below.
	 * Upload a logo called "logo.png" to the same directory for your group
	 * Upload a logo called "slack.png" to the same directory for slack
	 */
	define('SUBDOMAIN','phpslackin');
	define('TOKEN','xoxp-264958587570-265034018724-264329618448-bc7d28282a093e8f8ecdd6cb9af6f55d');
?>

<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	</head>
	<body style="background-color: #252525; width: 100%">
		<div style="text-align: center; margin-top: 75px">
			<div>
				<img src="logo.png" style="width: 150px; height: 150px;" />
				<img src="slack.png" style="width: 150px; height: 150px;" />
			</div>
			<h2 style="font-family: 'Roboto', sans-serif; color: #ffffff">Join <?=SUBDOMAIN?> on Slack!</h2>
			
			<?php
				$showform = false;
				$error = false;
				if (isset($_POST['first'])){
					if (strlen($_POST['first']) > 1 && strlen($_POST['last']) > 1 && strlen($_POST['mail']) > 5){
						sendForm();
					} else {
						$showform = true;
						$error = true;
					}
				} else {
					$showform = true;
				}
			
			if ($showform){
				if ($error){
			?>
			
			<p style="font-family: 'Roboto', sans-serif; color: #9d3d3d">
				Please fill in all fields
			</p>
			
			<?php
					}
					
				showForm();
				}
			?>
		</div>
	</body>
</html>


<?php
	
	function sendForm(){
		$email = $_POST['mail'];
		$first = $_POST['first'];
		$last = $_POST['last'];
		
     $slackInviteUrl='https://'.SUBDOMAIN.'.slack.com/api/users.admin.invite?t='.time();
	    $fields = array(
	            'email' => urlencode($email),
	            'first_name' => urlencode($first),
	            'token' => TOKEN,
	            'set_active' => urlencode('true'),
	            '_attempts' => '1'
	    );
	
	    // url-ify the data for the POST
	            $fields_string='';
	            foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	            rtrim($fields_string, '&');
	
	    // open connection
	            $ch = curl_init();
	
	    // set the url, number of POST vars, POST data
	            curl_setopt($ch,CURLOPT_URL, $slackInviteUrl);
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	            curl_setopt($ch,CURLOPT_POST, count($fields));
	            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	
	    // exec
	            $replyRaw = curl_exec($ch);
	            $reply=json_decode($replyRaw,true);
	            if($reply['ok']==false) {
		            	echo '<p style="font-family: \'Roboto\', sans-serif; color: #9d3d3d">';
	                    echo 'Something went wrong, try again!';
	                    echo '</p>';
	                    showForm();
	            }
	            else {
		            	echo '<p style="font-family: \'Roboto\', sans-serif; color: #719E6F">';
	                    echo 'Invited successfully. Check your email. It should arrive within a couple minutes';
	                    echo '</p>';
	            }
	
	    // close connection
	            curl_close($ch);		
	}
	
	function showForm(){
		
		?>
		
			<form method="post">
				<p style="font-family: 'Roboto', sans-serif; color: #ffffff">
					First Name
				</p>
				
				<input type="text" name="first" style="width: 250px; " <?php echo strlen($_POST['first']) > 0 ? 'value="'.$_POST['first'].'"' : ''; ?> />
				
				<p style="font-family: 'Roboto', sans-serif; color: #ffffff">
					Last Name
				</p>
				<input type="text" name="last" style="width: 250px; " <?php echo strlen($_POST['last']) > 0 ? 'value="'.$_POST['last'].'"' : ''; ?> />
				<p style="font-family: 'Roboto', sans-serif; color: #ffffff">
					Email address
				</p>
				<input type="text" name="mail" style="width: 250px; " <?php echo strlen($_POST['mail']) > 0 ? 'value="'.$_POST['mail'].'"' : ''; ?> />
				<p>
					<input type="submit" value="Sign me up!" />
				</p>
			</form>
			
		<?php		
		
	}