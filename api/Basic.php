<?php

namespace Api;



class Basic extends Base{
	
	public function save(\WP_REST_Request $request)
	{
		$status = $request->get_param('status');
		$name  = $request->get_param('name');
		
		$xyz_basic= (array) unserialize(get_option("xyz-basic"));
		
		$xyz_basic[$name] = $status;
		
		update_option('xyz-basic', serialize($xyz_basic), true);
		
		$return = [
			'code'  => 200,
			'msg'   => 'success',
			'data'  => ['status'=>$status,'name'=>$name]
		];
		
		return $return;
	}
	
}