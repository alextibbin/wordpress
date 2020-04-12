<?php
	
	$email_registered = 1;
	global $Mo2fdbQueries;
	$email = get_user_meta(get_current_user_id(),'email',true);
	if(isset($email))
		$email_registered = 1;
	else
		$email_registered = 0;
	include $dirName .'views'.DIRECTORY_SEPARATOR.'twofa'.DIRECTORY_SEPARATOR.'setup_twofa.php';