<?php
	global $Mo2fdbQueries;
	$user = wp_get_current_user();
	$is_NC = get_option( 'mo2f_is_NC' );

	$is_customer_registered = $Mo2fdbQueries->get_user_detail( 'user_registration_with_miniorange', $user->ID ) == 'SUCCESS' ? true : false;

	$mo2f_feature_set = array(
		"Authentication Methods",
		"No. of Users",
		"Language Translation Support",
		"Login with Username + password + 2FA",
		"Login with Username + 2FA (skip password)",
		"Backup Methods",
		"Multi-Site Support",
		"User role based redirection after Login",
		"Add custom Security Questions (KBA)",
		"Customize account name in Google Authenticator app",
		"Brute Force Protection",
		"Blocking IP",
		"Monitoring",
		"Strong Password",
		"File Protection",
		"Enable 2FA for specific User Roles",
		"Enable 2FA for specific Users",
		"Choose specific authentication methods for Users",
		"Prompt for 2FA Registration for Users at login",
		"One Time Email Verification for Users during 2FA Registration",
		"Enable Security Questions as backup for Users during 2FA registration",
		"App Specific Password to login from mobile Apps",
		"Support"
	);


	$two_factor_methods = array(
		"miniOrange QR Code Authentication",
		"miniOrange Soft Token",
		"miniOrange Push Notification",
		"Google Authenticator",
		"Security Questions",
		"Authy Authenticator",
		"Email Verification",
		"OTP Over SMS",
		"OTP Over Email",
		"OTP Over SMS and Email",
		"Hardware Token"
	);

	$two_factor_methods_EC          = array_slice( $two_factor_methods, 0, 7 );

	$mo2f_feature_set_with_plans_NC = array(
		"Authentication Methods"                                                => array(
			array_slice( $two_factor_methods, 0, 5 ),
			array_slice( $two_factor_methods, 0, 10 ),
			array_slice( $two_factor_methods, 0, 11 ),
			array_slice( $two_factor_methods, 0, 11 )
		),
		"No. of Users"                                                          => array(
			"1",
			"User Based Pricing",
			"User Based Pricing",
			"User Based Pricing"
		),
		"Language Translation Support"                                          => array( true, true, true, true ),
		"Login with Username + password + 2FA"                                  => array( true, true, true, true ),
		"Login with Username + 2FA (skip password)"                             => array( false, true, true, true ),
		"Backup Methods"                                                        => array(
			false,
			"KBA",
			array( "KBA", "OTP Over Email", "Backup Codes" ),
			array( "KBA", "OTP Over Email", "Backup Codes" )
		),
		"Multi-Site Support"                                                    => array( false, true, true, true ),
		"User role based redirection after Login"                               => array( false, true, true, true ),
		"Add custom Security Questions (KBA)"                                   => array( false, true, true, true ),
		"Add custom Security Questions (KBA)"                                   => array( false, true, true, true ),
		"Customize account name in Google Authenticator app"                    => array( false, true, true, true ),
		"Brute Force Protection"												=> array( true, false, false, true ),
		"Blocking IP"															=> array( true, false, false, true ),
		"Monitoring"															=> array( true, false, false, true ),
		"Strong Password"														=> array( true, false, false, true ),
		"File Protection"														=> array( true, false, false, true ),
		"Enable 2FA for specific User Roles"                                    => array( false, false, true, true ),
		"Enable 2FA for specific Users"                                         => array( false, false, true, true ),
		"Choose specific authentication methods for Users"                      => array( false, false, true, true ),
		"Prompt for 2FA Registration for Users at login"                        => array( false, false, true, true ),
		"One Time Email Verification for Users during 2FA Registration"         => array( false, false, true, true ),
		"Enable Security Questions as backup for Users during 2FA registration" => array( false, false, true, true ),
		"App Specific Password to login from mobile Apps"                       => array( false, false, true, true ),
		"Support"                                                               => array(
			"Basic Support by Email",
			"Priority Support by Email",
			array( "Priority Support by Email", "Priority Support with GoTo meetings" ),
			array( "Priority Support by Email", "Priority Support with GoTo meetings" )
		),

	);

	$mo2f_feature_set_with_plans_EC = array(
		"Authentication Methods"                                                => array(
			array_slice( $two_factor_methods, 0, 8 ),
			array_slice( $two_factor_methods, 0, 10 ),
			array_slice( $two_factor_methods, 0, 11 ),
			array_slice( $two_factor_methods, 0, 11 )
		),
		"No. of Users"                                                          => array(
			"1",
			"User Based Pricing",
			"User Based Pricing",
			"User Based Pricing"
		),
		"Language Translation Support"                                          => array( true, true, true, true ),
		"Login with Username + password + 2FA"                                  => array( true, true, true, true ),
		"Login with Username + 2FA (skip password)"                             => array( true, true, true, true ),
		"Backup Methods"                                                        => array(
			"KBA",
			"KBA",
			array( "KBA", "OTP Over Email", "Backup Codes" ),
			array( "KBA", "OTP Over Email", "Backup Codes" )
		),
		"Multi-Site Support"                                                    => array( false, true, true, true ),
		"Brute Force Protection"												=> array( true, false, false, true ),
		"Blocking IP"															=> array( true, false, false, true ),
		"Monitoring"															=> array( true, false, false, true ),
		"Strong Password"														=> array( true, false, false, true ),
		"File Protection"														=> array( true, false, false, true ),
		"User role based redirection after Login"                               => array( false, true, true, true ),
		"Add custom Security Questions (KBA)"                                   => array( false, true, true, true ),
		"Customize account name in Google Authenticator app"                    => array( false, true, true, true ),
		"Enable 2FA for specific User Roles"                                    => array( false, false, true, true ),
		"Enable 2FA for specific Users"                                         => array( false, false, true, true ),
		"Choose specific authentication methods for Users"                      => array( false, false, true, true ),
		"Prompt for 2FA Registration for Users at login"                        => array( false, false, true, true ),
		"One Time Email Verification for Users during 2FA Registration"         => array( false, false, true, true ),
		"Enable Security Questions as backup for Users during 2FA registration" => array( false, false, true, true ),
		"App Specific Password to login from mobile Apps"                       => array( false, false, true, true ),
		"Support"                                                               => array(
			"Basic Support by Email",
			"Priority Support by Email",
			array( "Priority Support by Email", "Priority Support with GoTo meetings" ),
			array( "Priority Support by Email", "Priority Support with GoTo meetings" )
		),

	);

	$mo2f_addons           = array(
		"RBA & Trusted Devices Management Add-on",
		"Personalization Add-on",
		"Short Codes Add-on"
	);
	$mo2f_addons_plan_name = array(
		"RBA & Trusted Devices Management Add-on" => "wp_2fa_addon_rba",
		"Personalization Add-on"                  => "wp_2fa_addon_personalization",
		"Short Codes Add-on"                      => "wp_2fa_addon_shortcode"
	);


	$mo2f_addons_with_features = array(
		"Personalization Add-on"                  => array(
			"Custom UI of 2FA popups",
			"Custom Email and SMS Templates",
			"Customize 'powered by' Logo",
			"Customize Plugin Icon",
			"Customize Plugin Name",
			
		),
		"RBA & Trusted Devices Management Add-on" => array(
			"Remember Device",
			"Set Device Limit for the users to login",
		 "IP Restriction: Limit users to login from specific IPs"
		),
		"Short Codes Add-on"                      => array(
			"Option to turn on/off 2-factor by user",
			"Option to configure the Google Authenticator and Security Questions by user",
			"Option to 'Enable Remember Device' from a custom login form",
			"On-Demand ShortCodes for specific fuctionalities ( like for enabling 2FA for specific pages)"
		)
	);
	?>
	<br>
    <div class="mo2f_licensing_plans" style="border:0px;">
	
        <table class="table mo_table-bordered mo_table-striped">
            <thead>
            <tr class="mo2f_licensing_plans_tr">
                <th width="20%" >
                    <h3>Features \ Plans</h3></th>
                <th class="text-center" width="20%" ><h3>Free</h3>

                    <p class="mo2f_licensing_plans_plan_desc">Basic 2FA for Small Scale Web Businesses</p><br>
					<span style='color:red;font-size:18px;'>(Current Plan)</span>
					</th>
                <th class="text-center" width="20%" ><h3>Standard</h3>

                    <p class="mo2f_licensing_plans_plan_desc">Intermediate 2FA for Medium Scale Web Businesses with
                        basic support</p><span>
						<?php echo mo2f_yearly_standard_pricing(); ?>

						<?php echo mo2f_sms_cost();
						if( $is_customer_registered) {
						?>
                            <h4 class="mo2f_pricing_sub_header" style="padding-bottom:8px !important;"><button
                                        class="mo_wpns_button mo_wpns_button1" style="border: 1px solid;background-color: #7e73df;"
                                        onclick="mo2f_upgradeform('wp_2fa_basic_plan')" >Upgrade</button></h4>
                        <?php }else{ ?>

                            <h4 class="mo2f_pricing_sub_header" style="padding-bottom:8px !important;"><button
                                    class="mo_wpns_button mo_wpns_button1" style="border: 1px solid; background-color: #7e73df;"
                                    onclick="mo2f_register_and_upgradeform('wp_2fa_basic_plan')" >Upgrade</button></h4>
                        <?php } ?>
                            <br>
				</span></h3>
                </th>

                <th class="text-center" width="20%"><h3>Premium</h3>

                    <p class="mo2f_licensing_plans_plan_desc" style="margin:16px 0 16px 0	">Advanced and Intuitive
                        2FA for Large Scale Web businesses with enterprise-grade support</p><span>
                    <?php echo mo2f_yearly_premium_pricing(); ?>
						<?php echo mo2f_sms_cost();
                        if( $is_customer_registered) {
						?>
                            <h4 class="mo2f_pricing_sub_header" style="padding-bottom:8px !important;"><button
                                        class="mo_wpns_button mo_wpns_button1"style="border: 1px solid; background-color: #7e73df;"
                                        onclick="mo2f_upgradeform('wp_2fa_premium_plan')" >Upgrade</button></h4>
		                <?php }else{ ?>

                            <h4 class="mo2f_pricing_sub_header" style="padding-bottom:8px !important;"><button
                                        class="mo_wpns_button mo_wpns_button1"style="border: 1px solid; background-color: #7e73df;"
                                        onclick="mo2f_register_and_upgradeform('wp_2fa_premium_plan')" >Upgrade</button></h4>
		                <?php } ?>
                        <br>
				</span>
                </th>
                <th class="text-center" width="25%">
                	<h3>Enterprise</h3>
					
                    <p class="mo2f_licensing_plans_plan_desc" style="margin:16px 0 16px 0;">One stop security solution with 2fa and Network security for Large Web businesses.</p><span>
                    	<?php 
                    	if( $is_customer_registered) {
						?>
                            <h4 class="mo2f_pricing_sub_header" style="padding-bottom:8px !important;"><button
                                        class="mo_wpns_button mo_wpns_button1"style="border: 1px solid; background-color: #7e73df;"
                                        onclick="mo2f_upgradeform('wp_2fa_enterprise_plan')" >Upgrade</button></h4>
		                <?php }else{ ?>

                            <h4 class="mo2f_pricing_sub_header" style="padding-bottom:8px !important;"><button
                                        class="mo_wpns_button mo_wpns_button1"style="border: 1px solid; background-color: #7e73df;"
                                        onclick="mo2f_register_and_upgradeform('wp_2fa_enterprise_plan')" >Upgrade</button></h4>
		                <?php } ?>
                        <br>
				</span>
                </th>

            </tr>
            </thead>
            <tbody class="mo_align-center mo-fa-icon">
			<?php for ( $i = 0; $i < count( $mo2f_feature_set ); $i ++ ) { ?>
                <tr>
                    <td><?php
						$feature_set = $mo2f_feature_set[ $i ];

						echo $feature_set;
						?>
					</td>
					<?php if ( $is_NC ) {
						$f_feature_set_with_plan = $mo2f_feature_set_with_plans_NC[ $feature_set ];
					} else {
						$f_feature_set_with_plan = $mo2f_feature_set_with_plans_EC[ $feature_set ];
					}
					?>
                    <td><?php
						if ( is_array( $f_feature_set_with_plan[0] ) ) {
							echo mo2f_create_li( $f_feature_set_with_plan[0] );
						} else {
							if ( gettype( $f_feature_set_with_plan[0] ) == "boolean" ) {
								echo mo2f_get_binary_equivalent( $f_feature_set_with_plan[0] );
							} else {
								echo $f_feature_set_with_plan[0];
							}
						} ?>
                    </td>
                    <td><?php
						if ( is_array( $f_feature_set_with_plan[1] ) ) {
							echo mo2f_create_li( $f_feature_set_with_plan[1] );
						} else {
							if ( gettype( $f_feature_set_with_plan[1] ) == "boolean" ) {
								echo mo2f_get_binary_equivalent( $f_feature_set_with_plan[1] );
							} else {
								echo $f_feature_set_with_plan[1];
							}
						} ?>
                    </td>
                    <td><?php
						if ( is_array( $f_feature_set_with_plan[2] ) ) {
							echo mo2f_create_li( $f_feature_set_with_plan[2] );
						} else {
							if ( gettype( $f_feature_set_with_plan[2] ) == "boolean" ) {
								echo mo2f_get_binary_equivalent( $f_feature_set_with_plan[2] );
							} else {
								echo $f_feature_set_with_plan[2];
							}
						} ?>
                    </td>
					<td><?php
						if ( is_array( $f_feature_set_with_plan[3] ) ) {
							echo mo2f_create_li( $f_feature_set_with_plan[3] );
						} else {
							if ( gettype( $f_feature_set_with_plan[3] ) == "boolean" ) {
								echo mo2f_get_binary_equivalent( $f_feature_set_with_plan[3] );
							} else {
								echo $f_feature_set_with_plan[3];
							}
						} ?>
                    </td>
                </tr>
			<?php } ?>

            <tr>
                <td><b>Add-Ons</b></td>
				<?php if ( $is_NC ) { ?>
                    <td><b>Purchase Separately</b></td>
				<?php } else { ?>
                    <td><b>NA</b></td>
				<?php } ?>
                <td><b>Purchase Separately</b></td>
                <td><b>Included</b></td>
                <td><b>Included</b></td>
            </tr>
			<?php for ( $i = 0; $i < count( $mo2f_addons ); $i ++ ) { ?>
                <tr>
                    <td><?php echo $mo2f_addons[ $i ]; ?> <?php for ( $j = 0; $j < $i + 1; $j ++ ) { ?>*<?php } ?>
                    </td>
					<?php if ( $is_NC ) { ?>
                        <td>
                            <button class="mo_wpns_button mo_wpns_button1" style="cursor:pointer"
                                    onclick="mo2f_upgradeform('<?php echo $mo2f_addons_plan_name[ $mo2f_addons[ $i ] ]; ?>')" <?php echo $is_customer_registered ? "" : " disabled " ?> >
                                Purchase
                            </button>
                            
                        </td>
					<?php } else { ?>
                        <td><b>NA</b></td>
					<?php } ?>
                    <td>
                        <button class="mo_wpns_button mo_wpns_button1" style="cursor:pointer"
                                onclick="mo2f_upgradeform('<?php echo $mo2f_addons_plan_name[ $mo2f_addons[ $i ] ]; ?>')" <?php echo $is_customer_registered ? "" : " disabled " ?> >
                            Purchase
                        </button>
                    </td>
                    <td><div style="color:#20b2aa;font-size: large;">✔</div></td>
                    <td><div style="color:#20b2aa;font-size: large;">✔</div></td>
                </tr>
			<?php } ?>

            </tbody>
        </table>
        <br>
        <div style="padding:10px;">
			<?php for ( $i = 0; $i < count( $mo2f_addons ); $i ++ ) {
				$f_feature_set_of_addons = $mo2f_addons_with_features[ $mo2f_addons[ $i ] ];
				for ( $j = 0; $j < $i + 1; $j ++ ) { ?>*<?php } ?>
                <b><?php echo $mo2f_addons[ $i ]; ?> Features</b>
                <br>
                <ol>
					<?php for ( $k = 0; $k < count( $f_feature_set_of_addons ); $k ++ ) { ?>
                        <li><?php echo $f_feature_set_of_addons[ $k ]; ?></li>
					<?php } ?>
                </ol>

                <hr><br>
			<?php } ?>
            <b>**** SMS Charges</b>
            <p><?php echo mo2f_lt( 'If you wish to choose OTP Over SMS / OTP Over SMS and Email as your authentication method,
                    SMS transaction prices & SMS delivery charges apply and they depend on country. SMS validity is for lifetime.' ); ?></p>
            <hr>
            <br>
            <div>
                <h2>Note</h2>
                <ol class="mo2f_licensing_plans_ol">
                    <li><?php echo mo2f_lt( 'The plugin works with many of the default custom login forms (like Woocommerce / Theme My Login), however if you face any issues with your custom login form, contact us and we will help you with it.' ); ?></li>
                </ol>
            </div>

            <br>
            <hr>
            <br>
            <div>
                <h2>Steps to upgrade to the Premium Plan</h2>
                <ol class="mo2f_licensing_plans_ol">
                    <li><?php echo mo2f_lt( 'Click on \'Upgrade\' button of your preferred plan above.' ); ?></li>
                    <li><?php echo mo2f_lt( ' You will be redirected to the miniOrange Console. Enter your miniOrange username and password, after which you will be redirected to the payment page.' ); ?></li>

                    <li><?php echo mo2f_lt( 'Select the number of users you wish to upgrade for, and any add-ons if you wish to purchase, and make the payment.' ); ?></li>
                    <li><?php echo mo2f_lt( 'After making the payment, you can find the Standard/Premium plugin to download from the \'License\' tab in the left navigation bar of the miniOrange Console.' ); ?></li>
                    <li><?php echo mo2f_lt( 'Download the premium plugin from the miniOrange Console.' ); ?></li>
                    <li><?php echo mo2f_lt( 'In the Wordpress dashboard, uninstall the free plugin and install the premium plugin downloaded.' ); ?></li>
                    <li><?php echo mo2f_lt( 'Login to the premium plugin with the miniOrange account you used to make the payment, after this your users will be able to set up 2FA.' ); ?></li>
                </ol>
            </div>
            <div>
                <h2>Note</h2>
                <ul class="mo2f_licensing_plans_ol">
                    <li><?php echo mo2f_lt( 'There is no license key required to activate the Standard/Premium Plugins. You will have to just login with the miniOrange Account you used to make the purchase.' ); ?></li>
                </ul>
            </div>

            <br>
            <hr>
            <br>
            <div>
                <h2>Refund Policy</h2>
                <p class="mo2f_licensing_plans_ol"><?php echo mo2f_lt( 'At miniOrange, we want to ensure you are 100% happy with your purchase. If the premium plugin you purchased is not working as advertised and you\'ve attempted to resolve any issues with our support team, which couldn\'t get resolved then we will refund the whole amount within 10 days of the purchase.' ); ?>
                </p>
            </div>
            <br>
            <hr>
            <br>
            <div>
                <h2>Privacy Policy</h2>
                <p class="mo2f_licensing_plans_ol"><a
                            href="https://www.miniorange.com/2-factor-authentication-for-wordpress-gdpr">Click Here</a>
                    to read our Privacy Policy.
                </p>
            </div>
            <br>
            <hr>
            <br>
            <div>
                <h2>Contact Us</h2>
                <p class="mo2f_licensing_plans_ol"><?php echo mo2f_lt( 'If you have any doubts regarding the licensing plans, you can mail us at' ); ?>
                    <a href="mailto:info@xecurify.com"><i>info@xecurify.com</i></a> <?php echo mo2f_lt( 'or submit a query using the support form.' ); ?>
                </p>
            </div>
            <br>
            <hr>
            <br>
             <form class="mo2f_display_none_forms" id="mo2fa_loginform"
                  action="<?php echo MO_HOST_NAME . '/moas/login'; ?>"
                  target="_blank" method="post">
                <input type="email" name="username" value="<?php echo get_option( 'mo2f_email' ); ?>"/>
                <input type="text" name="redirectUrl"
                       value="<?php echo MO_HOST_NAME . '/moas/initializepayment'; ?>"/>
                <input type="text" name="requestOrigin" id="requestOrigin"/>
            </form>

            <form class="mo2f_display_none_forms" id="mo2fa_register_to_upgrade_form"
                   method="post">
                <input type="hidden" name="requestOrigin" />
                <input type="hidden" name="mo2fa_register_to_upgrade_nonce"
                       value="<?php echo wp_create_nonce( 'miniorange-2-factor-user-reg-to-upgrade-nonce' ); ?>"/>
            </form>
            <script>

                function mo2f_upgradeform(planType) {
                    jQuery('#requestOrigin').val(planType);
                    jQuery('#mo2fa_loginform').submit();
                }

                function mo2f_register_and_upgradeform(planType) {
                    jQuery('#requestOrigin').val(planType);
                    jQuery('input[name="requestOrigin"]').val(planType);
                    jQuery('#mo2fa_register_to_upgrade_form').submit();
                }
            </script>

            <style>#mo2f_support_table {
                    display: none;
                }

            </style>
        </div>
    </div>

