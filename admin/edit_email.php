<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$xyz_em_search='';
global $wpdb;
$_GET = stripslashes_deep($_GET);
if($_POST){
	$_POST = stripslashes_deep($_POST);
	$_POST = xyz_trim_deep($_POST);
	$xyz_em_emailId = abs(intval($_POST['emailId']));

	if (
			! isset( $_REQUEST['_wpnonce'] )
			|| ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'edit-email_'.$xyz_em_emailId )
	) {
	
		wp_nonce_ays( 'edit-email_'.$xyz_em_emailId );
	
		exit();
	
	} 




	$xyz_em_email = sanitize_email(trim($_POST['xyz_em_email']));
	$xyz_em_name = sanitize_text_field(trim($_POST['xyz_em_name']));
		$xyz_em_search = trim($_POST['search']);

		
		$xyz_em_pagenum = abs(intval($_POST['pageno']));

		if(is_email($xyz_em_email)){
			$email_count = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_em_email_address WHERE id!= %d AND email= '%s' LIMIT %d,%d",$xyz_em_emailId,$xyz_em_email,0,1) ) ;
			// 				echo '<pre>';
			// 				print_r($email_count);
			// 		die;
			if(count($email_count) == 0){
				
				$nameCount = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_em_additional_field_value WHERE ea_id= %d",$xyz_em_emailId) ) ;

				if(count($nameCount) > 0){
						
					$wpdb->update($wpdb->prefix.'xyz_em_additional_field_value',array('field1'=>$xyz_em_name),array('ea_id'=>$xyz_em_emailId));
						
				}else{
						
					$wpdb->insert($wpdb->prefix.'xyz_em_additional_field_value', array('ea_id' => $xyz_em_emailId,'field1' => $xyz_em_name),array('%d','%s'));
				}
						
					if($xyz_em_name=='')
						
						$wpdb->query( $wpdb->prepare( "DELETE FROM ".$wpdb->prefix."xyz_em_additional_field_value WHERE ea_id= %d",$xyz_em_emailId) ) ;
					
					$wpdb->update($wpdb->prefix.'xyz_em_email_address',array('email'=>$xyz_em_email),array('id'=>$xyz_em_emailId));
				
					if($xyz_em_search=='')
				header("Location:".admin_url('admin.php?page=newsletter-manager-manage-emails&emailmsg=1&pagenum='.$xyz_em_pagenum));
					else
				header("Location:".admin_url('admin.php?page=newsletter-manager-searchemails&search='.$xyz_em_search));
				exit();

			}else{
				?>
<div class="system_notice_area_style0" id="system_notice_area">
	Email already exists.&nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>

<?php
			}
		}else{
			?>
<div class="system_notice_area_style0" id="system_notice_area">
	Please enter a valid email.&nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>

<?php		
		}

	

}

$xyz_em_emailId = abs(intval($_GET['id']));

if(isset($_GET['pageno']) && $_GET['pageno'] != ""){
$xyz_em_pageno = abs(intval($_GET['pageno']));
}else{
	$xyz_em_pageno= 1;
}

if(isset($_GET['search']) && $_GET['search'] != "")
$xyz_em_search = trim($_GET['search']);
	

if($xyz_em_emailId==0){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-emails'));
	exit();

}
$emailres = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_em_email_address WHERE id= %d LIMIT %d,%d",$xyz_em_emailId,0,1) ) ;

if(count($emailres)==0){
	header("Location:".admin_url('admin.php?page=newsletter-manager-manage-emails'));
	exit();
}else{
	
	$nameres = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_em_additional_field_value WHERE ea_id= %d",$xyz_em_emailId) ) ;

		$emailDetails = $emailres[0];
		?>
<div>

	<h2>Edit Email</h2>
	<form method="post">
	<?php wp_nonce_field( 'edit-email_'.$xyz_em_emailId );?>
		<table class="widefat" style="width:99%;">

			<tr valign="top">
				<td scope="row"><label for="xyz_em_email">Email address</label>
				</td>
				<td><input name="xyz_em_email" type="text" id="xyz_em_email"
					value="<?php if(isset($_POST['xyz_em_email']) ){echo esc_attr($_POST['xyz_em_email']);}else{ echo esc_attr($emailDetails->email); }?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row"><label for="xyz_em_name">Name</label>
				</td>
				<td><input name="xyz_em_name" type="text" id="xyz_em_name"
					value="<?php
								if(isset($_POST['xyz_em_name']) ){
									echo esc_attr($_POST['xyz_em_name']);
								}else{								
									foreach ($nameres as $detailsName){
										echo esc_attr($detailsName->field1);
									}
								}
					?>" />
				</td>
			</tr>

			<tr>
				<td scope="row"></td>
				<td>
				<div style="height:50px;"><input style="margin:10px 0 20px 0;" id="submit_em" class="button-primary bottonWidth" type="submit" value="Update Email" /></div>
				</td>
			</tr>
			<tr>
				<td id="bottomBorderNone" scope="row"colspan="2" ><a
					href='javascript:history.back(-1);'>Go
						back </a>
				</td>
			</tr>
		</table>
		<input type="hidden" name="emailId"
			value="<?php echo $xyz_em_emailId; ?>">
		<input type="hidden" name="pageno"
			value="<?php echo $xyz_em_pageno; ?>">
		<input type="hidden" name="search"
			value="<?php echo ($xyz_em_search); ?>">
	</form>

</div>
<?php 

}

?>