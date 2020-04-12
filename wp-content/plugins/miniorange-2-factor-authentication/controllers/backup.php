<?php
	
global $moWpnsUtility,$dirName;

$img_loader_url		= plugins_url('wp-security-pro/includes/images/loader.gif');
$page_url			= "";
$message			= '<div id=\'backupmessage\'><h2>DO NOT :</h2><ol><li>Close this browser</li><li>Reload this page</li><li>Click the Stop or Back button.</li></ol><h2>Untill your database backup is completed</h2></div><br/><div class=\'backupmessage\'><h2><div id=\'inprogress\'>DATABASE BACKUP IN PROGRESS</div></h2></div><div id=\'dbloader\' ><img  src=\"'.$img_loader_url.'\"></div>';
$message2a			= 'Database Backup is Completed. Check <b><i>';
$message2b			= '</i></b>file in db-backups folder.';

update_site_option('mo2f_visit_backup',true);

 if(current_user_can( 'manage_options' ) && isset($_POST['option']))
		{
	        switch($_POST['option'])
			{
				case "mo2f_enable_cron_backup":
					wpns_handle_db_enable_form($_POST);				        break;
				case "mo2f_cron_backup_configuration":
					wpns_handle_db_configuration_form($_POST);			    break;
				case "mo2f_enable_cron_file_backup":
					wpns_handle_file_backup_enable_form($_POST);			break;
			}
		} 


   

    function wpns_handle_db_enable_form($postData){
        if(! get_option('mo2f_cron_hours')){
            update_option('mo2f_cron_hours', 43200);
        }
        $enable  =  isset($postData['mo2f_enable_cron_backup_timely']) ? $postData['mo2f_enable_cron_backup_timely'] : '0';
        update_option( 'mo2f_enable_cron_backup', $enable );
		if(get_option('mo2f_enable_cron_backup') == '0'){
            $handler_obj = new site_backup;
            $handler_obj->bl_deactivate();
            do_action('wpns_show_message',MoWpnsMessages::showMessage('CRON_DB_BACKUP_DISABLE'),'ERROR');
            }else{
             do_action('wpns_show_message',MoWpnsMessages::showMessage('CRON_DB_BACKUP_ENABLE'),'SUCCESS');
            }
    }

    function wpns_handle_db_configuration_form($postData){
        $mo2f_cron_hours = $postData['mo2f_cron_hours'] * 60 *60;
        if($mo2f_cron_hours < 3600){
            do_action('wpns_show_message',MoWpnsMessages::showMessage('INVALID_HOURS'),'ERROR');
        }else{
            update_option('mo2f_cron_hours', $mo2f_cron_hours);
            $mo2f_enable_cron_backup =get_option('mo2f_enable_cron_backup',true);
            if(isset($mo2f_enable_cron_backup)  && $mo2f_enable_cron_backup=='1'){
                $handler_obj = new site_backup;
                $handler_obj->bl_deactivate();
                if ( ! wp_next_scheduled( 'bl_cron_hook' ) ) {
                    wp_schedule_event( time(), 'db_backup_time', 'bl_cron_hook' );
                }
                do_action('wpns_show_message',MoWpnsMessages::showMessage('CONFIG_SAVED'),'SUCCESS');
            }
        }
    }

    function wpns_handle_file_backup_enable_form($postData){
            if(! get_option('mo2f_cron_file_backup_hours')){
                update_option('mo2f_cron_file_backup_hours', 43200);
            }
            $enable  =  isset($postData['mo2f_enable_cron_file_backup_timely']) ? $postData['mo2f_enable_cron_file_backup_timely'] : '0';
             update_option( 'mo2f_enable_cron_file_backup', $enable );
                if(get_option('mo2f_enable_cron_file_backup') == '0'){
                	$handler_obj = new site_backup;
                 	$handler_obj->file_backup_deactivate();
                 	do_action('wpns_show_message',MoWpnsMessages::showMessage('CRON_FILE_BACKUP_DISABLE'),'ERROR');
                 }
                else{
                 	do_action('wpns_show_message',MoWpnsMessages::showMessage('CRON_FILE_BACKUP_ENABLE'),'SUCCESS');
                 }
    }

    
include $dirName . 'views'.DIRECTORY_SEPARATOR.'backup.php';