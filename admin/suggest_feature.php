<?php
if( !defined('ABSPATH') ){ exit();}
global $wpdb;
$xyz_nlm_updateMessage="";
if(isset($_GET['msg'])){
    $xyz_nlm_updateMessage = absint($_GET['msg']);
}
if($xyz_nlm_updateMessage == 1){
        ?>
<div class="system_notice_area_style1" id="system_notice_area">
Thank you for the suggestion. <span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
else if($xyz_nlm_updateMessage == 2){
	?>
<div class="system_notice_area_style0" id="system_notice_area">
Please fill Suggestion Box.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
else if($xyz_nlm_updateMessage == 3){
    ?>
<div class="system_notice_area_style0" id="system_notice_area">
wp_mail not able to process the request.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}

if(isset($_POST['submit_em_suggested_feature']))
{
	
    if (
        ! isset( $_POST['_wpnonce'] )
        || ! wp_verify_nonce( $_POST['_wpnonce'],'newsletter_suggestion_feature' )
        ) {
            wp_nonce_ays( 'newsletter_suggestion_feature' );
            exit();
            
        }
    
 if (isset($_POST['xyz_nlm_suggestion_box']) && $_POST['xyz_nlm_suggestion_box']!='')
           {
        $xyz_nlm_mail_content=sanitize_textarea_field($_POST['xyz_nlm_suggestion_box']);
        $xyz_nlm_to_support_mail='support@xyzscripts.com';
        
       $xyz_nlm_sender_email=get_option('admin_email');
       
       $entries0 = $wpdb->get_results( $wpdb->prepare( 'SELECT display_name FROM '.$wpdb->base_prefix.'users WHERE user_email=%s',array($xyz_nlm_sender_email)));
       foreach( $entries0 as $entry ) {
           $xyz_nlm_sender_name=$entry->display_name;
       }
       
      
        $xyz_nlm_mail_subject="NEWSLETTER MANAGER - FEATURE SUGGESTION";
        $xyz_nlm_headers = array('From: '.$xyz_nlm_sender_name.' <'. $xyz_nlm_sender_email .'>' ,'Content-Type: text/html; charset=UTF-8');
        $wp_mail_nlm_sed= wp_mail( $xyz_nlm_to_support_mail, $xyz_nlm_mail_subject, $xyz_nlm_mail_content, $xyz_nlm_headers );
        
        if ($wp_mail_nlm_sed==true)
            header("Location:".admin_url('admin.php?page=newsletter-manager-feature&msg=1'));
        else
               header("Location:".admin_url('admin.php?page=newsletter-manager-feature&msg=3'));
      
        
        }
        else {
            header("Location:".admin_url('admin.php?page=newsletter-manager-feature&msg=2'));
            
            
        }
}
?>
<form method="post" >
<?php wp_nonce_field( 'newsletter_suggestion_feature' );?>
<h2>Contribute And Get Rewarded</h2>
<table style="border:1px solid #DFDFDF;border-radius:4px; padding:20px;margin-bottom:30px;">
<tr valign="top" >
<td>

<b>* Suggest a feature for this plugin and stand a chance to get a free copy of premium version of this plugin</b>
</td>
</tr>

<tr valign="top" >
<td>
<textarea name="xyz_nlm_suggestion_box" style="width:800px;height:250px !important;"  class="xyz_nlm_suggestion_box"></textarea>
</td>
</tr>
<tr>
<td>

<input style="margin:10px 0 20px 0;" id="submit_em_suggested_feature" name="submit_em_suggested_feature"  type="submit"  value="Send Mail To Us" >
</td>
</tr>
</table>
</form>




