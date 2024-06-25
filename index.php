<?php
/**
 * Plugin Name: WordPress小宇宙
 * Plugin URI: https://www.wpxyz.net/
 * Description:WordPress小宇宙是一款专为站长们量身打造的网站性能优化、SEO优化插件，致力于成为一款建站必备WordPress优化插件！
 * Version: 1.3.5
 * Author: 小宇宙
 */
require_once __DIR__ . "/vendor/autoload.php";


class Init extends \App\Base
{
	public function __construct()
	{
		parent::__construct();
		
		$this->domin();
		
	}

	
	public function domin()
	{
		$domain = strtolower($_SERVER['HTTP_HOST']);
		
		$option = unserialize(get_option("xyz-theme",serialize([])));
		if(empty($option)){
			return false;
		}
		
		$res = array();
		if($domain == $option['domain']){
			$res = $option;
		}
		
		if(empty($res)){
			return;
		}
		
		$home = get_option("home");
		$h    = parse_url($home);
		$domain = $h['scheme'].'://'.$domain;
		
		add_filter('pre_option_stylesheet',function ()use ($res){
			return $res['theme'];
		});
		
		add_filter('pre_option_template',function () use ($res){
			return $res['theme'];
		});
		
		add_filter('pre_option_siteurl',function () use ($domain){
			return $domain;
		});
		
		add_filter('pre_option_home',function () use ($domain){
			return $domain;
		});
		
	}
}



$init = new Init();


