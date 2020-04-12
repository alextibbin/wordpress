<?php
	global $Mo2fdbQueries;
	$mo2f_user_email     = $Mo2fdbQueries->get_user_detail( 'mo2f_user_email', $current_user->ID );
	include_once $dirName . 'views'.DIRECTORY_SEPARATOR.'twofa'.DIRECTORY_SEPARATOR.'two_fa_addon.php';
