<?php
	
	global $moWpnsUtility,$dirName;
	if(current_user_can( 'manage_options' ) && isset($_POST['option']))
	{
		switch(sanitize_text_field(wp_unslash($_POST['option'])))
		{
			case "mo_wpns_2fa_with_network_security":
				$security_features = new Mo_2fa_security_features();
				$security_features->wpns_2fa_with_network_security($_POST);			break;
			
		}
	}
	$network_security_features= get_option('mo_wpns_2fa_with_network_security') 		? "checked" : "";
	


	if( isset( $_GET[ 'page' ])){
		$tab_count= get_site_option('mo2f_tab_count', 0);
		if($tab_count == 7)
				update_site_option('mo_2f_switch_all', 1);
		else
			update_site_option('mo_2f_switch_all', 0);
		switch($_GET['page'])
		{
            case 'mo_2fa_login_and_spam':
            	update_option('mo_2f_switch_loginspam', 1);
            	if($tab_count < 7 && !get_site_option('mo_2f_switch_loginspam'))
            		update_site_option('mo2f_tab_count', get_site_option('mo2f_tab_count')+1);
																	break;
			case 'mo_2fa_backup':
				update_option('mo_2f_switch_backup', 1);
				if($tab_count < 7 && !get_site_option('mo_2f_switch_backup'))
					update_site_option('mo2f_tab_count', get_site_option('mo2f_tab_count')+1);
													 				break;
			case 'mo_2fa_waf':
				update_option('mo_2f_switch_waf', 1);
				if($tab_count < 7 && !get_site_option('mo_2f_switch_waf'))
					update_site_option('mo2f_tab_count', get_site_option('mo2f_tab_count')+1);
														    		break;
			case 'mo_2fa_advancedblocking':
				update_option('mo_2f_switch_adv_block', 1);
				if($tab_count < 7 && !get_site_option('mo_2f_switch_adv_block'))
					update_site_option('mo2f_tab_count', get_site_option('mo2f_tab_count')+1);
																	break;
			case 'mo_2fa_notifications':
				update_option('mo_2f_switch_notif', 1);
				if($tab_count < 7 && !get_site_option('mo_2f_switch_notif'))
					update_site_option('mo2f_tab_count', get_site_option('mo2f_tab_count')+1);
																	break;
			case 'mo_2fa_reports':
				update_option('mo_2f_switch_reports', 1);
				if($tab_count < 7 && !get_site_option('mo_2f_switch_reports'))
					update_site_option('mo2f_tab_count', get_site_option('mo2f_tab_count')+1);
																	break;
			case 'mo_2fa_malwarescan':
				update_option('mo_2f_switch_malware', 1);
				if($tab_count < 7 && !get_site_option('mo_2f_switch_malware'))
					update_site_option('mo2f_tab_count', get_site_option('mo2f_tab_count')+1);
																	break;
		}
	}
	$profile_url	= add_query_arg( array('page' => 'mo_2fa_account'		), $_SERVER['REQUEST_URI'] );
	$login_security	= add_query_arg( array('page' => 'default'			), $_SERVER['REQUEST_URI'] );
	$waf			= add_query_arg( array('page' => 'mo_2fa_waf'				), $_SERVER['REQUEST_URI'] );
	$login_and_spam = add_query_arg( array('page' => 'mo_2fa_login_and_spam'   ), $_SERVER['REQUEST_URI'] );
	$register_url	= add_query_arg( array('page' => 'registration'		), $_SERVER['REQUEST_URI'] );
	$blocked_ips	= add_query_arg( array('page' => 'mo_2fa_blockedips'		), $_SERVER['REQUEST_URI'] );
	$advance_block	= add_query_arg( array('page' => 'mo_2fa_advancedblocking'	), $_SERVER['REQUEST_URI'] );
	$notif_url		= add_query_arg( array('page' => 'mo_2fa_notifications'	), $_SERVER['REQUEST_URI'] );
	$reports_url	= add_query_arg( array('page' => 'mo_2fa_reports'			), $_SERVER['REQUEST_URI'] );
	$license_url	= add_query_arg( array('page' => 'mo_2fa_upgrade'  		), $_SERVER['REQUEST_URI'] );
	$help_url		= add_query_arg( array('page' => 'mo_2fa_troubleshooting'	), $_SERVER['REQUEST_URI'] );
	$content_protect= add_query_arg( array('page' => 'content_protect'	), $_SERVER['REQUEST_URI'] );
	$backup			= add_query_arg( array('page' => 'mo_2fa_backup'			), $_SERVER['REQUEST_URI'] );
	$scan_url       = add_query_arg( array('page' => 'mo_2fa_malwarescan'      ), $_SERVER['REQUEST_URI'] );
	$two_fa         = add_query_arg( array('page' => 'mo_2fa_two_fa'           ), $_SERVER['REQUEST_URI'] );
	//Added for new design
    $dashboard_url	= add_query_arg(array('page' => 'mo_2fa_dashboard'			), $_SERVER['REQUEST_URI']);
    $upgrade_url	= add_query_arg(array('page' => 'mo_2fa_upgrade'				), $_SERVER['REQUEST_URI']);
   //dynamic
    $logo_url = plugin_dir_url(dirname(__FILE__)) . 'includes/images/miniorange_logo.png';
   // $logo_url		= plugin_dir_url($dirName) . 'wp-security-pro/includes/images/miniorange_logo.png';
    $shw_feedback	= get_option('donot_show_feedback_message') ? false: true;
    $moPluginHandler= new MoWpnsHandler();
    $safe			= $moPluginHandler->is_whitelisted($moWpnsUtility->get_client_ip());

    $active_tab 	= $_GET['page'];

	include $dirName . 'views'.DIRECTORY_SEPARATOR.'navbar.php';