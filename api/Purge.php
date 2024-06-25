<?php

namespace Api;

use App\Pluginpurge;

class Purge
{

	public function check()
	{
		$msg = '当前已是最新版本';
		
		try{
			
			$pluginpurge = (new Pluginpurge());
			
			$response = wp_safe_remote_get($pluginpurge->api_url, array('timeout' => 15));
			$body     = wp_remote_retrieve_body($response);
			
			$obj = json_decode($body);
			
			$plugin = xyz_plugin_desc();
			if ($obj && version_compare($obj->version, $plugin['plugin_version'], '>'))
			{
				$msg = '发现新版本：v'.$obj->version.'，是否更新？';
			}
			
		}catch (\Exception $e){
		
		}
		
		return ['code'=>200,'msg'=>'suceess','data'=>['msg'=>$msg]];
	}
	
	public function update()
	{
		$pluginpurge = (new Pluginpurge());
		
		$plugin = xyz_plugin_desc();
		
		$msg = '更新成功';
		try{
			
			$opt = $pluginpurge->purge($plugin['plugin_version']);
			switch ($opt){
				case 2:
					$msg = '插件目录没有权限更新';
					break;
				case 4:
					$msg = '当前已是最新版本';
					break;
				case 3:
					$msg = '更新失败';
					break;
			}
			
		}catch(\Exception $e){
		
		}
		
		return ['code'=>200,'msg'=>$msg];
	}
	
}