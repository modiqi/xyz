<?php

namespace Api;



class Seo{
	
	public function save(\WP_REST_Request $request)
	{
		$seo_switch = $request->get_param('seo_switch');
		$seo_title = $request->get_param('seo_title');
		$seo_keywords = $request->get_param('seo_keywords');
		$seo_description = $request->get_param('seo_description');
		
		
		$xyz_seo = unserialize(get_option("xyz-seo-site",serialize([])));
		
		$xyz_seo['seo_switch'] = $seo_switch;
		$xyz_seo['seo_title']  = $seo_title;
		$xyz_seo['seo_keywords'] = $seo_keywords;
		$xyz_seo['seo_description'] = $seo_description;
		
		update_option('xyz-seo-site', serialize($xyz_seo), true);
		
		$return = [
			'code'  => 200,
			'msg'   => 'success',
			'data'  => []
		];
		
		return $return;
	}
	
}