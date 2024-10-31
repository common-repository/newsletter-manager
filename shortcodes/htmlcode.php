<?php
global $wpdb;
?><script>
function xyz_em_verify_fields()
{
var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,})$/;
var address = document.subscription.xyz_em_email.value;
if(reg.test(address) == false) {
	alert("<?php _e( 'Please check whether the email is correct.', 'newsletter-manager' ); ?>");
return false;
}else{
//document.subscription.submit();
return true;
}
}
function xyz_unsubscribe_tckbox(){
//tb_show("Unsubscribe Your Email","#TB_inline?width=50%&amp;height=20%&amp;inlineId=show_nlm_email_unsubscribe&class=thickbox");
	document.getElementById("show_nlm_email_unsubscribe").style.display = "block";
	document.getElementById("outer_div").style.display = "block";
}
function xyz_em_email_unsubscribe_html(){
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,})$/;
var address = document.unsubscribe_form_html.xyz_nlm_email_unsubscribe.value;
	if(reg.test(address) == false)
	{
		alert("<?php _e( 'Please check whether the email is correct.', 'newsletter-manager' ); ?>");
	document.unsubscribe_form_html.xyz_nlm_email_unsubscribe.focus();

		return false;
	}
	else
	{
		return true;
	}
}
function xyz_nlm_close_thickbox()
{
	document.getElementById("show_nlm_email_unsubscribe").style.display = "none";
	document.getElementById("outer_div").style.display = "none";
	}
</script>
<style>
#table_nlm_em_unsubscribe td ,#table_nlm_em_subscribe td{
	border:none;
}
</style>
<form method="POST" name="subscription" id="subscription" action="<?php echo get_site_url()."/index.php?wp_nlm=subscribe";?>">
<input type="hidden" name="subscribe_nonce" id="subsc_nounce">
<table id="table_nlm_em_subscribe">
<tr>
<td colspan="2">
<span style="font-size:14px;"><b><?php echo esc_html(get_option('xyz_em_widgetName'))?></b></span>
</td>
</tr>
<tr >
<td  width="200px"><?php _e( 'Name', 'newsletter-manager' ); ?></td>
<td >
<input  name="xyz_em_name" type="text" />
</td>
</tr>
<tr >
<td  ><label style="display: inline-block !important;"><?php _e( 'Email Address', 'newsletter-manager' ); ?></label><span style="color:#FF0000">*</span></td>
<td >
<input  name="xyz_em_email" type="text" />
</td>
</tr>
	<?php if(get_option('xyz_em_captcha')=="1")
	{
	    $publickey = get_option('xyz_em_recaptcha_public_key');
	   ?>
	   <tr >
<td></td>
<td>
<?php
if($publickey != ''){
    $url = '//www.google.com/recaptcha/api.js';
    ?>
   <div class="g-recaptcha"  data-sitekey="<?php  echo $publickey;?> "  >
  </div><span style="color:red;">*</span><script type="text/javascript" src="<?php  echo $url ;?> "></script>
 <div style="font-weight: normal;color:red;" ></div>
 <?php
}else
{
    ?>
    <span style="color:red;"><?php _e( 'Set reCaptcha Site key & Secret key', 'newsletter-manager' ); ?></span>
    <?php
}
	?></td>
</tr>
	<?php
	}
?>
<tr>
<td></td>
<td>
<div style="height:40px;"><input name="htmlSubmit"  id="submit_em" class="button-primary" type="submit" value="<?php _e( 'Subscribe', 'newsletter-manager' ); ?>" onclick="javascript: if(!xyz_em_verify_fields()) return false; "  /></div>
</td>
</tr>
<tr>
<td>
</td>
<td>
<a  onclick=xyz_unsubscribe_tckbox();><?php _e( 'Unsubscribe Your Email', 'newsletter-manager' ); ?></a>
</td>
</tr>
</table>
</form>
<div id="outer_div" style="display:none;" >
</div>
<div id="show_nlm_email_unsubscribe"  class="xyz_nlm_thickbox" style="display:none;">
<form method="POST" name="unsubscribe_form_html" action="<?php echo get_site_url()."/index.php?wp_nlm=unsubscribe_confirmation";?>">
<input type="hidden" name="unsubscribe_nonce" id="unsubsc_nounce">
<table id='table_nlm_em_unsubscribe' class="pop">
<tr>
<td colspan="2">
<b><?php _e( 'Unsubscribe Your Email', 'newsletter-manager' ); ?></b>
<img src="<?php echo plugins_url("newsletter-manager/images/close.png");?>" style="float:right;
    height: 15px;cursor: pointer; text-align: right;" onclick="xyz_nlm_close_thickbox()">
</td>
</tr>
<tr >
	<td><?php _e( 'Email Address', 'newsletter-manager' ); ?> <span style="color:red;">*</span></td>
	<td>
	<input style="width: 100% !important;"  name="xyz_nlm_email_unsubscribe" id="xyz_nlm_email_unsubscribe"  type="text" />
	</td>
</tr>
<tr>
<td ></td>
<td>
<input type="submit"  name="unsubscribe_sub" id="unsubscribe_sub" value="<?php _e( 'Submit', 'newsletter-manager' ); ?>" onclick="javascript: if(!xyz_em_email_unsubscribe_html()) return false; " ></td>

