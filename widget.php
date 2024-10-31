<?php
if ( ! defined( 'ABSPATH' ) ) exit;

////*****************************Sidebar Widget**********************************////
class Xyz_nlm_Widget extends WP_Widget {
  public function __construct() {
    parent::__construct(
      'xyz_nlm_widget', // Base ID
      'Newsletter Manager', // Name
      array(
        'description' => 'A simple widget to display nl optin form.',
      )
    );
	}
  public function widget( $args, $instance ) {
    $title = isset($instance['title']) ? apply_filters('widget_title', $instance['title']) : '';
		$default_optin_name=get_option('xyz_em_widgetName');
    echo $args['before_widget']; // Render before widget HTML
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
}
		else {
			echo $args['before_title'] . $default_optin_name . $args['after_title'];
		}
?>
<script>
	function verify_fields()
	{
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,})$/;
	var address = document.subscription.xyz_em_email.value;
	if(reg.test(address) == false) {
	alert("<?php _e( 'Please check whether the email is correct.', 'newsletter-manager' ); ?>");
	return false;
}else{
document.subscription.submit();
}
}
	function xyz_unsubscribe_tckbox(){
		//tb_show("Unsubscribe Your Email","#TB_inline?width=500&amp;height=200&amp;inlineId=show_nlm_email_unsubscribe&class=thickbox");
		document.getElementById("show_nlm_email_unsubscribe").style.display = "block";
		document.getElementById("outer_div").style.display = "block";
			}
		function xyz_em_email_unsubscribe(){
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,})$/;
			var address = document.unsubscribe_form.xyz_nlm_email_unsubscribe.value;
			if(reg.test(address) == false)
			{
				alert("<?php _e( 'Please check whether the email is correct.', 'newsletter-manager' ); ?>");
				document.unsubscribe_form.xyz_nlm_email_unsubscribe.focus();
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
.buttonWidget {
	width: 90px;
}
 .xyz_nlm_thickbox{
   position: fixed;
    background-color: rgb(255, 255, 255);
    text-align: left;
    top: 35%;
    left: 28%;
    width: 50%;
    box-shadow: rgba(0, 0, 0, 0.3) 0px 3px 6px;
    padding: 20px;
    z-index: 999 !important;
    }
    @media screen and (max-width: 532px){
    .xyz_nlm_thickbox { width: 80%;
     left: 10%;}}

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
}
</style>
		<form method="POST" name="subscription" id="subscription_widget" action="<?php echo get_site_url()."/index.php?wp_nlm=subscribe";?>">
		<?php wp_nonce_field( 'xyz_nlm_subscription','subscribe_nonce' );?>
	<table >
		<tr>
		</tr>
		<tr>
			<td width="200"><?php _e( 'Name', 'newsletter-manager' ); ?></td>
		</tr>
		<tr>
			<td><input name="xyz_em_name" type="text" />
			</td>
		</tr>
		<tr>
			<td width="200"><label style="display: inline-block !important;"><?php _e( 'Email Address', 'newsletter-manager' ); ?><span style="color: #FF0000">*</span>
			</td>
		</tr>
		<tr>
			<td><input name="xyz_em_email" type="text" />
			</td>
		</tr>
