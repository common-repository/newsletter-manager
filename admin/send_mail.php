<?php
if ( ! defined( 'ABSPATH' ) ) exit;
global $wp_version;
if( $wp_version < '5.5') {
    require_once(ABSPATH . WPINC . '/class-phpmailer.php');
require_once ABSPATH . WPINC . '/class-smtp.php';
$phpmailer = new PHPMailer();
}
else {
    require_once(ABSPATH . WPINC . '/PHPMailer/PHPMailer.php');
		require_once(ABSPATH . WPINC . '/PHPMailer/SMTP.php');
    require_once(ABSPATH . WPINC . '/PHPMailer/Exception.php');
    $phpmailer = new PHPMailer\PHPMailer\PHPMailer( true );
}
// require_once ABSPATH . WPINC . '/class-phpmailer.php';
// require_once ABSPATH . WPINC . '/class-smtp.php';

global $wpdb;
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);


$xyz_em_campId =absint ($_GET['id']);
$xyz_em_pageno = absint($_GET['pageno']);
if (
		! isset( $_REQUEST['_wpnonce'] )
		|| ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'send_mail_'.$xyz_em_campId )
) {

	wp_nonce_ays( 'send_mail_'.$xyz_em_campId );

	exit();

}

if($xyz_em_campId=="" || !is_numeric($xyz_em_campId)){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns'));
	exit();
}
$xyz_em_fieldInfoDefaultValue='';
$currentDateTime = time();

