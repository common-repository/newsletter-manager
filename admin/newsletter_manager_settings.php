<?php
if ( ! defined( 'ABSPATH' ) ) exit;
include(dirname( __FILE__ ) . '/../emoji.php');
if(isset($_GET['nlm_notice']) && $_GET['nlm_notice'] == 'hide')
{
update_option('xyz_nlm_dnt_shw_notice', "hide");
?>
<style type='text/css'>
#nlm_notice_td
{
display:none;
}
</style>
<div class="system_notice_area_style1" id="system_notice_area">
Thanks again for using the plugin. We will never show the message again.
&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
global $wpdb;
// Load the options

$xyz_em_SmtpFlag = 0;

if($_POST){
	if (
			! isset( $_REQUEST['_wpnonce'] )
			|| ! wp_verify_nonce( $_REQUEST['_wpnonce'],'add-setting' )
	) {
		wp_nonce_ays( 'add-setting');
		exit;

	}

// 	echo "hesl:".$_POST['xyz_em_hesl']."<br/>";
// 	echo "dsel:".$_POST['xyz_em_dse']."<br/>";
// 	echo "dsn:".$_POST['xyz_em_dsn']."<br/>";
// 	echo "dsubname:".$_POST['xyz_em_dsubname']."<br/>";die;
$_POST=xyz_trim_deep($_POST);
$_POST = stripslashes_deep($_POST);

if (($_POST['xyz_em_hesl']!= "") && ($_POST['xyz_em_dse'] != "") && ($_POST['xyz_em_dsn'] != "") && ($_POST['xyz_em_dsubname']!= "")
		&& ($_POST['xyz_em_afterSubscription']!= "") && ($_POST['xyz_em_emailConfirmation']!= "") && ($_POST['xyz_em_redirectAfterLink']!= "") ){
			$xyz_em_hesl = abs(intval($_POST['xyz_em_hesl']));

			$xyz_em_sendViaSmtp = intval($_POST['xyz_em_sendViaSmtp']);

			if($xyz_em_sendViaSmtp == 1){

				$checkSMTP = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."xyz_em_sender_email_address WHERE set_default='1'");
				if(count($checkSMTP) == 0){
					$xyz_em_SmtpFlag = 1;
				}

			}
			if($xyz_em_SmtpFlag != 1){


	if ( $xyz_em_hesl > 0 ){
		if(is_email($_POST['xyz_em_dse'])){

			$xyz_em_filter =intval($_POST['xyz_em_filter']);

			$xyz_em_dss = sanitize_text_field($_POST['xyz_em_dss']);
			$xyz_em_defaultEditor = sanitize_text_field($_POST['xyz_em_defaultEditor']);

			$xyz_em_dse = sanitize_text_field($_POST['xyz_em_dse']);
			$xyz_em_dsn = sanitize_text_field($_POST['xyz_em_dsn']);
			$xyz_em_enableWelcomeEmail = sanitize_text_field($_POST['xyz_em_enableWelcomeEmail']);
			$xyz_em_enableUnsubNotification = sanitize_text_field($_POST['xyz_em_enableUnsubNotification']);

			$xyz_em_hidepmAds = intval($_POST['xyz_em_hidepmAds']);

			$xyz_em_afterSubscription = strip_tags($_POST['xyz_em_afterSubscription']);
			$xyz_em_emailConfirmation = strip_tags($_POST['xyz_em_emailConfirmation']);
			$xyz_em_redirectAfterLink = strip_tags($_POST['xyz_em_redirectAfterLink']);

			$xyz_em_limit = abs(intval($_POST['xyz_em_limit']));
			$xyz_cfm_nlm_code =sanitize_text_field($_POST['xyz_cfm_nlm_code']);
			$xyz_em_widgetName =sanitize_text_field($_POST['xyz_em_widgetName']);

			$xyz_em_credit = $_POST['xyz_em_credit']; //em or 0
			$xyz_em_recaptchaPrivateKey = sanitize_text_field($_POST['xyz_em_recaptchaPrivateKey']);
			$xyz_em_recaptchaPublicKey = sanitize_text_field($_POST['xyz_em_recaptchaPublicKey']);

			$xyz_em_SmtpDebug =intval($_POST['xyz_em_SmtpDebug']);

			$xyz_em_captcha=intval($_POST['xyz_em_captcha']);



			$xyz_em_copy_to_admin=intval($_POST['xyz_em_copy_to_admin']);
			$xyz_em_sub_screenshot_mail=intval($_POST['xyz_em_sub_screenshot_mail']);
			$xyz_em_sub_screenshot_mail_attachements=$_FILES['xyz_em_sub_screenshot_mail_attachements']['name'];
			$xyz_em_unsubscribe_copy_to_admin=intval($_POST['xyz_em_unsubscribe_copy_to_admin']);





			if ( $xyz_em_limit > 0  ){

			update_option('xyz_em_tinymce_filter',$xyz_em_filter);
			update_option('xyz_em_hesl',$xyz_em_hesl);
			update_option('xyz_em_dss',$xyz_em_dss);
			update_option('xyz_em_defaultEditor',$xyz_em_defaultEditor);
			update_option('xyz_em_dse',$xyz_em_dse);
			update_option('xyz_em_dsn',$xyz_em_dsn);
			update_option('xyz_em_enableWelcomeEmail',$xyz_em_enableWelcomeEmail);
			update_option('xyz_em_enableUnsubNotification',$xyz_em_enableUnsubNotification);

			update_option('xyz_em_hidepmAds',$xyz_em_hidepmAds);

			update_option('xyz_em_afterSubscription',$xyz_em_afterSubscription);
			update_option('xyz_em_emailConfirmation',$xyz_em_emailConfirmation);
			update_option('xyz_em_redirectAfterLink',$xyz_em_redirectAfterLink);

			update_option('xyz_em_limit',$xyz_em_limit);
			update_option('xyz_cfm_nlm_code',$xyz_cfm_nlm_code);
			update_option('xyz_em_widgetName',$xyz_em_widgetName);

			update_option('xyz_credit_link',$xyz_em_credit);

			update_option('xyz_em_sendViaSmtp',$xyz_em_sendViaSmtp);
			update_option('xyz_em_SmtpDebug',$xyz_em_SmtpDebug);

			update_option('xyz_em_recaptcha_private_key',$xyz_em_recaptchaPrivateKey);
			update_option('xyz_em_recaptcha_public_key',$xyz_em_recaptchaPublicKey);
			update_option('xyz_em_captcha',$xyz_em_captcha);






			update_option('xyz_em_sub_copyto_admin',$xyz_em_copy_to_admin);
			update_option('xyz_em_sub_screenshot_mail',$xyz_em_sub_screenshot_mail);
			update_option('xyz_em_unsubscribe_copy_to_admin',$xyz_em_unsubscribe_copy_to_admin);


			        if(!empty($_FILES['xyz_em_sub_screenshot_mail_attachements']['name']) && $_FILES['xyz_em_sub_screenshot_mail_attachements']['name'][0]!=''){
			            $targetfolder = realpath(dirname(__FILE__) . '/../../../')."/uploads";
			            if (!is_file($targetfolder) && !is_dir($targetfolder)) {
			                mkdir($targetfolder) or die("Could not create directory " . $targetfolder);
			                chmod($targetfolder, 0777); //make it writable
			            }
			            $targetfolder = realpath(dirname(__FILE__) . '/../../../')."/uploads/xyz_em";
			            if (!is_file($targetfolder) && !is_dir($targetfolder)) {
			                mkdir($targetfolder) or die("Could not create directory " . $targetfolder);
			                chmod($targetfolder, 0777); //make it writable
			            }
			            $targetfolder = realpath(dirname(__FILE__) . '/../../../')."/uploads/xyz_em/subscription_screenshot";
			            if (!is_file($targetfolder) && !is_dir($targetfolder)) {
			                mkdir($targetfolder) or die("Could not create directory " . $targetfolder);
			                chmod($targetfolder, 0777); //make it writable
			            }


			            /* new file name creation*/
			            $extension = strtolower(pathinfo($_FILES['xyz_em_sub_screenshot_mail_attachements']['name'], PATHINFO_EXTENSION));

			            $file_name =  basename($_FILES['xyz_em_sub_screenshot_mail_attachements']['name'],'.'.$extension);

			            $finalFileName = xyz_insert_file($targetfolder, $file_name, 0, $extension);

			            move_uploaded_file($_FILES['xyz_em_sub_screenshot_mail_attachements']['tmp_name'],$targetfolder."/".$finalFileName);



			        }
			        if($xyz_em_sub_screenshot_mail_attachements!="")
			            update_option('xyz_em_sub_screenshot_mail_attachements',$xyz_em_sub_screenshot_mail_attachements);


			$xyz_em_dsubname =sanitize_text_field($_POST['xyz_em_dsubname']);
			$wpdb->update($wpdb->prefix.'xyz_em_additional_field_info', array('default_value'=>$xyz_em_dsubname), array('field_name'=>"Name"));

			$xyz_em_subject1 =sanitize_text_field($_POST['xyz_em_subject1']);
			//$xyz_em_message1 = $_POST['xyz_em_message1'];//textarea
			$xyz_em_message1 = xyz_em_string_To_Emoji($_POST['xyz_em_message1'],$xyz_em_emojis);
			$wpdb->update($wpdb->prefix.'xyz_em_email_template', array('subject'=>$xyz_em_subject1,'message'=>$xyz_em_message1), array('id'=>1));

			$xyz_em_subject2 = sanitize_text_field($_POST['xyz_em_subject2']);
			$xyz_em_message2 = xyz_em_string_To_Emoji($_POST['xyz_em_message2'],$xyz_em_emojis);
			$wpdb->update($wpdb->prefix.'xyz_em_email_template', array('subject'=>$xyz_em_subject2,'message'=>$xyz_em_message2), array('id'=>2));

			$xyz_em_subject3 = sanitize_text_field($_POST['xyz_em_subject3']);
			$xyz_em_message3 = xyz_em_string_To_Emoji($_POST['xyz_em_message3'],$xyz_em_emojis);
			$wpdb->update($wpdb->prefix.'xyz_em_email_template', array('subject'=>$xyz_em_subject3,'message'=>$xyz_em_message3), array('id'=>3));

			$xyz_em_subject4 = sanitize_text_field($_POST['xyz_em_subject4']);
			$xyz_em_message4 = xyz_em_string_To_Emoji($_POST['xyz_em_message4'],$xyz_em_emojis);
			$wpdb->update($wpdb->prefix.'xyz_em_email_template', array('subject'=>$xyz_em_subject4,'message'=>$xyz_em_message4), array('id'=>4));



?>


<div class="system_notice_area_style1" id="system_notice_area">
	Settings updated successfully. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>


<?php
			}else{
?>

	<div class="system_notice_area_style0" id="system_notice_area">
	Pagination Limit must be a positive whole number. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>

<?php
			}
		}else{
?>
<div class="system_notice_area_style0" id="system_notice_area">
	Please enter a valid email. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
		}
	}else{
?>
<div class="system_notice_area_style0" id="system_notice_area">
	Email sending limit must be a positive whole number. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
	}
}else{

	?>
	<div class="system_notice_area_style0" id="system_notice_area">
	Please set a default SMTP account. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
	</div>
	<?php

}
}else{
?>
<div class="system_notice_area_style0" id="system_notice_area">
	Please fill all fields. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
}


if(get_option('xyz_em_tinymce_filter')=="1"){
	require( dirname( __FILE__ ) . '/tinymce_filters.php' );
}

?>

<div>

	<h2>Settings</h2>
	<form method="post" enctype="multipart/form-data">
		<?php wp_nonce_field( 'add-setting' );?>
	<div style="float: left;width: 49%">
	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 0px 15px 10px;">
	<legend >General</legend>
	<table class="widefat"  style="width:99%;">
			<tr valign="top">
				<td scope="row" ><label for="xyz_em_filter">Tiny MCE filters to prevent auto removal of  &lt;br&gt; and &lt;p&gt; tags </label>
				</td>
				<td><select name="xyz_em_filter" id="xyz_em_filter">
						<option value="1"
						<?php if(isset($_POST['xyz_em_filter']) && $_POST['xyz_em_filter']=='1') { echo 'selected';}elseif(get_option('xyz_em_tinymce_filter')=="1"){echo 'selected';} ?>>Enable</option>
						<option value="0"
						<?php if(isset($_POST['xyz_em_filter']) && $_POST['xyz_em_filter']=='0') { echo 'selected';}elseif(get_option('xyz_em_tinymce_filter')=="0"){echo 'selected';} ?>>Disable</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_defaultEditor">HTML Campaign Editor </label>
				</td>
				<td><select name="xyz_em_defaultEditor" id="xyz_em_defaultEditor">
						<option value="HTML Editor"
						<?php if(isset($_POST['xyz_em_defaultEditor']) && $_POST['xyz_em_defaultEditor']=='HTML Editor') { echo 'selected';}elseif(get_option('xyz_em_defaultEditor')=="HTML Editor"){echo 'selected';} ?>>HTML Editor</option>
						<option value="Text Editor"
						<?php if(isset($_POST['xyz_em_defaultEditor']) && $_POST['xyz_em_defaultEditor']=='Text Editor') { echo 'selected';}elseif(get_option('xyz_em_defaultEditor')=="Text Editor"){echo 'selected';} ?>>Text Editor</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" ><label for="xyz_em_credit">Credit link to author</label>
				</td>
				<td><select name="xyz_em_credit" id="xyz_em_credit">
						<option value="em"
						<?php if(isset($_POST['xyz_em_credit']) && $_POST['xyz_em_credit']=='em') { echo 'selected';}elseif(get_option('xyz_credit_link')=="em"){echo 'selected';} ?>>Enable</option>
						<option value="0"
						<?php if(isset($_POST['xyz_em_credit']) && $_POST['xyz_em_credit']!='em') { echo 'selected';}elseif(get_option('xyz_credit_link')!="em"){echo 'selected';} ?>>Disable</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" id="bottomBorderNone"><label for="xyz_em_limit">Pagination Limit</label>
				</td>
				<td id="bottomBorderNone"><input  name="xyz_em_limit" type="text"
					id="xyz_em_limit" value="<?php if(isset($_POST['xyz_em_limit']) ){echo abs(intval($_POST['xyz_em_limit']));}else{print(get_option('xyz_em_limit'));} ?>" />
				</td>
			</tr>
			<tr valign="top">
        <td scope="row" class=" settingInput" ><label for="xyz_cfm_nlm_code">Contact Form to Newsletter Manager Integrity Verification Code</label>
    		<br/><span style="color: #0073aa;">[This is should be same for Contact Form Manager plugin]</span>
        </td>
        <td ><input  name="xyz_cfm_nlm_code" type="text"
          id="xyz_cfm_nlm_code" value="<?php if(isset($_POST['xyz_cfm_nlm_code']) && sanitize_text_field($_POST['xyz_cfm_nlm_code']) != ""){echo esc_attr ($_POST['xyz_cfm_nlm_code']);}else{echo esc_attr(get_option('xyz_cfm_nlm_code'));} ?>" />
        </td>
      </tr>


	</table>
	</fieldset>

	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 0px 15px 10px;">
	<legend>Email Sending Settings</legend>
	<table class="widefat"  style="width:99%;">
		<tr valign="top">
				<td scope="row" ><label for="xyz_em_sendViaSmtp">Send via SMTP</label>
				</td>
				<td><select name="xyz_em_sendViaSmtp" id="xyz_em_sendViaSmtp">
						<option value="1"
						<?php if(isset($_POST['xyz_em_sendViaSmtp']) && $_POST['xyz_em_sendViaSmtp']=='1') { echo 'selected';}elseif(get_option('xyz_em_sendViaSmtp')=="1"){echo 'selected';} ?>>True</option>
						<option value="0"
						<?php if(isset($_POST['xyz_em_sendViaSmtp']) && $_POST['xyz_em_sendViaSmtp']=='0') { echo 'selected';}elseif(get_option('xyz_em_sendViaSmtp')=="0"){echo 'selected';} ?>>False</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" ><label for="xyz_em_SmtpDebug">SMTP Debug</label>
				</td>
				<td><select name="xyz_em_SmtpDebug" id="xyz_em_SmtpDebug">
						<option value="2"
						<?php if(isset($_POST['xyz_em_SmtpDebug']) && $_POST['xyz_em_SmtpDebug']=='2') { echo 'selected';}elseif(get_option('xyz_em_SmtpDebug')=="2"){echo 'selected';} ?>>True</option>
						<option value="0"
						<?php if(isset($_POST['xyz_em_SmtpDebug']) && $_POST['xyz_em_SmtpDebug']=='0') { echo 'selected';}elseif(get_option('xyz_em_SmtpDebug')=="0"){echo 'selected';} ?>>False</option>

				</select>
				</td>
			</tr>
		<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_hesl">Hourly Email Sending Limit</label>
				</td>
				<td><input  name="xyz_em_hesl" type="text"
					id="xyz_em_hesl" value="<?php if(isset($_POST['xyz_em_hesl']) ){echo abs(intval($_POST['xyz_em_hesl']));}else{ print(absint(get_option('xyz_em_hesl'))); }?>" />
				</td>
			</tr>
	<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_dse">Default Sender Email</label>
				</td>
				<td><input name="xyz_em_dse" type="text" id="xyz_em_dse"
					value="<?php if(isset($_POST['xyz_em_dse']) ){echo esc_attr($_POST['xyz_em_dse']);}else{print(esc_attr(get_option('xyz_em_dse')));} ?>" /></td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_dsn">Default Sender Name</label>
				</td>
				<td><input name="xyz_em_dsn" type="text" id="xyz_em_dsn"
					value="<?php if(isset($_POST['xyz_em_dsn']) ){echo esc_attr($_POST['xyz_em_dsn']);}else{print(esc_attr(get_option('xyz_em_dsn')));} ?>" /></td>
			</tr>
			<tr valign="top">
				<td scope="row" id="bottomBorderNone" class=" settingInput"><label for="xyz_em_dse">Default Subscriber Name</label>
				</td>
				<td id="bottomBorderNone" ><input name="xyz_em_dsubname" type="text" id="xyz_em_dsubname"
					value="<?php
						if(isset($_POST['xyz_em_dsubname']) ){
							echo esc_attr($_POST['xyz_em_dsubname']);
						}else{
							global $wpdb;
							$defaultValue = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_em_additional_field_info WHERE field_name="Name" ' ) ;
							if(!empty($defaultValue) && !empty($defaultValue[0]))
							{
							$defaultValue = $defaultValue[0];
								echo esc_attr($defaultValue->default_value);							}
						}
					 ?>" /></td>
			</tr>

	</table>
	</fieldset>






</div>
	<div style="float: left;width: 49%;margin-left: 10px">
	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 5px 15px 5px;">
	<legend>Subscription</legend>
	<table class="widefat"  style="width:99%;">
			<tr valign="top">
				<td scope="row"  class="settingInput"><label for="xyz_em_hesl">Opt-in Form Title</label>
				</td>
				<td  ><input  name="xyz_em_widgetName" type="text"
					id="xyz_em_widgetName" value="<?php if(isset($_POST['xyz_em_widgetName'])){echo esc_attr($_POST['xyz_em_widgetName']);}else{ echo esc_attr(get_option('xyz_em_widgetName')); }?>" />
				</td>
			</tr>
	<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_dss">Opt-in Mode</label>
				</td>
				<td><select name="xyz_em_dss" id="xyz_em_dss" onchange="change_opt_in()">
						<option value="Active"
						<?php if(isset($_POST['xyz_em_dss']) && $_POST['xyz_em_dss']=='Active'){ echo 'selected';}elseif(get_option('xyz_em_dss')=="Active"){echo 'selected';} ?>>Single Opt-in</option>
						<option value="Pending"
						<?php if(isset($_POST['xyz_em_dss']) && $_POST['xyz_em_dss']=='Pending'){ echo 'selected';}elseif(get_option('xyz_em_dss')=="Pending"){echo 'selected';} ?>>Double Opt-in</option>

				</select>
				</td>
			</tr>


			<tr valign="top">
				<td scope="row" class=" settingInput" id="bottomBorderNone"><label for="xyz_em_enableWelcomeEmail">Enable
						Subscription Activation Email (Welcome mail)</label>
				</td>
				<td id="bottomBorderNone"><select name="xyz_em_enableWelcomeEmail"
					id="xyz_em_enableWelcomeEmail">
						<option value="True"
						<?php if(isset($_POST['xyz_em_enableWelcomeEmail']) && $_POST['xyz_em_enableWelcomeEmail']=='True'){ echo 'selected';}elseif(get_option('xyz_em_enableWelcomeEmail')=='True'){echo 'selected';}?>>True</option>
						<option value="False"
						<?php if(isset($_POST['xyz_em_enableWelcomeEmail']) && $_POST['xyz_em_enableWelcomeEmail']=='False'){ echo 'selected';}elseif(get_option('xyz_em_enableWelcomeEmail')=='False'){echo 'selected';} ?>>False</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" ><label for="xyz_em_captcha">Enable Captcha Verification	</label>
				</td>
				<td><select name="xyz_em_captcha" id="xyz_em_captcha">
						<option value=0
						<?php if(isset($_POST['xyz_em_captcha']) && $_POST['xyz_em_captcha']==0) { echo 'selected';}elseif(get_option('xyz_em_captcha')==0){echo 'selected';} ?>>False</option>
						<option value=1
						<?php if(isset($_POST['xyz_em_captcha']) && $_POST['xyz_em_captcha']==1) { echo 'selected';}elseif(get_option('xyz_em_captcha')==1){echo 'selected';} ?>>True</option>

				</select>
				</td>
			</tr>
				<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_recaptchaPrivateKey">ReCaptcha Secret Key</label>
				</td>
				<td><input  name="xyz_em_recaptchaPrivateKey" type="text"
					id="xyz_em_recaptchaPrivateKey" value="<?php if(isset($_POST['xyz_em_recaptchaPrivateKey']) && $_POST['xyz_em_recaptchaPrivateKey'] != ""){echo esc_attr ($_POST['xyz_em_recaptchaPrivateKey']);}else{print esc_attr(get_option('xyz_em_recaptcha_private_key'));} ?>" />
					&nbsp;&nbsp;&nbsp;<a target="_blank" href="https://www.google.com/recaptcha/admin">Get Secret Key</a>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_em_recaptchaPublicKey">ReCaptcha Site Key</label>
				</td>
				<td><input  name="xyz_em_recaptchaPublicKey" type="text"
					id="xyz_em_recaptchaPublicKey" value="<?php if(isset($_POST['xyz_em_recaptchaPublicKey']) && $_POST['xyz_em_recaptchaPublicKey'] != ""){echo esc_attr($_POST['xyz_em_recaptchaPublicKey']);}else{print esc_attr(get_option('xyz_em_recaptcha_public_key'));} ?>" />
					&nbsp;&nbsp;&nbsp;<a target="_blank" href="https://www.google.com/recaptcha/admin" >Get Site Key</a>
				</td>
			</tr>


	</table>
	</fieldset>


	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 5px 15px 5px;">
	<legend>Unsubscription</legend>
	<table class="widefat"  style="width:99%;">
			<tr valign="top">
				<td scope="row" class=" settingInput" id="bottomBorderNone"><label for="xyz_em_enableUnsubNotification">Enable
						Email on Unsubscription</label>
				</td>
				<td id="bottomBorderNone" ><select name="xyz_em_enableUnsubNotification"
					id="xyz_em_enableUnsubNotification">
						<option value="True"
						<?php if(isset($_POST['xyz_em_enableUnsubNotification']) && $_POST['xyz_em_enableUnsubNotification']=='True'){ echo 'selected';}elseif(get_option('xyz_em_enableUnsubNotification')=="True"){echo 'selected';}?>>True</option>
						<option value="False"
						<?php if(isset($_POST['xyz_em_enableUnsubNotification']) && $_POST['xyz_em_enableUnsubNotification']=='False'){ echo 'selected';}elseif(get_option('xyz_em_enableUnsubNotification')=="False"){echo 'selected';}?>>False</option>

				</select>
				</td>
			</tr>

	</table>
	</fieldset>

	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 5px 15px 5px;">
	<legend>Other Settings</legend>
	<table class="widefat"  style="width:99%;">

		<tr valign="top">
				<td scope="row" class=" settingInput" id="bottomBorderNone"><label for="xyz_em_hidepmAds">
						Hide premium version ads</label>
				</td>
				<td id="bottomBorderNone" style="width: 200px !important;"><select name="xyz_em_hidepmAds"
					id="xyz_em_hidepmAds">
						<option value="0"
						<?php if(isset($_POST['xyz_em_hidepmAds']) && $_POST['xyz_em_hidepmAds']==0){ echo 'selected';}elseif(get_option('xyz_em_hidepmAds')==0){echo 'selected';}?>>No</option>
						<option value="1"
						<?php if(isset($_POST['xyz_em_hidepmAds']) && $_POST['xyz_em_hidepmAds']==1){ echo 'selected';}elseif(get_option('xyz_em_hidepmAds')==1){echo 'selected';}?>>Yes</option>

				</select>
				</td>
			</tr>

	</table>
	</fieldset>

	</div>
	<div style="clear: both"></div>



	<fieldset style=" width:98%; border:1px solid #CEEAF7; padding:10px 0px 15px 10px;">
	<legend>GDPR Compliance</legend>
	<table class="widefat"  style="width:98%;">
		<tr valign="top">
				<td style="width:25%;"scope="row" ><label for="xyz_em_copy_to_admin">Send Subscription Confirmation Email Copy To Admin</label>
				</td>
				<td style="width:25%;"><select name="xyz_em_copy_to_admin" id="xyz_em_copy_to_admin" >
						<option value="1"
						<?php if(isset($_POST['xyz_em_copy_to_admin']) && $_POST['xyz_em_copy_to_admin']=='1') { echo 'selected';}elseif(get_option('xyz_em_sub_copyto_admin')=="1"){echo 'selected';} ?>>Yes</option>
						<option value="0"
						<?php if(isset($_POST['xyz_em_copy_to_admin']) && $_POST['xyz_em_copy_to_admin']=='0') { echo 'selected';}elseif(get_option('xyz_em_sub_copyto_admin')=="0"){echo 'selected';} ?>>No</option>
				</select>
				</td>
				<td style="width:20%; scope="row" ><label for="xyz_em_sub_screenshot_mail">Attach Subscription Page Screenshot To Confirmation Mail</label>
				</td>
				<td style="width:30%;"><select name="xyz_em_sub_screenshot_mail" id="xyz_em_sub_screenshot_mail" onchange="change_sub_confirm_admin()">
						<option value="0"
						<?php if(isset($_POST['xyz_em_sub_screenshot_mail']) && $_POST['xyz_em_sub_screenshot_mail']=='0') { echo 'selected';}elseif(get_option('xyz_em_sub_screenshot_mail')=="0"){echo 'selected';} ?>>No</option>
						<option value="1"
						<?php if(isset($_POST['xyz_em_sub_screenshot_mail']) && $_POST['xyz_em_sub_screenshot_mail']=='1') { echo 'selected';}elseif(get_option('xyz_em_sub_screenshot_mail')=="1"){echo 'selected';} ?>>Yes</option>
				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" ><label for="xyz_em_unsubscribe_copy_to_admin">Send Unsubscription Mail Copy To Admin</label>
				</td>
				<td><select name="xyz_em_unsubscribe_copy_to_admin" id="xyz_em_unsubscribe_copy_to_admin">
						<option value="1"
						<?php if(isset($_POST['xyz_em_unsubscribe_copy_to_admin']) && $_POST['xyz_em_unsubscribe_copy_to_admin']=='1') { echo 'selected';}elseif(get_option('xyz_em_unsubscribe_copy_to_admin')=="1"){echo 'selected';} ?>>Yes</option>
						<option value="0"
						<?php if(isset($_POST['xyz_em_unsubscribe_copy_to_admin']) && $_POST['xyz_em_unsubscribe_copy_to_admin']=='0') { echo 'selected';}elseif(get_option('xyz_em_unsubscribe_copy_to_admin')=="0"){echo 'selected';} ?>>No</option>
				</select>
				</td>
				<td scope="row" class=" settingInput copy_to_screenshot_tr"><label for="xyz_em_sub_screenshot_mail_attachements">Screenshot Of Subscription Page </label>
				</td>
				<td class="copy_to_screenshot_tr" colspan="2">
				<input type="file" name="xyz_em_sub_screenshot_mail_attachements" id="xyz_em_sub_screenshot_mail_attachements" >
					<?php
				$upload_dir=wp_get_upload_dir();
				$heimg= $upload_dir['baseurl'].'/xyz_em/subscription_screenshot/'.get_option('xyz_em_sub_screenshot_mail_attachements');
				if(get_option("xyz_em_sub_screenshot_mail") ==1 && get_option('xyz_em_sub_screenshot_mail_attachements') !=="")
				{ ?>
					<img id="subscreenshot_preview" style="width:50%;" src="<?php echo $heimg ; ?> "/>
				<?php } ?>
				</td>
			</tr>
	</table>
	</fieldset>
	<fieldset style=" width:98%; border:1px solid #CEEAF7; padding:10px 5px 15px 5px;">
	<legend>Shortcode Settings</legend>
	<table class="widefat"  style="width:99%;">
				<tr valign="top"><td style="width:50%; font-weight: 500;">Default URLs</td>
				<td style="font-weight: 500;">Shortcodes
				</td>
				</tr>
				<tr><td><td>[Note:Please copy the shortcode to corresponding pages]</td></tr>
				<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_afterSubscription">Page to be
						redirected after subscription (absolute path)</label>
				<br><input style="width:70%;" id="input" name="xyz_em_afterSubscription" type="text"
					id="xyz_em_afterSubscription"
					value="<?php if(isset($_POST['xyz_em_afterSubscription']) ) echo strip_tags($_POST['xyz_em_afterSubscription']); else echo strip_tags(get_option('xyz_em_afterSubscription'));//echo esc_attr(plugins_url("newsletter-manager/thanks.php"));?>" />
				</td>
				<td>
				<br>
				[xyz_em_thanks]
				</td>
			</tr>
			<tr valign="top" id="email_confirm_page_tr">
				<td scope="row"  class=" settingInput"><label for="xyz_em_emailConfirmation">Page to be
						redirected after email confirmation (absolute path)</label>
				<br><input style="width:70%;"id="input" name="xyz_em_emailConfirmation" type="text"
					id="xyz_em_emailConfirmation"
					value="<?php if(isset($_POST['xyz_em_emailConfirmation']) ) echo strip_tags($_POST['xyz_em_emailConfirmation']); else echo strip_tags(get_option('xyz_em_emailConfirmation'));//echo esc_attr(plugins_url("newsletter-manager/confirm.php"));?>" />
				</td>
				<td>
				[xyz_em_confirm]
				</td>
			</tr>
			<tr valign="top" id="email_confirm_page_tr">
				<td scope="row"  class=" settingInput"><label for="xyz_em_redirectAfterLink">Page to be redirected after unsubscription (absolute path)</label>
				<br><input style="width:70%;" id="input" name="xyz_em_redirectAfterLink" type="text"
					id="xyz_em_redirectAfterLink"
					value="<?php if(isset($_POST['xyz_em_redirectAfterLink']) ) echo strip_tags($_POST['xyz_em_redirectAfterLink']); else echo strip_tags(get_option('xyz_em_redirectAfterLink'));//echo esc_attr(plugins_url("newsletter-manager/unsubscribe.php"));?>" />
				</td>
				<td id="bottomBorderNone"  >
				[xyz_em_unsubscribe]
				</td>
			</tr>
	</table>
	</fieldset>





	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 0px 15px 10px;">
	<legend>Notification Messages</legend>
	<table class="widefat"  style="width:99%;">

			<tr>
			<td colspan="2"><b>Note :</b> You can use <b>{field1}</b> in the following messages in order to refer to the name of a subscriber.
			</td>
			</tr>

				<?php

				$xyz_em_template3 = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id=3') ;
				$xyz_em_template3 = $xyz_em_template3[0];

			?>

			<tr valign="top" id="confirm_sub_tr">
				<td scope="row" class=" settingInput" style="width:30%"><label for="xyz_em_subject3">Email Confirmation Subject</label>
				</td>
				<td><input  name="xyz_em_subject3" type="text"
					id="xyz_em_subject3" value="<?php
					if(isset($_POST['xyz_em_subject3']) ){echo esc_attr($_POST['xyz_em_subject3']);}else{echo esc_attr($xyz_em_template3->subject);}
					?>" />
				</td>
			</tr>
			<tr valign="top" id="confirm_body_tr">
				<td scope="row"  class=" settingInput"><label for="xyz_em_message2">Email Confirmation Message</label>
				</td>
				<td >

					<?php

					if(get_option('xyz_em_defaultEditor') == "Text Editor"){

					?>

					<textarea name="xyz_em_message3" type="text" id="xyz_em_message3" style="width:100%;margin-left:0px;"><?php

					if(isset($_POST['xyz_em_message3']) ){echo esc_textarea($_POST['xyz_em_message3']);}else{echo esc_textarea( $xyz_em_template3->message);} ?></textarea>
					<?php

					}elseif(get_option('xyz_em_defaultEditor') == "HTML Editor"){
						if(isset($_POST['xyz_em_message3']) ){
							wp_editor(($_POST['xyz_em_message3']),'xyz_em_message3');
						}else{
							wp_editor(($xyz_em_template3->message),'xyz_em_message3');
						}
					}
					?>

				</td>
			</tr>


	<?php

				$xyz_em_template1 = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id=1') ;
				$xyz_em_template1 = $xyz_em_template1[0];

			?>


			<tr valign="top">
				<td scope="row" class="settingInput"><label for="xyz_em_subject1">Subscription Activation Subject</label>
				</td>
				<td><input  name="xyz_em_subject1" type="text"
					id="xyz_em_subject1" value="<?php


						if(isset($_POST['xyz_em_subject1']) ){echo esc_attr($_POST['xyz_em_subject1']);}else{echo esc_attr($xyz_em_template1->subject);}


					?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_message1">Subscription Activation Message</label>
				</td>
				<td>

					<?php

					if(get_option('xyz_em_defaultEditor') == "Text Editor"){

					?>

					<textarea name="xyz_em_message1" type="text" id="xyz_em_message1" style="width:100%;margin-left:0px;"><?php

					if(isset($_POST['xyz_em_message1']) ){echo esc_textarea($_POST['xyz_em_message1']);}else{echo esc_textarea($xyz_em_template1->message);} ?></textarea>
					<?php

					}elseif(get_option('xyz_em_defaultEditor') == "HTML Editor"){
						if(isset($_POST['xyz_em_message1']) ){
							wp_editor(($_POST['xyz_em_message1']),'xyz_em_message1');
						}else{
							wp_editor(($xyz_em_template1->message),'xyz_em_message1');
						}
					}
					?>
				</td>
			</tr>

			<?php

				$xyz_em_template2 = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id=2') ;
				$xyz_em_template2 = $xyz_em_template2[0];

			?>

			<tr valign="top">
				<td scope="row" class=" settingInput"><label for="xyz_em_subject2">Email Unsubscription Subject</label>
				</td>
				<td><input  name="xyz_em_subject2" type="text"
					id="xyz_em_subject2" value="<?php
					//if($xyz_em_subject2 != ""){echo $xyz_em_subject2;}else{echo esc_attr($xyz_em_template2->subject);}
					if(isset($_POST['xyz_em_subject2']) ){
						echo esc_attr($_POST['xyz_em_subject2']);
					}else{echo esc_attr($xyz_em_template2->subject);
					}
					?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput"  id="bottomBorderNone"><label for="xyz_em_message2">Email Unsubscription Message</label>
				</td>
				<td  id="bottomBorderNone">

					<?php

					if(get_option('xyz_em_defaultEditor') == "Text Editor"){

					?>

					<textarea name="xyz_em_message2" type="text" id="xyz_em_message2" style="width:100%;margin-left:0px;"><?php

					if(isset($_POST['xyz_em_message2']) ){echo esc_textarea($_POST['xyz_em_message2']);}else{echo esc_textarea($xyz_em_template2->message);} ?></textarea>
					<?php

					}elseif(get_option('xyz_em_defaultEditor') == "HTML Editor"){
						if(isset($_POST['xyz_em_message2'])){
							wp_editor(($_POST['xyz_em_message2']),'xyz_em_message2');
						}else{
							wp_editor(($xyz_em_template2->message),'xyz_em_message2');
						}
					}
					?>

				</td>
			</tr>
			<?php

				$xyz_em_template4 = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_em_email_template WHERE id=4') ;
				$xyz_em_template4 = $xyz_em_template4[0];

			?>

			<tr valign="top">
				<td scope="row" class="settingInput"><label for="xyz_em_subject4"> Unsubscription confirmation Subject</label>
				</td>
				<td><input  name="xyz_em_subject4" type="text"
					id="xyz_em_subject4" value="<?php
					//if($xyz_em_subject2 != ""){echo $xyz_em_subject2;}else{echo esc_attr($xyz_em_template2->subject);}
					if(isset($_POST['xyz_em_subject4']) ){
						echo esc_attr($_POST['xyz_em_subject4']);
					}else{echo esc_attr($xyz_em_template4->subject);
					}
					?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput"  id="bottomBorderNone"><label for="xyz_em_message4">Unsubscription confirmation Message</label>
				</td>
				<td  id="bottomBorderNone">

					<?php

					if(get_option('xyz_em_defaultEditor') == "Text Editor"){

					?>

					<textarea name="xyz_em_message4"  id="xyz_em_message4" style="width:100%;margin-left:0px;"><?php

					if(isset($_POST['xyz_em_message4']) ){echo esc_textarea($_POST['xyz_em_message4']);}else{echo esc_textarea($xyz_em_template4->message);} ?></textarea>
					<?php

					}elseif(get_option('xyz_em_defaultEditor') == "HTML Editor"){
						if(isset($_POST['xyz_em_message4'])){
							wp_editor(($_POST['xyz_em_message4']),'xyz_em_message4');
						}else{
							wp_editor(($xyz_em_template4->message),'xyz_em_message4');
						}
					}
					?>

				</td>
			</tr>
	</table>
	</fieldset>







	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 5px 15px 5px;">
	<legend>Cron job command</legend>
	<table class="widefat"  style="width:99%;">
			<tr valign="top">
				<td>[Configure for every hour]<br>wget -O /dev/null --quiet <?php echo get_site_url()."/index.php?wp_nlm=cron"; ?></td>
			</tr>

	</table>
	</fieldset>

	<fieldset style=" width:98%; border:1px solid #F7F7F7; padding:10px 5px 15px 5px;">
	<legend>Note</legend>
		<table class="widefat"  style="width:99%;">
			<tr valign="top">
				<td colspan=2 id="bottomBorderNone">
					To link contact request emails to Newsletter Manager, use
					 Contact Form Manager (free) Version 1.3 or higher / XYZ WP Contact Form (premium) Version 1.1 or higher
				</td>
			</tr>
		</table>
	</fieldset>



	<fieldset style=" width:98%;padding:10px 0px 15px 10px;">
	<legend></legend>
	<table class="widefat"  style="width:99%; margin-top:10px;">
			<tr>
				<td colspan=2 id="bottomBorderNone" style="text-align: center;">
				<div style="height:50px;"><input style="margin:10px 0 20px 0;" id="submit_em" class="button-primary bottonWidth" type="submit" value=" Update Settings " /></div>

				</td>
			</tr>

		</table>
		</fieldset>
	</form>

</div>
<script type="text/javascript">
function change_opt_in()
{
	sel_opt_in=document.getElementById('xyz_em_dss').options[document.getElementById('xyz_em_dss').options.selectedIndex].value;
	if(sel_opt_in=='Active')
	{
		document.getElementById('email_confirm_page_tr').style.display='none';
		//document.getElementById('confirm_sub_tr').style.display='none';
		//document.getElementById('confirm_body_tr').style.display='none';
			}
	else
	{
		document.getElementById('email_confirm_page_tr').style.display='';
		//document.getElementById('confirm_sub_tr').style.display='';
		//document.getElementById('confirm_body_tr').style.display='';
	}
}
change_opt_in()
function change_sub_confirm_admin()
{


	sel_condition=document.getElementById('xyz_em_sub_screenshot_mail').options[document.getElementById('xyz_em_sub_screenshot_mail').options.selectedIndex].value;
	if(sel_condition=='0')
	{
// 		document.getElementById('copy_to_screenshot_tr').style.display='none';
		copy_to_screenshot=document.getElementsByClassName('copy_to_screenshot_tr');
		for (i = 0; i < copy_to_screenshot.length; i++) {
			copy_to_screenshot[i].style.display = "none";
	    }
			}
	else
	{
// 		document.getElementById('copy_to_screenshot_tr').style.display='';
		copy_to_screenshot=document.getElementsByClassName('copy_to_screenshot_tr');
		for (i = 0; i < copy_to_screenshot.length; i++) {
			copy_to_screenshot[i].style.display = "";
	    }
	}


	}

change_sub_confirm_admin();

</script>