<?php if(get_option('xyz_em_captcha')=="1")
	{
	    $publickey = get_option('xyz_em_recaptcha_public_key');
	   ?>
	   <tr >

<td id="tdTop">

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
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>

				<div style="height: 20px;">
					<input id="submit_em" class="buttonWidget" type="submit" style="padding:4px !important"
						value="<?php _e( 'Subscribe', 'newsletter-manager' ); ?>"
						onclick="javascript: if(!verify_fields()) return false; " />

				</div>

			</td>

		</tr>
		<tr>
<td>
<a  onclick=xyz_unsubscribe_tckbox();><?php _e( 'Unsubscribe Your Email', 'newsletter-manager' ); ?></a>

</td>
</tr>

	</table>
		</form>
<div id="outer_div" style="display:none;" >
</div>

<div id="show_nlm_email_unsubscribe" class="xyz_nlm_thickbox"  style="display:none;">
<form method="POST" name="unsubscribe_form" >
		<?php wp_nonce_field('xyz_nlm_email_unsubscribe' );?>
<table>
<tr>
<td>
<b><?php _e( 'Unsubscribe Your Email', 'newsletter-manager' ); ?></b>

</td><td>
</td>
<td >
<img src="<?php echo plugins_url("xyz-wp-newsletter/images/close.png");?>" style="
    height: 20%;cursor: pointer; text-align: right;" onclick="xyz_nlm_close_thickbox()">
</td>
</tr>
<tr >
	<td id="tdTop" ><?php _e( 'Email Address', 'newsletter-manager' ); ?></td>
	<td id="tdTop">
	<input  style="width: 100% !important;" name="xyz_nlm_email_unsubscribe" id="xyz_nlm_email_unsubscribe"  type="text" />&nbsp;<span style="color:red;">*</span>
	</td>
</tr>
<tr>
<td id="tdTop" ></td>
<td id="tdTop" >
<input type="submit"  name="unsubscribe_sub" id="unsubscribe_sub" value="<?php _e( 'Submit', 'newsletter-manager' ); ?>" onclick="javascript: if(!xyz_em_email_unsubscribe()) return false; " ></td>
</tr>
<tr >
<td colspan="2" id="tdTop"><?php _e( 'We shall send a confirmation email to the address provided,Please follow the link in the email.', 'newsletter-manager' ); ?></td></tr>
</table>
</form>
</div>
	<?php
	if(isset($_POST['unsubscribe_sub']))
	{
	    if (
	        ! isset( $_REQUEST['_wpnonce'] )
						|| ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'xyz_nlm_email_unsubscribe')
	        ) {
	            wp_nonce_ays( 'email_unsubscribe');
	            exit();
						}
            ?>
    			 <script>
    			 	document.getElementById("subscription_widget").style.display = "none";
    			 	document.getElementById("outer_div").style.display = "none";
    			 </script>
    			 <?php

	   global $wpdb;
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
        			echo 'An unsubscription confirmation email has been sent. Please follow the instructions in the email';
            }
				}
		}
    echo $args['after_widget']; // Render after widget HTML
	    }

  public function form( $instance ) {
    $title = isset( $instance['title'] ) ? $instance['title'] : get_option('xyz_em_widgetName');
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <?php
	}
  /**
   * Processes widget settings data after saving.
   *
   * @param array $new_instance New settings data
   * @param array $old_instance Previous settings data
   * @return array Sanitized and validated settings data
   */
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = sanitize_text_field( $new_instance['title'] );

    return $instance;
}
}

function register_xyz_nlm_widget() {
  register_widget( 'Xyz_nlm_Widget' );
}
add_action( 'widgets_init', 'register_xyz_nlm_widget' );

/////*****************************Dashboard Widget**********************************////

