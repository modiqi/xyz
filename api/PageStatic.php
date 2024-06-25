<?php
namespace Api;

use WP_Error;
use WpOrg\Requests\Exception;

class PageStatic
{
	protected $nocache = '?nocache=9ccf46fc04a61bd6';
	protected $save_file_path = null;
	
	protected $domian = array();
	
	public function __construct()
	{
		$this->save_file_path = plugin_dir_path(__DIR__).'runtime';
		
		$this->domian['pc']   = get_option('home');
		
		$parse  = parse_url($this->domian['pc']);
		
		$option = unserialize(get_option("xyz-theme",serialize([])));
		if($option){
			$this->domian['m'] = $parse['scheme'].'://'.$option['domain'];
		}
		
	}
	
	public function save(\WP_REST_Request $request)
	{
		$status = $request->get_param('status');
		$name  = $request->get_param('name');
		
		$xyz_basic=  unserialize(get_option("xyz-page-static",serialize([])));
		
		$xyz_basic[$name] = $status;
		
		update_option('xyz-page-static', serialize($xyz_basic), true);
		
		$return = [
			'code'  => 200,
			'msg'   => '保存成功',
			'data'  => ['status'=>$status,'name'=>$name]
		];
		
		return $return;
	}
	
	/**
	 * 生成首页
	 * @param \WP_REST_Request $request
	 */
	public function home(\WP_REST_Request $request)
	{
		try{
		 
			foreach ($this->domian as $p=>$domain)
			{
				$body      = $this->rest_client($domain);
				$path_save = $this->save_file_path .'/'. $p;
				if(!is_dir($path_save)){
					@mkdir($path_save,0755,true);
					if(!is_dir($path_save)){ return [
						'code'  => 200, 'msg'   => '生成目录无权限',
					];}
				}
				
				if(empty($body))
					continue;
				
				@file_put_contents($path_save.'/index.html',$body);
			}
			$msg = '生成首页成功';
		}catch (\Exception $e) {
			$msg = '生成首页失败';
		}
		
		$return = [
			'code'  => 200,
			'msg'   => $msg,
		];
		
		return $return;
	}
	
	
	public function category()
	{
		// 列表页面链接
		$category = get_categories(['orderby' => 'name', 'hide_empty' => false, 'order' => 'DESC']);
		if(empty($category))
			return  [ 'code' => 200, 'msg' => '暂无分类类型'];
		
		foreach ($category as $item)
		{
			if(empty($item->slug)){
				continue;
			}
			
			foreach ($this->domian as $p=>$domain)
			{
				$url   = $domain.'/'.$item->slug;
				$body  = $this->rest_client($url);
				if(empty($body)){
					continue;
				}
				$path_save = $this->save_file_path.'/'.$p.'/'.$item->slug;
				if(!is_dir($path_save)) {
					@mkdir($path_save,0755,true);
					if(!is_dir($path_save)){ return [
						'code'  => 200, 'msg'   => '生成目录无权限',
					];}
				}
				@file_put_contents($path_save.'/index.html',$body);
			}
		}
		
		$return = [
			'code'  => 200,
			'msg'   => '生成分类静态页成功',
		];
		
		return $return;
	}
	
	
	public function category_art(\WP_REST_Request $request)
	{
		$term_id = $request->get_param('term_id');
		$total  =  $request->get_param('total');
		$page  =   $request->get_param('page');

		$size = 20;
		$offset = ( $page-1 ) * $size;
		
		$list = get_posts( [
			'numberposts' => $size,
			'offset'      => $offset,
			'category'    => $term_id
		] );

		if($total==0){ $total = 0;
			foreach ($term_id as $v){
				$total+= get_category($v)->count;
			}
		}
		foreach ($this->domian as $p=>$domain) {
			foreach ($list as $value) {
				$url = get_permalink($value);
				$parse = parse_url($url);
				$filename = basename($url);
				$url = $domain.$parse['path'];
				$path_save = str_replace([$filename, '//'], '', $this->save_file_path . '/'.$p . $parse['path']);
				if (!is_dir($path_save)) {
					mkdir($path_save, 0755, true);
				}
				$body = $this->rest_client($url);
				if (empty($body)) {
					continue;
				}
				@file_put_contents($path_save . $filename, $body);
			}
		}
		if( $size==count($list) ){
			$grean_total = $page * $size;
		}else{
			$grean_total = ($page-1) * $size + count($list);
		}
		
		$return = [
			'code'  => 200,
			'msg'   => '生成分类文章成功',
			'data' =>['page'=>$page+1,'total'=>$total,'grean_total'=>$grean_total]
		];
		
		return $return;
	}
	
	
	protected function rest_client($url)
	{
		try{
			$response  =  wp_remote_post($url.$this->nocache, array('timeout' => 10));
			$body      =  wp_remote_retrieve_body($response);
			if(empty($body)){
				$body = @file_get_contents($url.$this->nocache);
			}
			
			if(empty($body)){
				return '';
			}
			
			$msg       =  '<!--static created at '.date('Y-m-d H:i:s').' 感谢使用WordPress小宇宙插件-->';
			return $body.$msg;
		}catch (\WP_Error $e){
			return '';
		}catch (\Exception $e){
			return '';
		}
	}
	
}