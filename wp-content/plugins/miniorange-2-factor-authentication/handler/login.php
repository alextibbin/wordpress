<?php 

	class LoginHandler
	{
		function __construct()
		{
			add_action( 'init' , array( $this, 'mo_wpns_init' ) );

			if(get_option('mo2f_enforce_strong_passswords') || get_option('mo_wpns_activate_recaptcha_for_login') 
				|| get_option('mo_wpns_activate_recaptcha_for_woocommerce_login'))
			{

				remove_filter('authenticate'		 , 'wp_authenticate_username_password'				 ,20 );
				add_filter   ('authenticate'		 , array( $this, 'custom_authenticate'		       ) ,1, 3 );
			} 
			if(get_option('mo2f_enable_brute_force'))
			{
				add_action('wp_login'				 , array( $this, 'mo_wpns_login_success' 	       )		);
				add_action('wp_login_failed'		 , array( $this, 'mo_wpns_login_failed'	 	       ) 	    );
				//add_action('auth_cookie_bad_username', array( $this, 'mo_wpns_login_failed'	 	   )		);
				//add_action('auth_cookie_bad_hash'	 , array( $this, 'mo_wpns_login_failed'	 	  	   )		);
			}
                        if(get_option('mo_wpns_activate_recaptcha_for_woocommerce_registration') ){
				add_action( 'woocommerce_register_post', array( $this,'wooc_validate_user_captcha_register'), 1, 3);
			} 
		}	


		function mo_wpns_init()
		{
			global $moWpnsUtility,$dirName;
			$WAFEnabled = get_option('WAFEnabled');
			$WAFLevel = get_option('WAF');

			$mo2f_scanner_parts = new mo2f_scanner_parts();
			$mo2f_scanner_parts->file_cron_scan();

			if($WAFEnabled == 1)
			{
				if($WAFLevel == 'PluginLevel')
				{
					if(file_exists($dirName .'handler'.DIRECTORY_SEPARATOR.'WAF'.DIRECTORY_SEPARATOR.'mo-waf-plugin.php'))
						include_once($dirName .'handler'.DIRECTORY_SEPARATOR.'WAF'.DIRECTORY_SEPARATOR.'mo-waf-plugin.php');
					else
					{
						//UNable to find file. Please reconfigure.
					}
				}
			}
			

				$userIp 			= $moWpnsUtility->get_client_ip();
				$mo_wpns_config = new MoWpnsHandler();
				$isWhitelisted   = $mo_wpns_config->is_whitelisted($userIp);
				$isIpBlocked = false;
				if(!$isWhitelisted){
				$isIpBlocked = $mo_wpns_config->is_ip_blocked_in_anyway($userIp);
				}
				 if($isIpBlocked)
				 	include $dirName . 'views'.DIRECTORY_SEPARATOR.'error'.DIRECTORY_SEPARATOR.'403.php';


				$requested_uri = $_SERVER["REQUEST_URI"];
				$option = false;
				if (is_user_logged_in()) { //chr?
				
					if (strpos($requested_uri, chr((int)get_option('login_page_url'))) != false) {
						wp_redirect(site_url());
						die;
					}
				} else {
					$option = get_option('mo_wpns_enable_rename_login_url');
				}
				if ($option) {
                    if (strpos($requested_uri, '/wp-login.php?checkemail=confirm') !== false) {
                        $requested_uri = str_replace("wp-login.php","",$requested_uri);
                        wp_redirect($requested_uri);
                        die;
                    } else if (strpos($requested_uri, '/wp-login.php?checkemail=registered') !== false) {
                        $requested_uri = str_replace("wp-login.php","",$requested_uri);
                        wp_redirect($requested_uri);
                        die;
                    }
                    
                    if (strpos($requested_uri, '/wp-login.php') !== false) {
						wp_redirect(site_url());
					}
					else if (strpos($requested_uri, get_option('login_page_url')) !== false ) {
						@require_once ABSPATH . 'wp-login.php';
						die;
					}
				}
				
				if(isset($_POST['option']))
				{
						switch($_POST['option'])
						{
							case "mo_wpns_change_password":
								$this->handle_change_password($_POST['username']
									,$_POST['new_password'],$_POST['confirm_password']);		
								break;
						}
				}

		}

		function wooc_validate_user_captcha_register($username, $email, $validation_errors) {
			
			if (empty($_POST['g-recaptcha-response'])) {
				$validation_errors->add( 'woocommerce_recaptcha_error', __('Please verify the captcha', 'woocommerce' ) );
			}
		}

		//Function to Handle Change Password Form
		function handle_change_password($username,$newpassword,$confirmpassword)
		{
			global $dirName;
			$user  = get_user_by("login",$username);
			$error = wp_authenticate_username_password($user,$username,$newpassword);
			
			if(is_wp_error($error))
			{
				$this->mo_wpns_login_failed($username);
				return $error;
			}

			if($this->update_strong_password($username,$newpassword,$confirmpassword)=="success")
			{
				wp_set_auth_cookie($user->ID,false,false);
				$this->mo_wpns_login_success($username);
				wp_redirect(get_option('siteurl'),301);
			} 
		}


		//Function to Update User password
		function update_strong_password($username,$newpassword,$confirmpassword)
		{
			global $dirName;
			
			if(strlen($newpassword) > 5 && preg_match("#[0-9]+#", $newpassword) && preg_match("#[a-zA-Z]+#", $newpassword) 
				&& preg_match('/[^a-zA-Z\d]/', $newpassword) && $newpassword==$confirmpassword)
			{
				$user = get_user_by("login",$username);
				wp_set_password($_POST['new_password'],$user->ID);
				return "success";
			} 
			else
				include $dirName . 'controllers'.DIRECTORY_SEPARATOR.'change-password.php';
		}


		//Our custom logic for user authentication
		function custom_authenticate($user, $username, $password)
		{
			global $moWpnsUtility;
			$error = new WP_Error();

			if(empty($username) && empty ($password))
				return $error;

			if(empty($username)) {
                $error->add('empty_username', __('<strong>ERROR</strong>: Invalid username or Password.'));
			}
			if(empty($password)) {
                $error->add('empty_password', __('<strong>ERROR</strong>: Invalid username or Password.'));
            }

            $user = wp_authenticate_username_password( $user, $username, $password );

			if ( is_wp_error( $user ) ) {
                $error->add('empty_username', __('<strong>ERROR</strong>: Invalid username or Password.'));
                return $user;
            }

			if(empty($error->errors))
			{
				$user  = get_user_by("login",$username);

				if($user)
				{

					if(get_option('mo_wpns_activate_recaptcha_for_login'))
						$recaptchaError = $moWpnsUtility->verify_recaptcha($_POST['g-recaptcha-response']);

					if(!empty($recaptchaError->errors))
						$error = $recaptchaError;
 					if(empty($error->errors)){
						if(!get_option('mo2f_enable_brute_force'))
						{
						   $this->mo_wpns_login_success($username);
						}
						return $user;
					}
				}
				else
					$error->add('empty_password', __('<strong>ERROR</strong>: Invalid Username or password.'));

			}

			return $error;
		}


		//Function to check user password 
		function check_password($user,$error,$password)
		{
			global $moWpnsUtility, $dirName;

			if ( wp_check_password( $password, $user->data->user_pass, $user->ID) )
			{
				if($moWpnsUtility->check_user_password_strength($user,$password,"")=="success")
				{
					if(get_option('mo2f_enable_brute_force'))
						$this->mo_wpns_login_success($user->data->user_login);
					return $user;
				}
				else
					include $dirName . 'controllers'.DIRECTORY_SEPARATOR.'change-password.php';
			}
			else
				$error->add('empty_password', __('<strong>ERROR</strong>: Wrong password.'));

			return $error;
		}


		//Function to handle successful user login
		function mo_wpns_login_success($username)
		{
			global $moWpnsUtility;

				$mo_wpns_config = new MoWpnsHandler();
				$userIp 		= $moWpnsUtility->get_client_ip();

				$mo_wpns_config->move_failed_transactions_to_past_failed($userIp);

				if(get_option('mo_wpns_enable_unusual_activity_email_to_user'))
					$moWpnsUtility->sendNotificationToUserForUnusualActivities($username, $userIp, MoWpnsConstants::LOGGED_IN_FROM_NEW_IP);


				$mo_wpns_config->add_transactions($userIp, $username, MoWpnsConstants::LOGIN_TRANSACTION, MoWpnsConstants::SUCCESS);
		}


		//Function to handle failed user login attempt
		function mo_wpns_login_failed($username)
		{
			global $moWpnsUtility;
				$userIp 		= $moWpnsUtility->get_client_ip();
			
				if(empty($userIp) || empty($username) || !get_option('mo2f_enable_brute_force'))
					return;

				$mo_wpns_config = new MoWpnsHandler();
				$isWhitelisted  = $mo_wpns_config->is_whitelisted($userIp);
				
				$mo_wpns_config->add_transactions($userIp, $username, MoWpnsConstants::LOGIN_TRANSACTION, MoWpnsConstants::FAILED);

				if(!$isWhitelisted)
				{
					

					if(get_option('mo_wpns_enable_unusual_activity_email_to_user'))
							$moWpnsUtility->sendNotificationToUserForUnusualActivities($username, $userIp, MoWpnsConstants::FAILED_LOGIN_ATTEMPTS_FROM_NEW_IP);
					
					$failedAttempts 	 = $mo_wpns_config->get_failed_attempts_count($userIp);
					$allowedLoginAttepts = get_option('mo2f_allwed_login_attempts') ? get_option('mo2f_allwed_login_attempts') : 10;
						
					if($allowedLoginAttepts - $failedAttempts<=0)
						$this->handle_login_attempt_exceeded($userIp);
					else if(get_option('mo2f_show_remaining_attempts')) 
						$this->show_limit_login_left($allowedLoginAttepts,$failedAttempts);
				}
			
		}


		


		//Function to show number of attempts remaining
		function show_limit_login_left($allowedLoginAttepts,$failedAttempts)
		{
			global $error;
			$diff = $allowedLoginAttepts - $failedAttempts;
			$error = "<br>You have <b>".$diff."</b> login attempts remaining.";
		}


		//Function to handle login limit exceeded
		function handle_login_attempt_exceeded($userIp)
		{
			global $moWpnsUtility, $dirName;
			$mo_wpns_config = new MoWpnsHandler();
			$mo_wpns_config->block_ip($userIp, MoWpnsConstants::LOGIN_ATTEMPTS_EXCEEDED, false);
			include $dirName . 'views'.DIRECTORY_SEPARATOR.'error'.DIRECTORY_SEPARATOR.'403.php';
		}

		function setup_registration_closed($user){
			global $Mo2fdbQueries;
			if  ( isset( $_POST['option'] ) and $_POST['option'] == 'mo2f_registration_closed' ) {
				$nonce = $_POST['mo2f_registration_closed_nonce'];
				if ( ! wp_verify_nonce( $nonce, 'mo2f-registration-closed-nonce' ) ) {
					$error = new WP_Error();
					$error->add( 'empty_username', '<strong>' . mo2f_lt( 'ERROR' ) . '</strong>: ' . mo2f_lt( 'Invalid Request.' ) );
					return $error;
				} else {
					if(!$Mo2fdbQueries->get_user_detail( 'mo_2factor_user_registration_status', $user->ID) =='MO_2_FACTOR_PLUGIN_SETTINGS'){
						//$Mo2fdbQueries->update_user_details( $user->ID, array( 'mo_2factor_user_registration_status' => '' ) );
						delete_user_meta( $user->ID, 'register_account_popup' );
					}
				}
			}
		}

	}
	new LoginHandler;