$xyz_em_campDetails = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_em_email_campaign WHERE id= %d AND status= %d AND start_time<= '%s' LIMIT %d,%d",$xyz_em_campId,1,$currentDateTime,0,1) ) ;
if(count($xyz_em_campDetails)==0){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns&campmsg=7&pagenum='.$xyz_em_pageno));
	exit();
}else{	

	$xyz_em_campDetails = $xyz_em_campDetails[0];
	echo "<br><br><b>Campaign : ".$xyz_em_campDetails->name."</b><br><br>";
	$xyz_em_fieldInfoDetails = $wpdb->get_results( 'SELECT default_value FROM '.$wpdb->prefix.'xyz_em_additional_field_info WHERE field_name="Name"' ) ;
  if(!empty($xyz_em_fieldInfoDetails) && !empty( $xyz_em_fieldInfoDetails[0]))
    $xyz_em_fieldInfoDefaultValue = $xyz_em_fieldInfoDetails[0]->default_value;
	
	if($xyz_em_campDetails->join_after_campaign_started == 1){
		
		$xyz_em_mappingDetails = $wpdb->get_results( $wpdb->prepare( "SELECT ea_id,id FROM ".$wpdb->prefix."xyz_em_address_list_mapping WHERE el_id= %d AND status= %d AND id> %d ORDER BY id LIMIT %d,%d",$xyz_em_campDetails->list_id,1,$xyz_em_campDetails->last_send_mapping_id,0,$xyz_em_campDetails->batch_size) ) ;
	
	}elseif($xyz_em_campDetails->join_after_campaign_started == 2){
		
		$xyz_em_mappingDetails = $wpdb->get_results( $wpdb->prepare( "SELECT ea_id,id FROM ".$wpdb->prefix."xyz_em_address_list_mapping WHERE el_id= %d AND status= %d AND id> %d AND create_time< %d ORDER BY id LIMIT %d,%d",$xyz_em_campDetails->list_id,1,$xyz_em_campDetails->last_send_mapping_id,$xyz_em_campDetails->start_time,0,$xyz_em_campDetails->batch_size) ) ;
	
	}
	
	$time = time();
	$day 	= date('d', $time);
	$month 	= date('m', $time);
	$year 	= date('Y', $time);
	$hour 	= date('H', $time);
	$currentHour = gmmktime($hour,0,0,$month,$day,$year);
	
	if(($currentHour - get_option('xyz_em_hourly_reset_time'))>=3600){
	
		update_option('xyz_em_hourly_reset_time',$currentHour);
		update_option('xyz_em_hourly_email_sent_count',0);
	
	}
	
	$xyz_em_sendMailFlag = 0;
	
	$endTimeFlag = 0;
	
	if($xyz_em_campDetails->end_time != 0){
		$xyz_em_end_time = $xyz_em_campDetails->end_time;
	}else{
		$xyz_em_end_time = $xyz_em_campDetails->end_time;
	}
	
	if(($xyz_em_end_time != 0) && ($xyz_em_end_time < $currentHour)){
	
		$endTimeFlag = 1;
		
		$wpdb->update($wpdb->prefix.'xyz_em_email_campaign',array('status'=>3), array('id'=>$xyz_em_campDetails->id));
	
	}
	
	if($endTimeFlag == 0){
	
	if(count($xyz_em_mappingDetails)>0){
		$counter=1;
		foreach ($xyz_em_mappingDetails as $mappingdetail){

			// $phpmailer = new PHPMailer();
			$phpmailer->CharSet=get_option('blog_charset');
			
			$xyz_em_emailDetails = $wpdb->get_results( $wpdb->prepare( "SELECT email FROM ".$wpdb->prefix."xyz_em_email_address WHERE id= %d ",$mappingdetail->ea_id)) ;
			$xyz_em_emailDetails = $xyz_em_emailDetails[0];
			
			
			$xyz_em_fieldValueDetails = $wpdb->get_results( $wpdb->prepare( "SELECT field1 FROM ".$wpdb->prefix."xyz_em_additional_field_value WHERE ea_id= %d ",$mappingdetail->ea_id) ) ;
			
			
			$xyz_em_senderName = $xyz_em_campDetails->sender_name;
			
			if(get_option('xyz_em_sendViaSmtp') == 1){
				
				$fromEmail = '';
				
				if($xyz_em_campDetails->sender_email != ''){
					$fromEmail = $xyz_em_campDetails->sender_email;
				}
												
				$xyz_em_Smtp_delete_check = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_em_sender_email_address WHERE id= %d",$xyz_em_campDetails->sender_email_id) ) ;
				
				if($xyz_em_campDetails->sender_email_id == 0 || count($xyz_em_Smtp_delete_check) == 0 ){
			
					$xyz_em_SmtpDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE 	set_default ="1"' ) ;
				}else{
					$xyz_em_SmtpDetails = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_em_sender_email_address WHERE id= %d ",$xyz_em_campDetails->sender_email_id) ) ;
				}
				$xyz_em_SmtpDetails = $xyz_em_SmtpDetails[0];
				
				if($xyz_em_campDetails->sender_email == ''){
					$fromEmail = $xyz_em_SmtpDetails->user;
				}
				
				
				$phpmailer->IsSMTP();
				$phpmailer->Host = $xyz_em_SmtpDetails->host;
				$phpmailer->SMTPDebug = get_option('xyz_em_SmtpDebug');
				if($xyz_em_SmtpDetails->authentication=='true')
					$phpmailer->SMTPAuth = TRUE;
					
				$phpmailer->SMTPSecure = $xyz_em_SmtpDetails->security;
				$phpmailer->Port = $xyz_em_SmtpDetails->port;
				$phpmailer->Username = $xyz_em_SmtpDetails->user;
				$phpmailer->Password = $xyz_em_SmtpDetails->password;
				
				$phpmailer->From     = $fromEmail;
				$phpmailer->FromName = $xyz_em_senderName;
				//$phpmailer->SetFrom($xyz_em_senderEmail,$xyz_em_senderName); /* code changed */
				
				$phpmailer->AddReplyTo($xyz_em_SmtpDetails->user,$xyz_em_senderName);
				
			}else{
				$phpmailer->IsMail();
				
				$xyz_em_senderEmail = $xyz_em_campDetails->sender_email;
				
				if(strlen($xyz_em_senderEmail)==0){
					$xyz_em_senderEmail = get_option('xyz_em_dse');
				}
				
				$phpmailer->From     = $xyz_em_senderEmail;
				$phpmailer->FromName = $xyz_em_senderName;
				//$phpmailer->SetFrom($xyz_em_senderEmail,$xyz_em_senderName); /* code changed */
				
				$phpmailer->AddReplyTo($xyz_em_senderEmail,$xyz_em_senderName);
				
			}
			
			$xyz_em_attachmentDetails = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_em_attachment WHERE campaigns_id= %d ",$xyz_em_campId) ) ;
			if($xyz_em_attachmentDetails){
			
				$xyz_em_dir = "uploads/xyz_em/attachments/";
				$xyz_em_targetfolder = realpath(dirname(__FILE__) . '/../../../')."/".$xyz_em_dir;
			
				foreach ($xyz_em_attachmentDetails as $xyz_em_attchDetail){
					$phpmailer->AddAttachment($xyz_em_targetfolder.$xyz_em_attchDetail->name);
				}
			}
			
			
			$xyz_em_altBody = $xyz_em_campDetails->alt_body;
			
			$xyz_em_body 	 = $xyz_em_campDetails->body;
			
			if(count($xyz_em_fieldValueDetails)> 0){
			
				$xyz_em_fieldValueDetails = $xyz_em_fieldValueDetails[0];
				
				$xyz_em_body =  str_replace("{field1}",$xyz_em_fieldValueDetails->field1,$xyz_em_body);
				$xyz_em_altBody = str_replace("{field1}",$xyz_em_fieldValueDetails->field1,$xyz_em_altBody);
				$xyz_em_subject = str_replace("{field1}",$xyz_em_fieldValueDetails->field1,$xyz_em_campDetails->subject);
			}else{
				$xyz_em_body =  str_replace("{field1}",$xyz_em_fieldInfoDefaultValue,$xyz_em_body);
				$xyz_em_altBody = str_replace("{field1}",$xyz_em_fieldInfoDefaultValue,$xyz_em_altBody);
				$xyz_em_subject = str_replace("{field1}",$xyz_em_fieldInfoDefaultValue,$xyz_em_campDetails->subject);
			}

			$phpmailer->Subject = $xyz_em_subject;
			
			$type = $xyz_em_campDetails->type;
			
			$combineValues =  $mappingdetail->ea_id.$xyz_em_campDetails->list_id.strtolower($xyz_em_emailDetails->email);
			$both = md5($combineValues);
			
			$unsubscriptionLink = get_site_url()."/index.php?wp_nlm=unsubscribe&eId=".$mappingdetail->ea_id."&lId=".$xyz_em_campDetails->list_id."&both=".$both."&campId=".$xyz_em_campDetails->id;
			add_filter( 'nonce_life','xyz_em_filter_nonce_life');
			$unsubscriptionLink=wp_nonce_url( $unsubscriptionLink, 'xyz_em_email_unsubscribe_'.$mappingdetail->ea_id);
			remove_filter('nonce_life', 'xyz_em_filter_nonce_life');
			
			$xyz_em_body = str_replace("{unsubscribe-url}",$unsubscriptionLink,$xyz_em_body);
			
			if($xyz_em_campDetails->type == 2){
				
				$phpmailer->AltBody    =  str_replace("{unsubscribe-url}",$unsubscriptionLink,$xyz_em_altBody);// optional, comment out and test
				
				$phpmailer->MsgHTML($xyz_em_body);
			
			}elseif($xyz_em_campDetails->type == 1){
			
				$phpmailer->Body = $xyz_em_body;
			
			}
			
			$phpmailer->AddAddress($xyz_em_emailDetails->email);
			
			$xyz_em_mappingId = $mappingdetail->id;
			echo $counter++." ".$xyz_em_emailDetails->email." => ";
			if(get_option('xyz_em_hesl') > get_option('xyz_em_hourly_email_sent_count')){
        $sent='';
      try{
				$sent = $phpmailer->Send();
				if($sent == FALSE) {
           if ($phpmailer->isError()) {
             echo "Mailer Error: " . $phpmailer->getError();
           }
           else {
             echo "Mail not sent";
           }
         }
      } catch (Exception $e) {
        echo 'Mailer Error: ' . $e->getMessage();
      }
				if($sent == TRUE) {
			
					
					echo "Sent.<br>";
					$xyz_em_sendMailFlag=1;
					
					$xyz_em_campSentCount = $wpdb->get_results( $wpdb->prepare( "SELECT send_count FROM ".$wpdb->prefix."xyz_em_email_campaign WHERE id= %d ",$xyz_em_campId)) ;
					$xyz_em_campSentCount = $xyz_em_campSentCount[0];
				
					$time = time();
					$wpdb->update($wpdb->prefix.'xyz_em_email_campaign',
							array('send_count'=>$xyz_em_campSentCount->send_count+$xyz_em_sendMailFlag,'last_fired_time'=>$time,'last_send_mapping_id'=>$xyz_em_mappingId),
							array('id'=>$xyz_em_campId));
					
					$xyz_em_hourlySentEmailCount = get_option('xyz_em_hourly_email_sent_count');
					$xyz_em_currentSentCount = $xyz_em_hourlySentEmailCount + $xyz_em_sendMailFlag;
					update_option('xyz_em_hourly_email_sent_count',$xyz_em_currentSentCount);
				
				}
			
			}else{
				header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns&campmsg=9&pagenum='.$xyz_em_pageno));
				exit();
			}
		}
	}else{
		header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns&campmsg=6&pagenum='.$xyz_em_pageno));
		exit();
	
	}
}else{
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-campaigns&campmsg=10&pagenum='.$xyz_em_pageno));
	exit();
}

	if($xyz_em_sendMailFlag != 0){
?>		
		
<br>
<a	href='<?php echo admin_url('admin.php?page=newsletter-manager-manage-campaigns&pagenum='.$xyz_em_pageno);?>'>Go back </a>
<?php
	}
}

?>
