<?php

namespace Api;

class Theme{
	
	/**
	 *  新增绑定主题
	 */
	public function save( \WP_REST_Request $request )
	{
		$domain = $request->get_param('domain');
		$theme  = $request->get_param('theme');
		
		$host = strtolower($_SERVER['HTTP_HOST']);
		
		if(empty($domain)){
			return ['code'=>203,'msg'=>'域名不能为空'];
		}
		
		if(empty($theme)){
			return ['code'=>203,'msg'=>'主题不能为空'];
		}
		
		$domain = str_replace(['http://','https://'],'',$domain);
		
		if(strtolower($domain) == $host){
			return ['code'=>203,'msg'=>'m端域名和pc域名不能一致'];
		}
		
		$res = array();
		$res['domain'] = strtolower($domain);
		$res['theme'] = $theme;
		
		
		update_option("xyz-theme", serialize($res));
		
		return ['code'=>200,'msg'=>'suceess'];
	}
	
	
	public function del()
	{
		delete_option("xyz-theme");
		
		return ['code'=>200,'msg'=>'suceess'];
	}
	
}
