<?php
global $moWpnsUtility,$dirName;
include_once $dirName . 'views'.DIRECTORY_SEPARATOR.'navbar.php';
add_action('admin_footer','mo_2fa_dashboard_switch');
$two_fa_toggle = get_site_option("mo2f_toggle");
$two_fa_on= get_site_option("mo_2f_switch_2fa")?"checked":"";
$all_on= get_site_option("mo_2f_switch_all")?"checked":"";
$waf_on= get_site_option("mo_2f_switch_waf")?"checked":"";
$login_spam_on= get_site_option("mo_2f_switch_loginspam")?"checked":"";
$backup_on= get_site_option("mo_2f_switch_backup")?"checked":"";
$malware_on= get_site_option("mo_2f_switch_malware")?"checked":"";
$adv_block_on= get_site_option("mo_2f_switch_adv_block")?"checked":"";
$report_on= get_site_option("mo_2f_switch_reports")?"checked":"";
$notif_on= get_site_option("mo_2f_switch_notif")?"checked":"";
echo '<div id="mo_switch_message" style=" padding:8px"></div>';
echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<div class="mo_wpns_divided_layout">
		
		<div class="mo_wpns_dashboard_layout">
			<center>
				<div class ="mo_wpns_inside_dashboard_layout ">Failed Login<hr class="line"><p class ="wpns_font_size mo_wpns_dashboard_text" >'.$wpns_attacks_blocked.'</p></div>
				<div class ="mo_wpns_inside_dashboard_layout">Attacks Blocked <hr class="line"><p class ="wpns_font_size mo_wpns_dashboard_text">'.$totalAttacks.'</p></div>
				<div class ="mo_wpns_inside_dashboard_layout">Blocked IPs<hr class="line"><p class ="wpns_font_size mo_wpns_dashboard_text">'.$wpns_count_ips_blocked.'</p></div>
				<div class ="mo_wpns_inside_dashboard_layout">Infected Files<hr class="line"><p class ="wpns_font_size mo_wpns_dashboard_text" >'.$total_malicious.'</p></div>
				<div class ="mo_wpns_inside_dashboard_layout">White-listed IPs<hr class="line"><p class ="wpns_font_size mo_wpns_dashboard_text">'.$wpns_count_ips_whitelisted.'</p></div>
				
				
			</center>
		</div>

	
			<div style="padding: 0px 0px 0px 5px; width:30%; margin-left:634px; margin-right:25px; float:right;" >
			<form name="tab_all" id="tab_all" method="post">
			<h3>Enable/Disable all features
			<label class="mo_wpns_switch">
			<input type="hidden" name="option" value="tab_all_switch"/>
			<input type=checkbox id="switch_all" name="switch_val" value="1" '.$all_on.' />
			<span class="mo_wpns_slider mo_wpns_round"></span>
			</label>
			</h3>
			</form>
			</div>
			
			<div class="mo_wpns_small_layout">
				<form name="tab_2fa" id="tab_2fa" method="post">
				<h3>Two Factor Authentication ';
				if($two_fa_toggle){
					echo ' <label class="mo_wpns_switch" style="float: right">
					<input type="hidden" name="option" value="tab_2fa_switch"/>
					<input type=checkbox id="switch_2fa" name="switch_val" value="1" '.$two_fa_on.' />
					<span class="mo_wpns_slider mo_wpns_round"></span>
					</label>';
				}else{
					echo ' <b style="color:green;">(Enabled)</b>';
				}
			echo ' </h3>
				</form>
				<br>
				Two Factor Authentication adds an extra security layer for verification that involve <b>google authenticator, other application based authentication,  Soft Token, Push Notification, USB based Hardware token, Security Questions, One time passcodes (OTP) over SMS, OTP over Email </b> etc.

			</div>
			<div class="mo_wpns_small_layout">
				<form name="tab_waf" id="tab_waf" method="post">
				<h3 align="center">Web Application Firewall (WAF)
				<label class="mo_wpns_switch" style="float: right">
				<input type="hidden" name="option" value="tab_waf_switch"/>
				<input type=checkbox id="switch_WAF" name="switch_val" value="1" '.$waf_on.' />
				<span class="mo_wpns_slider mo_wpns_round"></span>
				</label>
				</h3>
				</form>
				<br>
				Web Application Firewall protects your website from several website attacks such as <b>SQL Injection(SQLI), Cross Site Scripting(XSS), Remote File Inclusion</b> and many more cyber attacks.It also protects your website from <b>critical attacks</b> such as <b>Dos and DDos attacks.</b><br>
			</div>
			<div class="mo_wpns_small_layout">
				<form name="tab_login" id="tab_login" method="post">
				<h3 align="center">Login and Spam
				<label class="mo_wpns_switch" style="float: right">
				<input type="hidden" name="option" value="tab_login_switch"/>
				 <input type=checkbox id="switch_login_spam" name="switch_val" value="1" ' .$login_spam_on. ' />
				 <span class="mo_wpns_slider mo_wpns_round"></span>
				</label>
				</h3>
				</form>
				<br>
				Firewall protects the whole website.
				If you just want to prevent your login page from <b> password guessing attacks</b> by humans or by bots.
				 We have features such as <b> Brute Force,Enforcing Strong Password,Custom Login Page URL,Recaptcha </b> etc. <br>
			</div>
			<div class="mo_wpns_small_layout">
				<form name="tab_backup" id="tab_backup" method="post">
				<h3>Encrypted Backup
				<label class="mo_wpns_switch" style="float: right">
				<input type="hidden" name="option" value="tab_backup_switch"/>
				 <input type=checkbox id="switch_backup" name="switch_val" value="1" ' .$backup_on. '/>
				 <span class="mo_wpns_slider mo_wpns_round"></span>
				</label>
				</h3>
				</form>
				<br>
				Creating regular backups for your website is essential. By Creating backup you can <b>restore your website back to normal</b> within a few minutes. miniOrange creates <b>database and file Backup</b> which is stored locally in your system.
			</div>
			<div class="mo_wpns_small_layout">
				<form name="tab_malware" id="tab_malware" method="post">
				<h3>Malware Scan
				<label class="mo_wpns_switch" style="float: right">
				<input type="hidden" name="option" value="tab_malware_switch"/>
				 <input type=checkbox id="switch_malware" name="switch_val" value="1" ' .$malware_on. ' />
				 <span class="mo_wpns_slider mo_wpns_round"></span>
				</label>
				</h3>
				</form>
				<br>
				 A malware scanner / detector or virus scanner is a <b>software that detects the malware</b> into the system. It detects different kinds of malware and categories based on the <b>strength of vulnerability or harmfulness.</b> <br>
			</div>
			<div class="mo_wpns_small_layout">
				<form name="tab_adv_block" id="tab_adv_block" method="post">
				<h3>Advanced Blocking
				<label class="mo_wpns_switch" style="float: right">
				<input type="hidden" name="option" value="tab_block_switch"/>
				 <input type=checkbox id="switch_adv_block" name="switch_val" value="1" ' .$adv_block_on. '/>
				 <span class="mo_wpns_slider mo_wpns_round"></span>
				</label>
				</h3>
				</form>
				<br>
				In Advanced blocking we have features like <b> Country Blocking, IP range Blocking , Browser blocking </b> and other options you can set up specifically according to your needs 
			</div>
		    <div class="mo_wpns_small_layout">
		    	<form name="tab_report" id="tab_report" method="post">
				<h3>Reports
				<label class="mo_wpns_switch" style="float: right">
				<input type="hidden" name="option" value="tab_report_switch"/>
				 <input type=checkbox id="switch_reports" name="switch_val" value="1" ' .$report_on. '/>
				 <span class="mo_wpns_slider mo_wpns_round"></span>
				</label>
				</h3>
				</form>
				<br>
                Track users <b>login activity</b> on your website. You can also <b>track 404 error</b> so that if anyone tries to access it too many times you can take action.
			</div>

			<div class="mo_wpns_small_layout">
				<form name="tab_notif" id="tab_notif" method="post">
				<h3>Notification
				<label class="mo_wpns_switch" style="float: right">
				<input type="hidden" name="option" value="tab_notif_switch"/>
				 <input type=checkbox id="switch_notification" name="switch_val" value="1" ' .$notif_on. '/>
				 <span class="mo_wpns_slider mo_wpns_round"></span>
				</label>
				</h3>
				</form>
				<br>
				Get <b>Notified realtime</b> about any <b>IP getting Blocked.</b> With that, also get informed about any <b>unusual activities</b> detected by miniOrange.
			</div>
		
	</div>	';

function mo_2fa_dashboard_switch(){
	if ( ('admin.php' != basename( $_SERVER['PHP_SELF'] )) || ($_GET['page'] != 'mo_2fa_dashboard') ) {
        return;
    }
?>
	<script>
		jQuery(document).ready(function(){
			jQuery("#switch_2fa").click(function(){
				jQuery("#tab_2fa").submit();
			});

			jQuery("#switch_all").click(function(){
				jQuery("#tab_all").submit();
			});

			jQuery("#switch_WAF").click(function(){
				jQuery("#tab_waf").submit();
			});

			jQuery("#switch_login_spam").click(function(){
				jQuery("#tab_login").submit();
			});

			jQuery("#switch_backup").click(function(){
				jQuery("#tab_backup").submit();
			});

			jQuery("#switch_malware").click(function(){
				jQuery("#tab_malware").submit();
			});

			jQuery("#switch_adv_block").click(function(){
				jQuery("#tab_adv_block").submit();
			});

			jQuery("#switch_reports").click(function(){
				jQuery("#tab_report").submit();
			});

			jQuery("#switch_notification").click(function(){
				jQuery("#tab_notif").submit();
			});

		});
	</script>
<?php
}
?>