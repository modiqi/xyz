<?php

namespace Api;

class Publish{
	
	/**
	 *  自动发布
	 */
	public function save( \WP_REST_Request $request )
	{
		$switch = $request->get_param('switch');
		$status = $request->get_param('status');
		$num = $request->get_param('num',0);
		$sort  = $request->get_param('sort');
		
		$res = array();
		$res['switch'] = $switch;
		$res['status'] = $status;
		$res['num'] = $num;
		$res['sort'] = $sort;
		
		
		update_option("xyz-publish", serialize($res));
		
		return ['code'=>200,'msg'=>'suceess','data'=>get_current_user_id()];
	}
	

	
	
}