<?php 
function mo2f_create_li( $mo2f_array ) {
	$html_ol = '<ul>';
	foreach ( $mo2f_array as $element ) {
		$html_ol .= "<li>" . $element . "</li>";
	}
	$html_ol .= '</ul>';

	return $html_ol;
}
function mo2f_sms_cost() {
	?>
    <p class="mo2f_pricing_text" id="mo2f_sms_cost"
       title="<?php echo mo2f_lt( '(Only applicable if OTP over SMS is your preferred authentication method.)' ); ?>"><?php echo mo2f_lt( 'SMS Cost' ); ?>
        ****<br/>
        <select id="mo2f_sms" class="form-control" style="border-radius:5px;width:200px;">
            <option><?php echo mo2f_lt( '$5 per 100 OTP + SMS delivery charges' ); ?></option>
            <option><?php echo mo2f_lt( '$15 per 500 OTP + SMS delivery charges' ); ?></option>
            <option><?php echo mo2f_lt( '$22 per 1k OTP + SMS delivery charges' ); ?></option>
            <option><?php echo mo2f_lt( '$30 per 5k OTP + SMS delivery charges' ); ?></option>
            <option><?php echo mo2f_lt( '$40 per 10k OTP + SMS delivery charges' ); ?></option>
            <option><?php echo mo2f_lt( '$90 per 50k OTP + SMS delivery charges' ); ?></option>
        </select>
    </p>
	<?php
}