</tr>
<tr >
<td colspan="2"><?php _e( 'We shall send a confirmation email to the address provided,Please follow the link in the email.', 'newsletter-manager' ); ?></td></tr>
</table>
</form>
</div>
<?php
if(isset($_POST['unsubscribe_sub']))
{
    if (
        ! isset( $_REQUEST['unsubscribe_nonce'] )
        || ! wp_verify_nonce( $_REQUEST['unsubscribe_nonce'], 'xyz_nlm_email_unsubscribe')
        ) {
            wp_nonce_ays( 'xyz_nlm_email_unsubscribe');

            exit();
        }
				?>
				<script>
				document.getElementById("subscription").style.display = "none";
				document.getElementById("outer_div").style.display = "none";
				</script>
				<?php
    $unsubscribe_email=sanitize_email($_POST['xyz_nlm_email_unsubscribe']);
    $xyz_em_email_count = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_address WHERE  email =%s',$unsubscribe_email )) ;
    if(!empty($xyz_em_email_count)){
				$xyz_em_subject=$xyz_em_fieldInfoDefaultValue='';
        $xyz_em_emailTempalteDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id=4') ;
        $xyz_em_emailTempalteDetails = $xyz_em_emailTempalteDetails[0];
        $xyz_em_emailTempalteMessage = $xyz_em_emailTempalteDetails->message;
        $xyz_em_fieldInfoDetails = $wpdb->get_results( 'SELECT default_value FROM '.$wpdb->prefix.'xyz_em_additional_field_info WHERE field_name="Name"' ) ;
				if(!empty($xyz_em_fieldInfoDetails) && !empty( $xyz_em_fieldInfoDetails[0]))
					$xyz_em_fieldInfoDefaultValue = $xyz_em_fieldInfoDetails[0]->default_value;
        $xyz_em_fieldValueDetails = $wpdb->get_results( $wpdb->prepare( "SELECT field1 FROM ".$wpdb->prefix."xyz_em_additional_field_value WHERE ea_id= %d",$xyz_em_email_count->id) ) ;
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
        $xyz_em_conf_unsub_link = '{update_sub_status_url}';
      $xyz_em_senderName = get_option('xyz_em_dsn');
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
      if(get_option('xyz_em_sendViaSmtp') == 1){
        $xyz_em_SmtpDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_sender_email_address WHERE  set_default ="1"' ) ;
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
        $xyz_em_senderEmail = get_option('xyz_em_dse');
        $phpmailer->From     = $xyz_em_senderEmail;
        $phpmailer->FromName = $xyz_em_senderName;
        $phpmailer->AddReplyTo($xyz_em_senderEmail,$xyz_em_senderName);
    }
    $list_id=1;
    $combineValues =  $xyz_em_email_count->id.$list_id.strtolower($xyz_em_email_count->email);
    $both = md5($combineValues);
    $campId=0;
    $unsubscriptionLink = get_site_url()."/index.php?wp_nlm=unsubscribe&eId=".$xyz_em_email_count->id."&lId=".$list_id."&both=".$both."&campId=".$campId;
    add_filter( 'nonce_life','xyz_em_filter_nonce_life');
    $unsubscriptionLink=wp_nonce_url( $unsubscriptionLink, 'xyz_em_email_unsubscribe_'.$xyz_em_email_count->id);
    remove_filter('nonce_life', 'xyz_em_filter_nonce_life');
    $xyz_em_messageToSendPending = nl2br(str_replace($xyz_em_conf_unsub_link,$unsubscriptionLink,$xyz_em_emailTempalteMessage));
    $phpmailer->Subject = $xyz_em_subject;
    $phpmailer->MsgHTML($xyz_em_messageToSendPending);
  //  print_r($xyz_em_messageToSendPending);
    $phpmailer->AddAddress($unsubscribe_email);
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
		if($sent == TRUE) {
			echo 'An unsubscription email has been sent. Please follow the instructions in the email';
		}
}




}
?>
<style type="text/css">
.xyz_nlm_thickbox{
    position: fixed;
    background-color: rgb(255, 255, 255);
    text-align: left;
    top: 10%;
    left: 35%;
    width: 410px;
    box-shadow: rgba(0, 0, 0, 0.3) 0px 3px 6px;
    padding: 20px;
    z-index: 999 !important;
}
    #outer_div {
    background: #000;
    opacity: 0.7;
    filter: alpha(opacity=70);
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 99; /* Above DFW. */
         width: 100%;
    max-width: 100%;
    height: 100%;
    max-height: 100%;
}
.entry .entry-content > *, .entry .entry-summary > *{margin:0px !important;}
@media screen and (max-width: 532px){
    .xyz_nlm_thickbox { width: 80%;
    left: 10%;
    top:10%}
    }
    @media screen and (max-width: 990px){
    .xyz_nlm_thickbox {
    left: 28%;
    }
    }
     @media screen and (max-width: 767px){
     .pop {font-size:12px;}
    .xyz_nlm_thickbox {
    left: 20%;
    width: 350px;
    }
}
@media screen and (max-width: 480px){
.xyz_nlm_thickbox {
    left: 17%;
    width: 250px;
    }
}
}
@media screen and (max-width: 400px){
.xyz_nlm_thickbox {
    left: 17%;
    width: 250px;
    }
}
}
</style>
