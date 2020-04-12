<?php
$security_features_nonce = wp_create_nonce('mo_2fa_security_features_nonce');

if ( 'admin.php' == basename( $_SERVER['PHP_SELF'] ) )
{
        if(get_option('mo_wpns_2fa_with_network_security_popup_visible')==1)
        {
?>
<div id="myModal" class="modal">

  <div class="mo_wpns_divided_layout" style="margin-left: 13%;">
    <div class="mo_wpns_setting_layout">
        
    <h1 style="color: #20b2aa; font-size: x-large; text-align: center;">What are you looking for?</h1><br>
    <hr>
    

 <form id="mo_wpns_2fa_with_network_security" method="post" action="">
    <div style="width: 100%;">
                    <h3>
                   <?php echo ' <input type="hidden" name="mo_security_features_nonce" value="'.$security_features_nonce.'"/>';?>

                    <input type="hidden" name="mo_wpns_2fa_with_network_security" value="on">
                    <div class="mo_popup" id="mo_popup_id">
                        <div class="mo_popup_div" id="mo_popup_div1" >
                            <input type="radio" class="mo_popup_radio" name="mo_wpns_features" id="nw_2fa" value="mo_wpns_2fa_with_network_security" checked >
                            <label for="nw_2fa" class="mo_popup_lable">
                                <p class="" style="font-size: 1.5em;">2-Factor + Website Security</p>
                                <p class="mo_popup_para">In which you will get 2FA with Web Application Firewall, Login Security, Malware Scanner, Encrypted Backup, Spam Protection and other security features.</p>
                            </label>
                        </div>
                        <div class="mo_popup_div" id="mo_popup_div2" >
                            <input type="radio" class="mo_popup_radio" name="mo_wpns_features" id="only_2fa" value="mo_wpns_2fa_features">
                            <label for="only_2fa" class="mo_popup_lable">
                                <p class="" style="font-size: 1.5em;">Just 2-Factor Authentication</p>
                                <p class="mo_popup_para">If you are looking for only 2-Factor Authentication and no other security features then please continue with this option.</p>
                            </label>
                        </div>
                    </div>
                    </h3>
                    
                    <br>
                      
                   
                    <br>
                    <center>
                    <input type="submit" class="mo_wpns_button mo_wpns_button1" onchange="document.getElementById(\'mo_wpns_2fa_with_network_security\').submit();" value="Continue"></center>
    </div>
    </form>
  </div>
</div>
</div>

<script>
var modal = document.getElementById("myModal");

var span = document.getElementsByClassName("close")[0];

window.onload = function() {
  modal.style.display = "block";
}


</script>

<?php
}
}
?>