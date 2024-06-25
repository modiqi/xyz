<?php

namespace Api;



class Beian extends Base{
	
	public function save(\WP_REST_Request $request)
	{
		$status     = $request->get_param('status');
		$beian_page  = $request->get_param('beian_page');
		$beian_hao  = $request->get_param('beian_hao');
		$beian_site_name  = $request->get_param('beian_site_name');
		
		update_option('xyz-beian', serialize([
			'status'=>$status,
			'beian_page'=>$beian_page,
			'beian_hao'=>$beian_hao,
			'beian_site_name'=>$beian_site_name,
		]), true);
		
		$return = [
			'code'  => 200,
			'msg'   => 'success',
			'data'  => ['status'=>$status]
		];
		
		return $return;
	}
	
}