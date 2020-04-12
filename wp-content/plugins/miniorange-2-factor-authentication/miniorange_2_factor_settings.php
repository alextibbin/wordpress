<?php
/**
 * Plugin Name: miniOrange 2 Factor Authentication
 * Plugin URI: https://miniorange.com
 * Description: This plugin provides various two-factor authentication methods as an additional layer of security after the default wordpress login. We Support Google/Authy/LastPass Authenticator, QR Code, Push Notification, Soft Token and Security Questions(KBA) for 1 User in the free version of the plugin.
 * Version: 5.3.23
 * Author: miniOrange
 * Author URI: https://miniorange.com
 * License: GPL2
 */
	define( 'MO_HOST_NAME', 'https://login.xecurify.com' );
	define( 'MO2F_VERSION', '5.3.23' );
	define( 'MO2F_TEST_MODE', false );
	class Miniorange_twoFactor{

		function __construct()
		{
			register_deactivation_hook(__FILE__		 , array( $this, 'mo_wpns_deactivate'		       )		);
			register_activation_hook  (__FILE__		 , array( $this, 'mo_wpns_activate'			       )		);
			add_action( 'admin_menu'				 , array( $this, 'mo_wpns_widget_menu'		  	   )		);
			add_action( 'admin_enqueue_scripts'		 , array( $this, 'mo_wpns_settings_style'	       )		);
			add_action( 'admin_enqueue_scripts'		 , array( $this, 'mo_wpns_settings_script'	       )	    );
			add_action( 'wpns_show_message'		 	 , array( $this, 'mo_show_message' 				   ), 1 , 2 );
			add_action( 'wp_footer'					 , array( $this, 'footer_link'					   ),100	);
             add_action( 'admin_footer', array( $this, 'feedback_request' ) );
             add_action('admin_notices',array( $this, 'mo_wpns_malware_notices' ) );
			if(get_option('mo2f_disable_file_editing')) 	 define('DISALLOW_FILE_EDIT', true);
			$this->includes();
			if(get_option("mo_wpns_2fa_with_network_security"))
			{
				$notify = new miniorange_security_notification;
			    add_action('wp_dashboard_setup', array($notify,'my_custom_dashboard_widgets'));
			}
		}
        // As on plugins.php page not in the plugin
        function feedback_request() {
            if ( 'plugins.php' != basename( $_SERVER['PHP_SELF'] ) ) {
                return;
            }
            global $dirName;

             $email = get_option("mo2f_email");
            if(empty($email)){
                $user = wp_get_current_user();
                $email = $user->user_email;
            }
            $imagepath=plugins_url( '/includes/images/', __FILE__ );

            wp_enqueue_style( 'wp-pointer' );
            wp_enqueue_script( 'wp-pointer' );
            wp_enqueue_script( 'utils' );
            wp_enqueue_style( 'mo_wpns_admin_plugins_page_style', plugins_url( '/includes/css/style_settings.css?ver=4.8.60', __FILE__ ) );

            include $dirName . 'views'.DIRECTORY_SEPARATOR.'feedback_form.php';;

        }
		function mo_wpns_malware_notices(){
			$args=array();
			$theme_current= wp_get_themes($args);
			$theme_last = get_option('mo_wpns_last_themes');
			$flag_theme = 0;
			if(is_array($theme_last)){
				if(sizeof($theme_current) == sizeof($theme_last)){
					foreach ($theme_current as $key => $value) {
						if($theme_current[$key] != $theme_last[$key]){
							$flag_theme=1;
							break;
						}
					}
				}else{
					$flag_theme=1;
				}
			}else{
				$flag_theme=1;
			}

			$plugins_found = get_plugins();
			$plugin_last = get_option('mo_wpns_last_plugins');
			$flag_plugin = 0;
			if(is_array($plugin_last)){
				if(sizeof($plugins_found) == sizeof($plugin_last)){
					foreach ($plugins_found as $key => $value) {
						if($plugins_found[$key] != $plugin_last[$key]){
							$flag_plugin=1;
							break;
						}
					}
				}else{
					$flag_plugin=1;
				}
			}else{
				$flag_plugin=1;
			}
		    $days =(time()-get_option('mo_wpns_last_scan_time'))/(60*60*24);
		    $days = (int)$days;

		    $day_infected= (time()-get_option('infected_dismiss'))/(60*60*24);
		    $day_infected = floor($day_infected);
		    $day_weekly= (time()-get_option('weekly_dismiss'))/(60*60*24);
		    $day_weekly = floor($day_weekly);

		    	
		    if(get_option('mo_wpns_2fa_with_network_security'))
		    {
		    	if(!get_option('donot_show_infected_file_notice') && (get_option('mo_wpns_infected_files') != 0) && ($day_infected >= 1)){
	        		do_action('wpns_show_message',MoWpnsMessages::showMessage('INFECTED_FILE'),'CUSTOM_MESSAGE');
		    	}else if(!get_option('donot_show_new_plugin_theme_notice') && ($flag_plugin || $flag_theme)){
	        		do_action('wpns_show_message',MoWpnsMessages::showMessage('NEW_PLUGIN_THEME_CHECK'),'CUSTOM_MESSAGE');
		    	}else if(!get_option('donot_show_weekly_scan_notice') && ($days >= 7) && ($day_weekly >= 1)){
	        		do_action('wpns_show_message',MoWpnsMessages::showMessage('WEEKLY_SCAN_CHECK'),'CUSTOM_MESSAGE');
	        	}
        	}
        }

		function mo_wpns_widget_menu()
		{
			$menu_slug = 'mo_2fa_two_fa';
			
			add_menu_page (	'miniOrange 2-Factor' , 'miniOrange 2-Factor' , 'activate_plugins', $menu_slug , array( $this, 'mo_wpns'), plugin_dir_url(__FILE__) . 'includes/images/miniorange_icon.png' );
		if(get_option('mo_wpns_2fa_with_network_security'))
		{
			add_submenu_page( $menu_slug	,'miniOrange 2-Factor'	,'Dashboard'		    ,'administrator','mo_2fa_dashboard'			, array( $this, 'mo_wpns'));
		}
			add_submenu_page( $menu_slug	,'miniOrange 2-Factor'	,'Two Factor'		   	,'administrator','mo_2fa_two_fa'			, array( $this, 'mo_wpns'));
		if(get_option('mo_wpns_2fa_with_network_security'))
		{
			add_submenu_page( $menu_slug	,'miniOrange 2-Factor'	,'Firewall'		   		,'administrator','mo_2fa_waf'				, array( $this, 'mo_wpns'));
			add_submenu_page( $menu_slug	,'miniOrange 2-Factor'	,'Login and Spam'		,'administrator','mo_2fa_login_and_spam'	, array( $this, 'mo_wpns'));
            add_submenu_page( $menu_slug	,'miniOrange 2-Factor'	,'Backup'				,'administrator','mo_2fa_backup'			, array( $this, 'mo_wpns'));
            add_submenu_page( $menu_slug	,'miniOrange 2-Factor'	,'Malware Scan'			,'administrator','mo_2fa_malwarescan'  		, array( $this, 'mo_wpns'));
            add_submenu_page( $menu_slug	,'miniOrange 2-Factor'	,'Advanced Blocking'	,'administrator','mo_2fa_advancedblocking'	, array( $this, 'mo_wpns'));
            add_submenu_page( $menu_slug	,'miniOrange 2-Factor'	,'Notifications'		,'administrator','mo_2fa_notifications'		, array( $this, 'mo_wpns'));
            add_submenu_page( $menu_slug	,'miniOrange 2-Factor'	,'Reports'				,'administrator','mo_2fa_reports'			, array( $this, 'mo_wpns'));
        }
            
            add_submenu_page( $menu_slug	,'miniOrange 2-Factor'	,'Troubleshooting'		,'administrator','mo_2fa_troubleshooting'	, array( $this, 'mo_wpns'));
            add_submenu_page( $menu_slug	,'miniOrange 2-Factor'	,'Account'				,'administrator','mo_2fa_account'			, array( $this, 'mo_wpns'));
	    add_submenu_page( $menu_slug	,'miniOrange 2-Factor'	,'Upgrade'				,'administrator','mo_2fa_upgrade'			, array( $this, 'mo_wpns'));		 
       }
		
		function checkSecurity(){
			
			$guestcustomer = new Customer_Setup();
			
			$guestcustomer->guest_audit();
		}
		
		function mo_wpns()
		{
			
			global $wpnsDbQueries,$Mo2fdbQueries;
			$wpnsDbQueries->mo_plugin_activate();
			$Mo2fdbQueries->mo_plugin_activate();
			
			add_option( 'mo2f_enable_brute_force' , false);
			add_option( 'mo2f_show_remaining_attempts' , false);
			add_option( 'mo_wpns_enable_ip_blocked_email_to_admin', false);
			add_option('SQLInjection', 1);
			add_option('WAFEnabled' ,0);
			add_option('XSSAttack' ,1);
			add_option('RFIAttack' ,0);
			add_option('LFIAttack' ,0);
			add_option('RCEAttack' ,0);
			add_option('actionRateL',0);
			add_option('Rate_limiting',0);
			add_option('Rate_request',240);
			add_option('limitAttack',10);
			add_option( 'mo_wpns_check_vulnerable_code', 1);
			add_option( 'mo_wpns_check_sql_injection', 1);
			add_option( 'mo_wpns_scan_plugins', true);
			add_option( 'mo_wpns_scan_themes', true);
			include 'controllers/main_controller.php';
		}

		function mo_wpns_activate()
		{
			$this->checkSecurity();
			global $wpnsDbQueries,$Mo2fdbQueries;
			$wpnsDbQueries->mo_plugin_activate();
			$Mo2fdbQueries->mo_plugin_activate();
			add_option( 'mo2f_activate_plugin', 1 );
			add_option( 'mo2f_login_option', 1 );
			add_option( 'mo2f_is_NC', 1 );
			add_option( 'mo2f_is_NNC', 1 );
			add_option( 'mo2f_number_of_transactions', 1 );
			add_option( 'mo2f_set_transactions', 0 );
			add_option( 'mo2f_enable_forgotphone', 1 );
			add_option( 'mo2f_enable_2fa_for_users', 1 );
			add_option( 'mo2f_enable_2fa_prompt_on_login_page', 0 );
			add_option( 'mo2f_enable_xmlrpc', 0 );
			add_option( 'mo2fa_administrator',1 );
			add_option( 'mo2f_custom_plugin_name','miniOrange 2-Factor' );
			add_action( 'mo_auth_show_success_message', array($this, 'mo_auth_show_success_message'), 10, 1 );
			add_action( 'mo_auth_show_error_message', array($this, 'mo_auth_show_error_message'), 10, 1 );
			add_option( 'mo2f_show_sms_transaction_message', 0 );
			add_option( 'mo2f_enforce_strong_passswords_for_accounts' ,'all');
			add_option('mo2f_scan_initialize',1);
			add_option( 'mo_wpns_last_scan_time', time());
			add_option( 'mo_wpns_2fa_with_network_security' , 1);
			add_option( 'mo_wpns_2fa_with_network_security_popup_visible', 1);
			
			 
                
            			

		}

		function mo_wpns_deactivate() 
		{
			global $moWpnsUtility;
			if( !$moWpnsUtility->check_empty_or_null( get_option('mo_wpns_registration_status') ) ) {
				delete_option('mo2f_email');
			}
			update_option('mo2f_activate_plugin', 1);
			delete_option('mo2f_customerKey');
			delete_option('mo2f_api_key');
			delete_option('mo2f_customer_token');
			delete_option('mo_wpns_transactionId');
			delete_option('mo_wpns_registration_status');
			$two_fa_settings = new Miniorange_Authentication();
			$two_fa_settings->mo_auth_deactivate();
		}

		function mo_wpns_settings_style($hook)
		{
			if(strpos($hook, 'page_mo_2fa')){
				wp_enqueue_style( 'mo_wpns_admin_settings_style'			, plugins_url('includes/css/style_settings.css', __FILE__));
				wp_enqueue_style( 'mo_wpns_admin_settings_phone_style'		, plugins_url('includes/css/phone.css', __FILE__));
				wp_enqueue_style( 'mo_wpns_admin_settings_datatable_style'	, plugins_url('includes/css/jquery.dataTables.min.css', __FILE__));
				wp_enqueue_style( 'mo_wpns_button_settings_style'			, plugins_url('includes/css/button_styles.css',__FILE__));
				wp_enqueue_style( 'mo_wpns_popup_settings_style'			, plugins_url('includes/css/popup.css',__FILE__));
			}

		}

		function mo_wpns_settings_script($hook)
		{
			wp_enqueue_script( 'mo_wpns_admin_settings_script'			, plugins_url('includes/js/settings_page.js', __FILE__ ), array('jquery'));
			if(strpos($hook, 'page_mo_2fa')){
				wp_enqueue_script( 'mo_wpns_admin_settings_phone_script'	, plugins_url('includes/js/phone.js', __FILE__ ));
				wp_enqueue_script( 'mo_wpns_admin_datatable_script'			, plugins_url('includes/js/jquery.dataTables.min.js', __FILE__ ), array('jquery'));
				wp_enqueue_script( 'mo_wpns_qrcode_script', plugins_url( "/includes/jquery-qrcode/jquery-qrcode.js", __FILE__ ) );
				wp_enqueue_script( 'mo_wpns_min_qrcode_script', plugins_url( "/includes/jquery-qrcode/jquery-qrcode.min.js", __FILE__ ) );
			}
		}
		function mo_show_message($content,$type) 
		{
			if($type=="CUSTOM_MESSAGE")
				echo $content;
			if($type=="NOTICE")
				echo '	<div class="is-dismissible notice notice-warning"> <p>'.$content.'</p> </div>';
			if($type=="ERROR")
				echo '	<div class="notice notice-error is-dismissible"> <p>'.$content.'</p> </div>';
			if($type=="SUCCESS")
				echo '	<div class="notice notice-success is-dismissible"> <p>'.$content.'</p> </div>';
		}

		function footer_link()
		{
			echo MoWpnsConstants::FOOTER_LINK;
		}

		function includes()
		{
			require('helper/pluginUtility.php');
			require('database/database_functions.php');
			require('database/database_functions_2fa.php');
			require('helper/utility.php');
			require('handler/ajax.php');
			require('api/class-customer-setup.php');
			require('api/class-rba-attributes.php');
			require('api/class-two-factor-setup.php');
			require('handler/backup.php');
			require('handler/security_features.php');
			require('handler/feedback_form.php');
			require('handler/recaptcha.php');
			require('handler/login.php');
			require('handler/twofa/setup_twofa.php');
			require('handler/twofa/two_fa_settings.php');
			require('handler/twofa/two_fa_utility.php');
			require('handler/twofa/two_fa_constants.php');
			require('handler/registration.php');
			require('handler/logger.php');
			require('handler/spam.php');
			require('helper/dashboard_security_notification.php');
			require('helper/curl.php');
			require('helper/plugins.php');
			require('helper/constants.php');
			require('helper/messages.php');
			require('views/common-elements.php');
			require('controllers/wpns-loginsecurity-ajax.php');
			require('controllers/malware_scanner/malware_scan_ajax.php');
			require('controllers/backup_ajax.php');
			require('controllers/dashboard_ajax.php');
			require('handler/malware_scanner/malware_scanner_cron.php');
			require('handler/malware_scanner/scanner_set_cron.php');
			
			
		}

	}

	new Miniorange_twoFactor;
?>
