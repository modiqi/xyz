<?php

namespace Api;


use Extra\ip\IpLocation;
use GuzzleHttp\Client;


class Article
{
	/**
	 * 第三方接口密钥
	 * @var string
	 */
	public $secret_key = "";
	
	public function __construct()
	{
		// 密钥验证
		exit();
	}
	
	/**
	 *  获取所有分类
	 */
	public function get_channel()
	{
		$args = array(
			'orderby' => 'name',
			'hide_empty' => false, //显示所有分类
			'order' => 'DESC'
		);
		
		$category = get_categories($args);
		
		$data = array();
		
		if(!empty($category)){
			foreach ($category as $item){
				$data[] = array('id'=>$item->term_id,'name'=>$item->name,'slug'=>$item->slug);
			}
		}
		
		return [ 'code'  => 200, 'msg'   => 'success', 'data'  => $data ];
	}
	
	/**
	 * 平台推送情况
	 */
	public function push_rest()
	{
		// baidu推送
		$baidu_pc_total = get_option('xyz_baidu_push_pc_total', 0);
		// bing推送
		$bing_push = unserialize(get_option('xyz_bing_push_rest',serialize([])));
		
		$bing_cp_total = 1000;
		if(!isset($bing_push['date']) && $bing_push['date'] == date('Y-m-d'))
		{
			$bing_cp_total = $bing_push['push_pc_total'];
		}
		
		return [
			'baidu_pc_total'=>$baidu_pc_total,
			'bing_pc_total'=> $bing_cp_total ,
			];
		
	}
	
	
	/**
	 * ai 生成文章接口
	 * @param \WP_REST_Request $request
	 * @return array
	 */
	public function openai(\WP_REST_Request $request)
	{
		// 栏目
		$channel_id = $request->get_param('channel_id');
		// 标题
		$title =  $request->get_param('title');
		// 内容
		$content = $request->get_param('content');
		// 缩略图
		$thumblink =  $request->get_param('thumblink');
		
		
		//新增内容
		$id = wp_insert_post(
			array(
				'ID'=>0,
				'post_author'=>1,
				'post_status'=> 'draft',//状态
				'post_date'=> date('Y-m-d H:i:s'),//时间
				'post_title'=> $title,//标题
				'post_content'=> $content,
				'post_category'=>[$channel_id]
			)
		);
		
		// 缩略图
		add_post_meta($id, 'thumblink_val', $thumblink, true);
		
		return [ 'code'  => 200, 'msg'   => 'success', 'data'  => $id ];
	}
	
	/**
	 * 获取友情链接
	 */
	public function get_link()
	{
		$bookmarks = get_bookmarks( array(
			'orderby'        => 'name',
			'order'          => 'ASC',
		));
		
		if (empty($bookmarks)) {
			return [ 'code'  => 200, 'msg'   => 'success', 'data'  => [] ];
		}
		
		$res = array();
		foreach ( $bookmarks as $k=>$bookmark )
		{
			$res[$k]['id'] = $bookmark->link_id;
			$res[$k]['link_url'] = $bookmark->link_url;
			$res[$k]['link_name'] = $bookmark->link_name;
		}
		
		return [ 'code'  => 200, 'msg'   => 'success', 'data'  => $res ];
	}
	
	/**
	 * 更新友情链接
	 */
	public function edit_link()
	{
	
	}
	
	/**
	 *  新增友情链接
	 */
	public function add_link(\WP_REST_Request $request)
	{
		$link_name = $request->get_param('link_name');
		$link_url  = $request->get_param('link_url');
		$link_type = $request->get_param('link_type');
		
		$bookmarks = get_bookmarks( array(
			'search' => $link_url
		));

		if ($bookmarks) {
			return [ 'code'  => 210, 'msg'   => '友链接已存在', 'data'  => [] ];
		}

		/**
		 *  查询分类，不存在，则创建分类
		 */
		$categories  = get_terms(
			array(
				'taxonomy'   => 'link_category',
				'orderby'    => 'name',
				'name'    => $link_type,
				'hide_empty' => 0,
			)
		);
		
		if(empty($categories))
		{
			$cat_id = wp_insert_term( $link_type, 'link_category' );
		}else{
			$cat_id = $categories[0]->term_id;
		}
		
		$args = array();
		$args['link_url']   = esc_url( esc_html( $link_url ) );
		$args['link_name']  = esc_html( $link_name );
		$args['link_category'] = $cat_id;
		
		
		require ABSPATH . 'wp-admin/includes/bookmark.php';
	
		$id = wp_insert_link($args);
		
		return [ 'code'  => 200, 'msg' => 'success', 'data'  => $id ];
	}
	
	/**
	 * 删除友情链接
	 */
	public function del_link(\WP_REST_Request $request)
	{
		$id = $request->get_param('id');
		
//		$bookmarks = get_bookmarks( array(
//			'search' => $link_name
//		));

		if (empty($id)) {
			return [ 'code'  => 210, 'msg'   => '友链接已存在', 'data'  => [] ];
		}
		
		require ABSPATH . 'wp-admin/includes/bookmark.php';
		
		wp_delete_link($id);
		
		return [ 'code'  => 200, 'msg'   => 'success', 'data'  => [] ];
	}
	

}