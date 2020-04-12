<?php
$security_features_nonce = wp_create_nonce('mo_2fa_security_features_nonce');

	if($shw_feedback)
		do_action('wpns_show_message',MoWpnsMessages::showMessage('FEEDBACK'),'CUSTOM_MESSAGE');
	if(get_option('mo_wpns_2fa_with_network_security'))
	{
		if(!$safe)
			do_action('wpns_show_message',MoWpnsMessages::showMessage('WHITELIST_SELF'),'CUSTOM_MESSAGE');
	}
	echo'<div class="wrap">
				<div><img  style="float:left;margin-top:5px;" src="'.$logo_url.'"></div>
				<h1>
					miniOrange 2-Factor &nbsp;
					<a class="add-new-h2" href="'.$profile_url.'">Account</a>
					<a class="add-new-h2" href="'.$help_url.'">Troubleshooting</a>
					<a class="license-button add-new-h2" href="'.$license_url.'">Upgrade</a>';
					if(get_option("mo_wpns_2fa_with_network_security"))
					{
					echo '<a class="license-button add-new-h2" id="restart-tour" href="#" style="background-color: lightblue;">Restart tour</a>	';					
					}
echo'					<span style="text-align:right;"> 

					<form id="mo_wpns_2fa_with_network_security" method="post" action="" style="margin-top: -2%; width: 25%; text-align: right; padding-left: 75%;">
					<input type="hidden" name="mo_security_features_nonce" value="'.$security_features_nonce.'"/>

					<input type="hidden" name="option" value="mo_wpns_2fa_with_network_security">
					
					<label class="mo_wpns_switch">
					<input type="checkbox" name="mo_wpns_2fa_with_network_security" '.$network_security_features.'  onchange="document.getElementById(\'mo_wpns_2fa_with_network_security\').submit();"> 
					<span class="mo_wpns_slider mo_wpns_round"></span>
					</label><span>&nbsp;&nbsp;&nbsp;<i>2FA + Security Features</i></span>
					
					</form>
					</span>
					
					
				</h1>			
		</div>';
		//check_is_curl_installed();
?>


		<br>
		<div class="mo_flex-container">
			<?php 
		if(get_option('mo_wpns_2fa_with_network_security'))
		{
			echo '<a class="nav-tab '.($active_tab == 'mo_2fa_dashboard' 	  ? 'nav-tab-active' : '').'" href="'.$dashboard_url	.'">Dashboard</a>';
		}
			echo '<a class="nav-tab '.($active_tab == 'mo_2fa_two_fa'		  ?	'nav-tab-active' : '').'" href="'.$two_fa		 	.'">Two Factor</a>'; 
		if(get_option('mo_wpns_2fa_with_network_security'))
		{
			if(get_site_option('mo_2f_switch_waf')){
	 			echo '<a id="mo_2fa_waf" class="nav-tab '.($active_tab == 'mo_2fa_waf' 			  ? 'nav-tab-active' : '').'" href="'.$waf				.'">Firewall</a>';
	 		}
	 		if(get_site_option('mo_2f_switch_loginspam')){
	 			echo '<a id="login_spam_tab" class="nav-tab '.($active_tab == 'mo_2fa_login_and_spam'  ? 'nav-tab-active' : '').'" href="'.$login_and_spam	.'">Login and Spam</a>';
	 		}
	 		if(get_site_option('mo_2f_switch_backup')){
				echo '<a id="backup_tab" class="nav-tab '.($active_tab == 'mo_2fa_backup' 	  	  ? 'nav-tab-active' : '').'" href="'.$backup			.'">Encrypted Backup</a>';
			}
			if(get_site_option('mo_2f_switch_malware')){
				echo '<a id="malware_tab" class="nav-tab '.($active_tab == 'mo_2fa_malwarescan'	  ?	'nav-tab-active' : '').'" href="'.$scan_url 		.'">Malware Scan</a>';
			}
			if(get_site_option('mo_2f_switch_adv_block')){
				echo '<a id="adv_block_tab" class="nav-tab '.($active_tab == 'mo_2fa_advancedblocking'? 'nav-tab-active' : '').'" href="'.$advance_block	.'">Advanced Blocking</a>';
			}
			if(get_site_option('mo_2f_switch_notif')){
				echo '<a id="notif_tab" class="nav-tab '.($active_tab == 'mo_2fa_notifications'	  ? 'nav-tab-active' : '').'" href="'.$notif_url		.'">Notifications</a>';
			}
			if(get_site_option('mo_2f_switch_reports')){
				echo '<a id="report_tab" class="nav-tab '.($active_tab == 'mo_2fa_reports'	  	  ?	'nav-tab-active' : '').'" href="'.$reports_url		.'">Reports</a>';
			}
		} 
			echo '<a class="nav-tab '.($active_tab == 'mo_2fa_upgrade'	  	  ?	'nav-tab-active' : '').'" href="'.$upgrade_url		.'">Upgrade</a>';
			?>
		</div>
