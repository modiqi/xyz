<?php

namespace Api;


/**
 * 推送管理
 * Class Push
 * @package Api
 */
class Push
{
	/**
	 * 保存
	 */
	public function save(\WP_REST_Request $request)
	{
		$push_type = $request->get_param('push_type');
		
		$data = array();
		switch ($push_type)
		{
			case 'baidu_push':
				$token = $request->get_param('token');
				$baidu_switch = $request->get_param('baidu_switch');
				
				$data['token'] = $token;
				$data['baidu_switch'] = $baidu_switch?:'';
				
				break;
			case 'bing_push':
				$token = $request->get_param('token');
				$baidu_switch = $request->get_param('bing_switch');
				
				$data['token'] = $token;
				$data['bing_switch'] = $baidu_switch?:'';
				break;
				
			// 批量推送
			case 'batch_push':
				$site_type = $request->get_param('site_type');
				$urls = $request->get_param('urls');
				if(empty($urls)){
					return [ 'code'  => 201, 'msg'   => '推送urls不能为空', 'data'  => []];
				}
				
				$urls = explode("\r\n",$urls);
				
				if(count($urls)>1000){
					return [ 'code'  => 201, 'msg'   => '每次推送不能大于1000', 'data'  => []];
				}
				
				
				$arr = array_chunk($urls,200);
				foreach ($arr as $url)
				{
					$msg = (new \App\Push())->batch($url,$site_type);
				}
				
				return [ 'code'  => 200, 'msg'   => $msg];
				
				break;
				
			case 'sogou_push':
				
				$token = $request->get_param('token');
				$role_id = $request->get_param('role_id');
				$site_id = $request->get_param('site_id');
				$sogou_switch = $request->get_param('sogou_switch');
				
				$data['token'] = $token;
				$data['role_id'] = $role_id?:'';
				$data['site_id'] = $site_id?:'';
				$data['sogou_switch'] = $sogou_switch?:'';
				
				break;
			
			case 'sm_push':
				
				$token = $request->get_param('token');
				$m_token = $request->get_param('m_token');
				$user_name = $request->get_param('user_name');
				$sogou_switch = $request->get_param('sm_switch');
				
				$data['token'] = $token;
				$data['user_name'] = $user_name?:'';
				$data['sm_switch'] = $sogou_switch?:'';
				$data['m_token'] = $m_token?:'';
				
				break;
		}
		
		$xyz_token=  unserialize(get_option("xyz-push",serialize([])));
		
		$xyz_token[$push_type] = $data;
	
		update_option('xyz-push', serialize($xyz_token));
		
		return [ 'code'  => 200, 'msg'   => 'success', 'data'  => []];
	}
	
	
}