class Xyz_nlm_Dashboard_Widget extends WP_Widget {
  public function __construct() {
    parent::__construct(
      'xyz_nlm_dashboard_widget', // Base ID
      'Xyz nlm Dashboard Widget', // Name
      array(
        'description' => 'A simple widget to display dashboard widget.',
      )
    );
	}
  public function widget( $args, $instance ) {
	global $wpdb;
	?>
<div>
<fieldset
style="width: 98%; border: 1px solid #F7F7F7; padding: 10px 0px 15px 10px;">
<legend>Email Address Statistics</legend>
<table class="widefat" style="width: 99%;">
<tr valign="top">
<td scope="row" style="width:20%;" id="bottomBorderNone"><label
for="">Pending&nbsp;:</label>
</td>
<td class="settingInput" id="bottomBorderNone">
<?php
$xyz_em_pendingCount = $wpdb->get_results("SELECT ea.id,ea.email,em.status FROM ".$wpdb->prefix."xyz_em_email_address ea INNER JOIN ".$wpdb->prefix."xyz_em_address_list_mapping em ON ea.id=em.ea_id WHERE em.status='-1'");
echo count($xyz_em_pendingCount);
?></td>
<td scope="row" style="width:20%;" id="bottomBorderNone"><label
for="">Active&nbsp;:</label>
</td>
<td class="settingInput" id="bottomBorderNone">
<?php
$xyz_em_activeCount = $wpdb->get_results("SELECT ea.id,ea.email,em.status FROM ".$wpdb->prefix."xyz_em_email_address ea INNER JOIN ".$wpdb->prefix."xyz_em_address_list_mapping em ON ea.id=em.ea_id WHERE em.status='1'");
echo  count($xyz_em_activeCount);
?></td>
<td scope="row" style="width:20%;" id="bottomBorderNone" ><label
for="">Unsubscribed&nbsp;:</label>
</td>
<td class="settingInput" id="bottomBorderNone">
<?php
$xyz_em_unsubscribedCount = $wpdb->get_results("SELECT ea.id,ea.email,em.status FROM ".$wpdb->prefix."xyz_em_email_address ea INNER JOIN ".$wpdb->prefix."xyz_em_address_list_mapping em ON ea.id=em.ea_id WHERE em.status='0'");
echo count($xyz_em_unsubscribedCount);
?> </td>
</tr>
</table>
</fieldset>
<fieldset
style="width: 98%; border: 1px solid #F7F7F7; padding: 10px 0px 15px 10px;">
<legend>Queue Statistics</legend>
<table class="widefat" style="width: 99%;">
<tr valign="top">
<td scope="row" style="width:80%;" id="bottomBorderNone"><label
for="">Email Fired In Current Hour / Hourly Email Sending Limit &nbsp;:</label>
</td>
<td class="settingInput" id="bottomBorderNone"><div  style="margin-left:10px;"><?php echo get_option('xyz_em_hourly_email_sent_count');?> / <?php echo get_option('xyz_em_hesl');?></div></td>
</tr>
</table>
</fieldset>
<fieldset
style="width: 98%; border: 1px solid #F7F7F7; padding: 10px 0px 15px 10px;">
<legend>Campaign Statistics</legend>
<table class="widefat" style="width: 99%;">
<tr valign="top">
<td scope="row" style="width:20%;" id="bottomBorderNone"><label
for="">Pending&nbsp;:</label>
</td>
<td class="settingInput" id="bottomBorderNone">
<?php
$xyz_em_pendingCampaignCount = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."xyz_em_email_campaign  WHERE status='-1'");
echo  count($xyz_em_pendingCampaignCount);
?></td>
<td scope="row" style="width:20%;" id="bottomBorderNone"><label
for="">Active&nbsp;:</label>
</td>
<td class="settingInput" id="bottomBorderNone">
<?php
$xyz_em_activeCampaignCount = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."xyz_em_email_campaign  WHERE status='1'");
echo count($xyz_em_activeCampaignCount);
?></td>
<td scope="row" style="width:20%;" id="bottomBorderNone"><label
for="">Paused&nbsp;:</label>
</td>
<td class="settingInput" id="bottomBorderNone">
<?php
$xyz_em_pausedCampaignCount = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."xyz_em_email_campaign  WHERE status='0'");
echo count($xyz_em_pausedCampaignCount);
?></td>
</tr>
</table>
</fieldset>
<fieldset
style="width: 98%; border: 1px solid #F7F7F7; padding: 10px 0px 15px 10px;">
<legend>Cron Execution Info</legend>
<table class="widefat" style="width: 99%;">
<tr valign="top">
<td scope="row" style="width:16%;" id="bottomBorderNone" ><label
for="">Start Time:</label>
</td>
<td style="width:34%;" id="bottomBorderNone"><?php
if(get_option('xyz_em_cronStartTime') != 0){
echo xyz_local_date_time("d-m-Y H:i:s",get_option('xyz_em_cronStartTime'));
}else{
echo "NA";
}
?></td>
<td scope="row" style="width:16%;" id="bottomBorderNone"><label
for="">End Time:</label>
</td>
<td style="width:34%; " id="bottomBorderNone"><?php
if(get_option('xyz_em_CronEndTime') != 0){
echo xyz_local_date_time("d-m-Y H:i:s",get_option('xyz_em_CronEndTime'));
}else{
echo "NA";
}
?></td>
</tr>
</table>
</fieldset>

</div>
<?php
}
  public function dashboard_widget() {
    // You can reuse the same code as the widget method if needed
    $this->widget(array(), array('title' => 'Newsletter Statistics'));
}
}
// Register the dashboard widget
function register_xyz_nlm_dashboard_widget() {
  $widget = new Xyz_nlm_Dashboard_Widget();
  wp_add_dashboard_widget(
    'xyz-em-custom-widget',
    'Newsletter Statistics', // Widget name displayed in admin
    array($widget, 'dashboard_widget'), // Method to display the widget
    array(
      'description' => 'A simple widget for wp dashboard.',
    )
  );
}
add_action( 'wp_dashboard_setup', 'register_xyz_nlm_dashboard_widget' );

/////***************************************************************////