function mo2f_yearly_standard_pricing() {
	?>

    <p class="mo2f_pricing_text"
       id="mo2f_yearly_sub"><?php echo __( 'Yearly Subscription Fees', 'miniorange-2-factor-authentication' ); ?>

        <select id="mo2f_yearly" class="form-control" style="border-radius:5px;width:200px;">
            <option> <?php echo mo2f_lt( '1 - 2 users - $5 per year' ); ?> </option>
            <option> <?php echo mo2f_lt( '3 - 5 users - $20 per year' ); ?> </option>
            <option> <?php echo mo2f_lt( '6 - 50 users - $30 per year' ); ?> </option>
            <option> <?php echo mo2f_lt( '51 - 100 users - $49 per year' ); ?> </option>
            <option> <?php echo mo2f_lt( '101 - 500 users - $99 per year' ); ?> </option>
            <option> <?php echo mo2f_lt( '501 - 1000 users - $199 per year' ); ?> </option>
            <option> <?php echo mo2f_lt( '1001 - 5000 users - $299 per year' ); ?> </option>
            <option> <?php echo mo2f_lt( '5001 -  10000 users - $499 per year' ); ?></option>
            <option> <?php echo mo2f_lt( '10001 - 20000 users - $799 per year' ); ?> </option>
        </select>
    </p>
	<?php
}

