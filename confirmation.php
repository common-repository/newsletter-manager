<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
// if(!isset($_GET['wp_nlm'])){

// 	$string = '?wp_nlm=confirmation';
// 	foreach ($_GET as $key => $value) {
// 		$string = $string.'&'.$key.'='.urlencode($value);
// 	}

// 	header("Location:". '../../../index.php'.$string);
// 	exit();
// }
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
// $phpmailer = new PHPMailer();
$phpmailer->CharSet=get_option('blog_charset');

global $wpdb;
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);
$xyz_em_emailId = absint($_GET['eId']);
$xyz_em_listId = absint($_GET['lId']);


$xyz_em_both = sanitize_text_field(trim($_GET['both']));

$xyz_em_email = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_em_email_address WHERE id= %d",$xyz_em_emailId)) ;
$xyz_em_email = $xyz_em_email[0];

$combine = $xyz_em_emailId.$xyz_em_listId.strtolower($xyz_em_email->email);
$combineValue = md5($combine);


$xyz_em_url = base64_decode($_GET['appurl']);
if($xyz_em_url=='')
	$xyz_em_url=strip_tags(get_option('xyz_em_emailConfirmation'));
	add_filter( 'allowed_redirect_hosts' , 'xyz_em_allowed_redirect_hosts_confirmation' , 10 );
    function xyz_em_allowed_redirect_hosts_confirmation($content){
        $xyz_em_url=get_option('xyz_em_emailConfirmation');
    $sourceUrl = parse_url($xyz_em_url);
    $sourcehost = $sourceUrl['host'];
    if(!in_array($sourcehost, $content))
        $content[]=$sourcehost;
        return $content;
}
if($combineValue == $xyz_em_both){
	
$xyz_em_statusWelcomeFlag = 0;
if(($xyz_em_emailId != "") && ($xyz_em_listId != "") && ($xyz_em_url != "")){
	
	$xyz_em_mapping = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_em_address_list_mapping WHERE el_id= %d AND ea_id= %d",$xyz_em_listId,$xyz_em_emailId)) ;
	$xyz_em_mapping = $xyz_em_mapping[0];
	if(($xyz_em_mapping->status == 0) || ($xyz_em_mapping->status == -1)){
		$xyz_em_statusWelcomeFlag = 1;
	}
	$time = time();
	$wpdb->update($wpdb->prefix.'xyz_em_address_list_mapping',array('status'=>1,'last_update_time'=>$time),array('ea_id'=>$xyz_em_emailId,'el_id'=>$xyz_em_listId));

	if(get_option('xyz_em_enableWelcomeEmail') == "True"){
		if($xyz_em_statusWelcomeFlag == 1){
				
			$xyz_em_template = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id="1" ') ;
			$xyz_em_template = $xyz_em_template[0];
				$xyz_em_senderName = get_option('xyz_em_dsn');
				$xyz_em_senderEmail = get_option('xyz_em_dse');
			
			if(get_option('xyz_em_sendViaSmtp') == 1){
			
			
			
				$xyz_em_SmtpDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE 	set_default ="1"' ) ;
				$xyz_em_SmtpDetails = $xyz_em_SmtpDetails[0];
			
				$phpmailer->IsSMTP();
				$phpmailer->Host = $xyz_em_SmtpDetails->host;
				$phpmailer->SMTPDebug = get_option('xyz_em_SmtpDebug');
				if($xyz_em_SmtpDetails->authentication=='true')
					$phpmailer->SMTPAuth = TRUE;
				
				$phpmailer->SMTPSecure = $xyz_em_SmtpDetails->security;
				$phpmailer->Port = $xyz_em_SmtpDetails->port;

				$phpmailer->Username = $xyz_em_SmtpDetails->user;
				$phpmailer->Password = $xyz_em_SmtpDetails->password;
				
				if(is_email(get_option('xyz_em_dse'))){
					$phpmailer->From     = get_option('xyz_em_dse');
				}else{
					$phpmailer->From     = $xyz_em_SmtpDetails->user;
				}
				
				$phpmailer->FromName = $xyz_em_senderName;
			
				$phpmailer->AddReplyTo($xyz_em_SmtpDetails->user,$xyz_em_senderName);
			
			}else{
			
				$phpmailer->IsMail();
				
				
				$phpmailer->From     = $xyz_em_senderEmail;
				$phpmailer->FromName = $xyz_em_senderName;
				
				$phpmailer->AddReplyTo($xyz_em_senderEmail,$xyz_em_senderName);
				
			}
			
			$xyz_em_message = $xyz_em_template->message;
			
			$xyz_em_messageToSend = nl2br($xyz_em_message);
			
			

      $xyz_em_subject=$xyz_em_fieldInfoDefaultValue='';
			
			$xyz_em_fieldInfoDetails = $wpdb->get_results( 'SELECT default_value FROM '.$wpdb->prefix.'xyz_em_additional_field_info WHERE field_name="Name"' ) ;
      if(!empty($xyz_em_fieldInfoDetails) && !empty( $xyz_em_fieldInfoDetails[0]))
        $xyz_em_fieldInfoDefaultValue = $xyz_em_fieldInfoDetails[0]->default_value;
			
			$xyz_em_fieldValueDetails = $wpdb->get_results( $wpdb->prepare( "SELECT field1 FROM ".$wpdb->prefix."xyz_em_additional_field_value WHERE ea_id= %d",$xyz_em_emailId) ) ;
      if(!empty($xyz_em_fieldValueDetails[0])){
			$xyz_em_fieldValueDetails = $xyz_em_fieldValueDetails[0];
			
			if($xyz_em_fieldValueDetails->field1 != ""){
			
				$xyz_em_messageToSend =  str_replace("{field1}",$xyz_em_fieldValueDetails->field1,$xyz_em_messageToSend);
				$xyz_em_subject = str_replace("{field1}",$xyz_em_fieldValueDetails->field1,$xyz_em_template->subject);
			
			}else{
  				$xyz_em_messageToSend =  str_replace("{field1}",$xyz_em_fieldInfoDefaultValue,$xyz_em_messageToSend);
				$xyz_em_subject = str_replace("{field1}",$xyz_em_fieldValueDetails->default_value,$xyz_em_template->subject);
			}
      }
			
			$xyz_em_messageToSend =  str_replace("{email-ID}",$xyz_em_email->email,$xyz_em_messageToSend);
			$date=date("Y/m/d");
			$time=date('h:i:s', time());
			$ipaddress=xyz_em_get_user_ip();
			$xyz_em_messageToSend =  str_replace("{date}",$date,$xyz_em_messageToSend);
			$xyz_em_messageToSend =  str_replace("{time}",$time,$xyz_em_messageToSend);
			$xyz_em_messageToSend =  str_replace("{ip_address}",$ipaddress,$xyz_em_messageToSend);
			$xyz_em_messageToSend =  str_replace("{subscribed_lists}",'default',$xyz_em_messageToSend);
			
			$phpmailer->Subject = $xyz_em_subject;
			
			$phpmailer->MsgHTML($xyz_em_messageToSend);
			
			$phpmailer->AddAddress($xyz_em_email->email);
			
			if(get_option('xyz_em_sub_screenshot_mail')==1)
			{
			    $xyz_em_attach= get_option('xyz_em_sub_screenshot_mail_attachements');
			    
			    
			    $xyz_em_dir = "uploads/xyz_em/subscription_screenshot/";
			    $xyz_em_targetfolder = realpath(dirname(__FILE__) . '/../../')."/".$xyz_em_dir;
			    
			    $phpmailer->AddAttachment($xyz_em_targetfolder.$xyz_em_attach);
			    
			}
			if(get_option('xyz_em_sub_copyto_admin')==1)
			{
			    $phpmailer->addBcc($xyz_em_senderEmail);
			}
			
      $sent='';
      try{
			$sent = $phpmailer->Send();
			
			if($sent == FALSE) {
           if ($phpmailer->isError()) {
             echo "Mailer Error: " . $phpmailer->getError();
           }
           else
            {
             echo "Mail not sent";
           }
         }
       }
     catch (Exception $e) {
        echo 'Mailer Error: ' . $e->getMessage();
      }
		if($sent == TRUE) {}
		}
	}
	if(strpos($xyz_em_url,'?') > 0)
	{
		$xyz_em_url = $xyz_em_url."&result=success";
	
	}else{
		$xyz_em_url = $xyz_em_url."?result=success";
	}
	
	if($xyz_em_statusWelcomeFlag == 1)
		$xyz_em_url = $xyz_em_url."&confirm=true"; // need to confirm.
	else
		$xyz_em_url = $xyz_em_url."&confirm=false"; // already confirmed.
	
			//header("Location:".$xyz_em_url);
	wp_safe_redirect($xyz_em_url);
	exit();
	

}else{
	
	if(strpos($xyz_em_url,'?') > 0)
	{
		$xyz_em_url = $xyz_em_url."&result=failure";
	
	}else{
		$xyz_em_url = $xyz_em_url."?result=failure";
	}
	
	//header("Location:".$xyz_em_url);
	wp_safe_redirect($xyz_em_url);
	exit();
}

}else{
	
	
	if(strpos($xyz_em_url,'?') > 0)
	{
	    $xyz_em_url=$xyz_em_url."&result=failure";
		//header("Location:".$xyz_em_url."&result=failure");
		wp_safe_redirect($xyz_em_url);
	}
	else
	{
	    $xyz_em_url=$xyz_em_url."?result=failure";
		//header("Location:".$xyz_em_url."?result=failure");
		wp_safe_redirect($xyz_em_url);
	}
	exit();
}


?>