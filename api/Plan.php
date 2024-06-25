<?php

namespace Api;


use Extra\ip\IpLocation;
use GuzzleHttp\Client;


class Plan
{
	/**
	 * 自动发布文章
	 */
	public function look()
	{
		$option = unserialize( get_option('xyz-publish',serialize([])));
		
		if(empty($option)){
			echo '自动发布未设置';
			return;
		}
		
		if( $option['switch'] != 'on'){
			echo '自动发布未开启';
			return;
		}
		
		if(!in_array($option['status'],['draft','pending'])){
			echo '自动发布状态未开启';
			return;
		}
		
		if(!in_array($option['sort'],['desc_sort','asc_sort','rand_sort'])){
			echo '发布文章排序未设置';
			return;
		}
		// 状态
		$post_status = $option['status'];
		// 排序
		$order = str_replace('_sort','',$option['sort']);
		
		//获取草稿箱文章
		$args = array(
			'numberposts' => 1,
			'post_status' => $post_status,
		);
		
		if(in_array($order,['desc','asc'])){
			$args['order'] = $order;
		}else{
			$args['orderby'] = $order;
		}


//		$num = $option['num'];
		
		$posts =  get_posts( $args );
		
		if(empty($posts)) {
			echo '没有数据';
			return;
		}
		
		wp_update_post([
			'ID'=> $posts[0]->ID,
			'post_status'=> 'publish',//状态
			'post_date'=> date('Y-m-d H:i:s'),//时间
		]);
		
		echo $posts[0]->ID.'-----'.$posts[0]->post_title.'----发布成功'.PHP_EOL;
		
	}
	
	
}