<?php

namespace Api;

use App\BaiduSitemap;

class Sitemap
{
	
	/**
	 *  生成地图API
	 *   wp-json/xyz/sitemap/index
	 */
	public function index()
	{
		$sitemap = (array) unserialize(get_option( 'xyz-sitemap', [] ));
		
		BaiduSitemap::init($sitemap);
	}
	
	/**
	 * 保存
	 * @param \WP_REST_Request $request
	 * @return array
	 */
	public function save(\WP_REST_Request $request)
	{
		$xyz_sitemap = $request->get_param('xyz_sitemap',[]);
		
		$params = array();
		foreach ($xyz_sitemap as $item){
			$params[$item['name']] = $item['value'];
		}
		
		$msg = '保存成功';
		$code = 200;
		if(isset($params['num']) && $params['num']==''){
			$code = 401;
			$msg = '文章数量不能为空';
		}
		
		update_option('xyz-sitemap', serialize($params), true);
		
		
		$return = [
			'code'  => $code,
			'msg'   => $msg,
			'data'  => ''
		];
		
		return $return;
	}
	
	/**
	 * 生成sitemap
	 */
	public function create_map_xml()
	{
		(new BaiduSitemap)->init();
		
		$return = [
			'code'  => 200,
			'msg'   => 'SiteMap文件已生成！',
			'data'  => ''
		];
		
		return $return;
	}
	
	/**
	 * 生成sitemap
	 */
	public function create_map_txt()
	{
		(new BaiduSitemap)->init('txt');
		
		$return = [
			'code'  => 200,
			'msg'   => 'success',
			'data'  => ''
		];
		
		return $return;
	}
}