function mo2f_yearly_premium_pricing() {
	?>

    <p class="mo2f_pricing_text"
       id="mo2f_yearly_sub"><?php echo __( 'Yearly Subscription Fees', 'miniorange-2-factor-authentication' ); ?>

        <select id="mo2f_yearly" class="form-control" style="border-radius:5px;width:200px;">
            <option> <?php echo mo2f_lt( '1 - 5 users - $30 per year' ); ?> </option>
            <option> <?php echo mo2f_lt( '6 - 50 users - $99 per year' ); ?> </option>
            <option> <?php echo mo2f_lt( '51 - 100 users - $199 per year' ); ?> </option>
            <option> <?php echo mo2f_lt( '101 - 500 users - $349 per year' ); ?> </option>
            <option> <?php echo mo2f_lt( '501 - 1000 users - $499 per year' ); ?> </option>
            <option> <?php echo mo2f_lt( '1001 - 5000 users - $799 per year' ); ?> </option>
            <option> <?php echo mo2f_lt( '5001 -  10000 users - $999 per year ' ); ?></option>
            <option> <?php echo mo2f_lt( '10001 - 20000 users - $1449 per year' ); ?> </option>
        </select>
    </p>
	<?php
}
function mo2f_get_binary_equivalent( $mo2f_var ) {

	switch ( $mo2f_var ) {
		case 1:
			return "<div style='color:#20b2aa;font-size: large;'>✔</div>";
		case 0:
			return "";
		default:
			return $mo2f_var;
	}
	}