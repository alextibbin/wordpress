<?php
global $moWpnsUtility,$dirName;
if( isset( $_GET[ 'tab' ] ) ) {
		$active_tab = $_GET[ 'tab' ];
} else {
		$active_tab = 'default';
}
update_site_option('mo2f_visit_login_and_spam',true);

include_once $dirName . 'views'.DIRECTORY_SEPARATOR.'login_spam.php';
?>