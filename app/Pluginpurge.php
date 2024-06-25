<?php
namespace App;
use WpOrg\Requests\Exception;

/**
 * 更新插件
 * Class Pluginpurge
 * @package App
 */
class Pluginpurge
{
	public $api_url = 'https://www.wp-xyz.com/xyz.json';
	public $path_temp = null;
	public function purge($version)
	{
		$response = wp_safe_remote_get($this->api_url, array('timeout' => 15));
		$body     = wp_remote_retrieve_body($response);
	    $obj = json_decode($body);
	    if ($obj && version_compare($obj->version, $version, '>'))
	    {
		    if(extension_loaded('Zend OPcache')){
			    ob_clean();
//			    opcache_reset();
			    ini_set("opcache.enable",false);
		    }
		    
		    $url = $obj->download;
		    $this->path_temp = plugin_dir_path(__DIR__).'tem.zip';
		    if( file_exists($this->path_temp) )
		    {
		    	$this->unzip();
		    	return 1;
		    }
		    try{
			    @file_put_contents($this->path_temp,file_get_contents($url));
			    $this->unzip();
		    }catch (Exception $e){
			    return 3;
		    }
	    }else{
	    	return 4;
	    }
	}
	
	public function unzip()
	{
		$zip = plugin_dir_path(__DIR__).'tem.zip';
		$destination_path = plugin_dir_path(__DIR__);
		require ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
		if ( unzip_file($zip, $destination_path) ) {
			@unlink($zip);
		}
	}
}