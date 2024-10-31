<?php
if ( ! defined( 'ABSPATH' ) ) exit;
// if(!isset($_REQUEST['wp_nlm'])){

// 	$string = '?wp_nlm=subscribe';
// 	foreach ($_REQUEST as $key => $value) {
// 		$string = $string.'&'.$key.'='.urlencode($value);
// 	}

// 	header("Location:". '../../../index.php'.$string);
// 	exit();
// }
// $_POST = stripslashes_deep($_POST);
// $_POST = xyz_trim_deep($_POST);
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


$optinMode = get_option('xyz_em_dss');
$formid=1;
if(isset($_REQUEST['postFrom']) && $_REQUEST['postFrom'] == 'cfm'){
  if (! isset( $_REQUEST['hash'] )
        ||( $_REQUEST['hash'] != md5(get_option('xyz_cfm_nlm_code')))
        ) {
            echo "Hash Mismatch";
            exit();
        }
	$xyz_em_email = rawurldecode(sanitize_email(stripslashes(trim(sanitize_text_field($_REQUEST['xyz_em_email'])))));
	$customFieldsDetails = json_decode(rawurldecode(stripslashes_deep(xyz_trim_deep($_REQUEST['customFieldsDetails']))));
	$xyz_em_name = sanitize_text_field($customFieldsDetails[0]);
	$optinMode = rawurldecode(stripslashes(trim($_REQUEST['xyz_newsletter_optinmode']))); //replace optin mode from cfm

}else{
    if (
        ! isset( $_REQUEST['subscribe_nonce'] )
        || ! wp_verify_nonce( $_REQUEST['subscribe_nonce'], 'xyz_nlm_subscription')
        ) {
            wp_nonce_ays( 'xyz_nlm_subscription');
            exit();
        }
        $xyz_em_email = sanitize_email(stripslashes(trim($_REQUEST['xyz_em_email'])));
        $xyz_em_name = sanitize_text_field(stripslashes(trim($_REQUEST['xyz_em_name'])));
}
$xyz_em_emailConfirmation = get_option('xyz_em_emailConfirmation');
$xyz_em_afterSubscription = get_option('xyz_em_afterSubscription');
add_filter( 'allowed_redirect_hosts' , 'xyz_em_allowed_redirect_hosts_subscription' , 10 );
function xyz_em_allowed_redirect_hosts_subscription($content){
    $xyz_em_afterSubscription = get_option('xyz_em_afterSubscription');
    $sourceUrl = parse_url($xyz_em_afterSubscription);
    $sourcehost = $sourceUrl['host'];
    if(!in_array($sourcehost, $content))
        $content[]=$sourcehost;
    return $content;
}
if(get_option('xyz_em_captcha')=="1")
{
    $captchaFlagError=1;
    if (isset($_POST["g-recaptcha-response"]))
    {
        $secret = get_option('xyz_em_recaptcha_private_key');
        $verifyResponse = wp_remote_get('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.sanitize_text_field(stripslashes_deep(xyz_trim_deep($_POST['g-recaptcha-response']))));
        if (is_array( $verifyResponse )){
            $verifyResponse = $verifyResponse['body'];
            $responseData = json_decode($verifyResponse);

            if($responseData->success)
                $captchaFlagError = 0;

        }
    }

    if($captchaFlagError ==1)
    {
        if(strpos($xyz_em_afterSubscription,'?') > 0)
        {
            $xyz_em_afterSubscription = $xyz_em_afterSubscription."&result=failure";

        }else{
            $xyz_em_afterSubscription = $xyz_em_afterSubscription."?result=failure";
        }

                //header("location:".$xyz_em_afterSubscription);
                wp_safe_redirect($xyz_em_afterSubscription);
                exit();
    }

}

if(!is_email($xyz_em_email)){

	if(strpos($xyz_em_afterSubscription,'?') > 0)
	{
		$xyz_em_afterSubscription = $xyz_em_afterSubscription."&result=failure";

	}else{
		$xyz_em_afterSubscription = $xyz_em_afterSubscription."?result=failure";
	}
	//header("location:".$xyz_em_afterSubscription);
	wp_safe_redirect($xyz_em_afterSubscription);
	exit();
    }else{
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



	$time = time();
	$xyz_em_statusFlag=0;
	$emailDetails = $wpdb->get_results( $wpdb->prepare( "SELECT id FROM ".$wpdb->prefix."xyz_em_email_address WHERE email= '%s'",$xyz_em_email)) ;
	if(count($emailDetails) == 1){
		$emailDetails = $emailDetails[0];
		$xyz_em_emailLastId=$emailDetails->id;
		$emailExist = $wpdb->get_results( $wpdb->prepare( "SELECT ea.id FROM ".$wpdb->prefix."xyz_em_email_address ea INNER JOIN ".$wpdb->prefix."xyz_em_address_list_mapping lm ON lm.ea_id=ea.id WHERE ea.email= '%s' AND lm.status= %d",$xyz_em_email,1)) ;

		if(count($emailExist)>0){
		//	echo "Activation link already sent to your email address.";
		}else{

		//	$xyz_em_emailLastId = $emailDetails->id;
			if($optinMode == "Active")
				$wpdb->update($wpdb->prefix.'xyz_em_address_list_mapping', array('last_update_time' => $time,'status' => 1),array('ea_id'=>$xyz_em_emailLastId));

			$xyz_em_statusFlag = 1;

		}
	}else{


		$wpdb->insert($wpdb->prefix.'xyz_em_email_address', array('email' => $xyz_em_email,'create_time' => $time,'last_update_time' => $time ),array('%s','%d','%d'));
		$xyz_em_emailLastId = $wpdb->insert_id;

		if($xyz_em_name != ""){
			$wpdb->insert($wpdb->prefix.'xyz_em_additional_field_value', array('ea_id' => $xyz_em_emailLastId,'field1' => $xyz_em_name),array('%d','%s'));
		}

		if($optinMode == "Pending"){

				$xyz_em_status = -1;

		}elseif($optinMode == "Active"){
			$xyz_em_status = 1;
		}

		$wpdb->insert($wpdb->prefix.'xyz_em_address_list_mapping', array('ea_id' => $xyz_em_emailLastId,'el_id' => 1, 'create_time' => $time,'last_update_time' => $time,'status' => $xyz_em_status,'formid'=>$formid),array('%d','%d','%d','%d','%d','%d'));
		$xyz_em_statusFlag = 1;
	}

	if($optinMode == "Pending"){
    $xyz_em_subject=$xyz_em_fieldInfoDefaultValue='';
		$xyz_em_emailTempalteDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id=3') ;
		$xyz_em_emailTempalteDetails = $xyz_em_emailTempalteDetails[0];
		$xyz_em_emailTempalteMessage = $xyz_em_emailTempalteDetails->message;

		$xyz_em_fieldInfoDetails = $wpdb->get_results( 'SELECT default_value FROM '.$wpdb->prefix.'xyz_em_additional_field_info WHERE field_name="Name"' ) ;
    if(!empty($xyz_em_fieldInfoDetails) && !empty( $xyz_em_fieldInfoDetails[0]))
      $xyz_em_fieldInfoDefaultValue = $xyz_em_fieldInfoDetails[0]->default_value;

		$xyz_em_fieldValueDetails = $wpdb->get_results( $wpdb->prepare( "SELECT field1 FROM ".$wpdb->prefix."xyz_em_additional_field_value WHERE ea_id= %d",$xyz_em_emailLastId) ) ;
    if(!empty($xyz_em_fieldValueDetails[0])){
      $xyz_em_fieldValueDetails = $xyz_em_fieldValueDetails[0];

  		if($xyz_em_fieldValueDetails->field1 != ""){

  			$xyz_em_emailTempalteMessage =  str_replace("{field1}",$xyz_em_fieldValueDetails->field1,$xyz_em_emailTempalteMessage);
  			$xyz_em_subject = str_replace("{field1}",$xyz_em_fieldValueDetails->field1,$xyz_em_emailTempalteDetails->subject);

  		}else{
  			$xyz_em_emailTempalteMessage =  str_replace("{field1}",$xyz_em_fieldInfoDefaultValue,$xyz_em_emailTempalteMessage);
  			$xyz_em_subject = str_replace("{field1}",$xyz_em_fieldValueDetails->default_value,$xyz_em_emailTempalteDetails->subject);
  		}
    }
		$xyz_em_conf_link = '{confirmation_url}';

		$xyz_em_activeDir = "";

		if(strpos($xyz_em_afterSubscription,'?') > 0)
		{
			$xyz_em_activeDir = $xyz_em_afterSubscription."&result=success";

		}else{
			$xyz_em_activeDir = $xyz_em_afterSubscription."?result=success";
		}
// 		if($xyz_em_statusFlag == 1){
// 		}
		$xyz_em_appendUrl = base64_encode($xyz_em_emailConfirmation);
		$listId = 1;

		$combine = $xyz_em_emailLastId.$listId.strtolower($xyz_em_email);
		$combineValue = md5($combine);

		$xyz_em_confLink = get_site_url()."/index.php?wp_nlm=confirmation&eId=".$xyz_em_emailLastId."&lId=".$listId."&both=".$combineValue."&appurl=".$xyz_em_appendUrl;

		$xyz_em_messageToSendPending = nl2br(str_replace($xyz_em_conf_link,$xyz_em_confLink,$xyz_em_emailTempalteMessage));

		if($xyz_em_statusFlag == 1){

			$xyz_em_activeDir = $xyz_em_activeDir."&confirm=true"; // need to confirm

			$phpmailer->Subject = $xyz_em_subject;

			$phpmailer->MsgHTML($xyz_em_messageToSendPending);

			$phpmailer->AddAddress($xyz_em_email);
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
		}else {

			$xyz_em_activeDir = $xyz_em_activeDir."&confirm=false"; // already confirmed.
		}
				//header("location: ".$xyz_em_activeDir);
		wp_safe_redirect($xyz_em_activeDir);
				exit();


	}else{
    $xyz_em_subject=$xyz_em_fieldInfoDefaultValue='';
		$xyz_em_emailTempalteDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id=1') ;
		$xyz_em_emailTempalteDetails = $xyz_em_emailTempalteDetails[0];

		$xyz_em_emailTempalteMessage = $xyz_em_emailTempalteDetails->message;

		$xyz_em_fieldInfoDetails = $wpdb->get_results( 'SELECT default_value FROM '.$wpdb->prefix.'xyz_em_additional_field_info WHERE field_name="Name"' ) ;
    if(!empty($xyz_em_fieldInfoDetails) && !empty( $xyz_em_fieldInfoDetails[0]))
      $xyz_em_fieldInfoDefaultValue = $xyz_em_fieldInfoDetails[0]->default_value;
		$xyz_em_fieldValueDetails = $wpdb->get_results( $wpdb->prepare( "SELECT field1 FROM ".$wpdb->prefix."xyz_em_additional_field_value WHERE ea_id= %d",$xyz_em_emailLastId) ) ;
    if(!empty($xyz_em_fieldValueDetails[0])){
      $xyz_em_fieldValueDetails = $xyz_em_fieldValueDetails[0];

  		if($xyz_em_fieldValueDetails->field1 != ""){

  			$xyz_em_emailTempalteMessage =  str_replace("{field1}",$xyz_em_fieldValueDetails->field1,$xyz_em_emailTempalteMessage);
  			$xyz_em_subject = str_replace("{field1}",$xyz_em_fieldValueDetails->field1,$xyz_em_emailTempalteDetails->subject);

  		}else{
  			$xyz_em_emailTempalteMessage =  str_replace("{field1}",$xyz_em_fieldInfoDefaultValue,$xyz_em_emailTempalteMessage);
  			$xyz_em_subject = str_replace("{field1}",$xyz_em_fieldValueDetails->default_value,$xyz_em_emailTempalteDetails->subject);
  		}
    }
		$xyz_em_emailTempalteMessage =  str_replace("{email-ID}",$xyz_em_email,$xyz_em_emailTempalteMessage);
		$date=date("Y/m/d");
		$time=date('h:i:s', time());
		$ipaddress=xyz_em_get_user_ip();
		$xyz_em_emailTempalteMessage =  str_replace("{date}",$date,$xyz_em_emailTempalteMessage);
		$xyz_em_emailTempalteMessage =  str_replace("{time}",$time,$xyz_em_emailTempalteMessage);
		$xyz_em_emailTempalteMessage =  str_replace("{ip_address}",$ipaddress,$xyz_em_emailTempalteMessage);
		$xyz_em_emailTempalteMessage =  str_replace("{subscribed_lists}",'default',$xyz_em_emailTempalteMessage);




		$xyz_em_messageToSend = nl2br($xyz_em_emailTempalteMessage);
		//die("456");

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


		if($xyz_em_statusFlag == 1 && get_option('xyz_em_enableWelcomeEmail') == "True"){


			$phpmailer->Subject = $xyz_em_subject;

			$phpmailer->MsgHTML($xyz_em_messageToSend);

			$phpmailer->AddAddress($xyz_em_email);

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
			if($sent == TRUE) {
			}

		}
		if(strpos($xyz_em_afterSubscription,'?') > 0){
		    $xyz_em_afterSubscription=$xyz_em_afterSubscription."&result=success";
			//header("location:".$xyz_em_afterSubscription."&result=success");
			wp_safe_redirect($xyz_em_afterSubscription);
			exit();
		}else{
		    $xyz_em_afterSubscription=$xyz_em_afterSubscription."&result=success";
			//header("location:".$xyz_em_afterSubscription."?result=success");
			wp_safe_redirect($xyz_em_afterSubscription);
			exit();
		}

	}

}
?>
