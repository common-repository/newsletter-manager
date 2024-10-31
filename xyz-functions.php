<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/* Local time Insert */
if(!function_exists('xyz_local_date_time_create')){
	function xyz_local_date_time_create($timestamp){
		return $timestamp - ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
	}
}


/* Local time formating */
if(!function_exists('xyz_local_date_time')){
	function xyz_local_date_time($format,$timestamp){
		return gmdate($format, $timestamp + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ));
	}
}

/* new file name creation*/
if(!function_exists('xyz_insert_file')){
	function xyz_insert_file($path, $fileName, $i, $extension){
		$firstFileName=$fileName;
		if($i != 0){
			$fileName = $fileName.$i;
		}
		if (!file_exists($path."/".$fileName.".".$extension)) {
			return $fileName.".".$extension;
		} else {
			$j = $i + 1;
			return xyz_insert_file($path, $firstFileName, $j, $extension);
		}
	}

}
/* new file name creation*/

if(!function_exists('esc_textarea'))
{
function esc_textarea($text)
	{
		$safe_text = htmlspecialchars( $text, ENT_QUOTES );
		return $safe_text;
	}
}
if(!function_exists('xyz_trim_deep'))
{

function xyz_trim_deep($value) {
	if ( is_array($value) ) {
		$value = array_map('xyz_trim_deep', $value);
	} elseif ( is_object($value) ) {
		$vars = get_object_vars( $value );
		foreach ($vars as $key=>$data) {
			$value->{$key} = xyz_trim_deep( $data );
		}
	} else {
		$value = trim($value);
	}

	return $value;
}

}


if(!function_exists('xyz_em_plugin_get_version'))
{
	function xyz_em_plugin_get_version() 
	{
		if ( ! function_exists( 'get_plugins' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$plugin_folder = get_plugins( '/' . plugin_basename( dirname( XYZ_EM_PLUGIN_FILE ) ) );
		// 		print_r($plugin_folder);
		return $plugin_folder['newsletter-manager.php']['Version'];
	}
}

if(!function_exists('xyz_remove_extra_newlines'))
{
function xyz_remove_extra_newlines($str)
{
			$str=str_replace(array("\r\n","\r","\t"),"\n",$str);

			$lbcarr=explode("\n",$str);
			if(is_array($lbcarr))
			{
			$lbcarr_new=array();	
			foreach ($lbcarr as  $lbcarrvalue) {
				if(strlen(trim($lbcarrvalue))>0)
				{
					$lbcarr_new[]=$lbcarrvalue;
				}
			}
			$str=implode("\n",$lbcarr_new);
			}


				return  $str;
}
}
if(!function_exists('xyz_em_check_lan_ip'))
{
    function xyz_em_check_lan_ip($ip)
    {
        if (!isset($ip) || $ip =='' || $ip ==0 || ($ip >= '127.0.0.0' && $ip <= '127.255.255.255') || ($ip >= '10.0.0.0' && $ip <= '10.255.255.255') || ($ip >= '172.16.0.0' && $ip <= '172.31.255.255') || ($ip >= '192.168.0.0' && $ip <= '192.168.255.255') || ($ip >= '169.254.0.0' && $ip <= '169.254.255.255'))
            return false;
            
            return $ip;
    }
}
if(!function_exists('xyz_em_get_user_ip'))
{
    function xyz_em_get_user_ip()
    {
        $getip="";
        
        if(isset($_SERVER))
        {
            if(isset($_SERVER['HTTP_CLIENT_IP']) && xyz_em_check_lan_ip($_SERVER['HTTP_CLIENT_IP']))
                $getip= $_SERVER['HTTP_CLIENT_IP'];
                else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && xyz_em_check_lan_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                    $getip= $_SERVER['HTTP_X_FORWARDED_FOR'];
                    else if(isset($_SERVER['HTTP_X_FORWARDED']) && xyz_em_check_lan_ip($_SERVER['HTTP_X_FORWARDED']))
                        $getip= $_SERVER['HTTP_X_FORWARDED'];
                        else if(isset($_SERVER['HTTP_FORWARDED_FOR']) && xyz_em_check_lan_ip($_SERVER['HTTP_FORWARDED_FOR']))
                            $getip= $_SERVER['HTTP_FORWARDED_FOR'];
                            else if(isset($_SERVER['HTTP_FORWARDED']) && xyz_em_check_lan_ip($_SERVER['HTTP_FORWARDED']))
                                $getip= $_SERVER['HTTP_FORWARDED'];
                                else
                                    $getip= $_SERVER['REMOTE_ADDR'];
        }
        
        if(xyz_em_check_lan_ip(getenv('HTTP_CLIENT_IP')))
            $getip= getenv('HTTP_CLIENT_IP');
            else if(xyz_em_check_lan_ip(getenv('HTTP_X_FORWARDED_FOR')))
                $getip= getenv('HTTP_X_FORWARDED_FOR');
                else if(xyz_em_check_lan_ip(getenv('HTTP_X_FORWARDED')))
                    $getip= getenv('HTTP_X_FORWARDED');
                    else if(xyz_em_check_lan_ip(getenv('HTTP_FORWARDED_FOR')))
                        $getip= getenv('HTTP_FORWARDED_FOR');
                        else if(xyz_em_check_lan_ip(getenv('HTTP_FORWARDED')))
                            $getip= getenv('HTTP_FORWARDED');
                            else
                                $getip= getenv('REMOTE_ADDR');
                                
                                if($getip !="")
                                {
                                    $getip_array=explode(',',$getip);
                                    
                                    return $getip_array[count($getip_array) -1];
                                }
                                else
                                    return $getip;
    }
}
if(!function_exists('xyz_em_filter_nonce_life')){
    function xyz_em_filter_nonce_life(  ) {
        return (7*86400);
    }
}
if(!function_exists('xyz_em_links')){
function xyz_em_links($links, $file) {
	$base = plugin_basename(XYZ_EM_PLUGIN_FILE);
	if ($file == $base) {

		$links[] = '<a href="http://help.xyzscripts.com/docs/newsletter-manager/faq/"  title="FAQ">FAQ</a>';
		$links[] = '<a href="http://help.xyzscripts.com/docs/newsletter-manager/"  title="Read Me">README</a>';
		$links[] = '<a href="http://xyzscripts.com/donate/1" title="Donate">Donate</a>';
		$links[] = '<a href="http://xyzscripts.com/support/" class="xyz_support" title="Support"></a>';
		$links[] = '<a href="http://twitter.com/xyzscripts" class="xyz_twitt" title="Follow us on Twitter"></a>';
		$links[] = '<a href="https://www.facebook.com/xyzscripts" class="xyz_fbook" title="Like us on Facebook"></a>';
		$links[] = '<a href="http://www.linkedin.com/company/xyzscripts" class="xyz_linkedin" title="Follow us on LinkedIn"></a>';
	}
	return $links;
}
}
add_filter( 'plugin_row_meta','xyz_em_links',10,2);

?>
