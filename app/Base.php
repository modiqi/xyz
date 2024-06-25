<?php
namespace App;

class Base
{
	
	public function __construct()
	{
		// 菜单
		(new Muen())->run();
		
		// 网站优化
		(new Basic())->run();
		
		// 后台执行钩子
		$this->wp_xyz_hook();
	}
	
	/**
	 * 插件所有钩子执行
	 */
	public function wp_xyz_hook()
	{
		/**
		 *  缓存模板页面
		 */
		$path  = dirname(__DIR__,1);
		add_filter( 'template_include', function ($template) use($path)
		{
			if(is_home() && $_SERVER['REQUEST_URI']=='/') {
				$xyz_beian = unserialize(get_option('xyz-beian', serialize([])));
				if (isset($xyz_beian['status']) && $xyz_beian['status'] == 'on') {
					$referer = $_SERVER['HTTP_REFERER'] ?? '';
					if(empty($referer) && !xyz_is_agent() ){
						$file_path = $path . '/' . $xyz_beian['beian_page'];
						if (file_exists($file_path)) {
							return $file_path;
						}
					}
				}
			}
			
			$xyz_basic=  unserialize(get_option("xyz-page-static",serialize([])));
			if(isset($xyz_basic['xyz-open-static']) && $xyz_basic['xyz-open-static']=='false'){
				return $template;
			}
			
			$stics = $_GET['nocache'] ?? '';
			if( $stics == '9ccf46fc04a61bd6' )
				return $template;
			
			$parse = parse_url(get_option('home'));
			$option = unserialize(get_option("xyz-theme",serialize([])));
			if(is_home() && $_SERVER['REQUEST_URI']=='/'){
				
				$file_path = '';
				if( isset($parse['host']) && $_SERVER["SERVER_NAME"]== $parse['host']){
					$file_path = $path.'/runtime/pc/index.html';
				}elseif (isset($option['domain']) && $option['domain']==$_SERVER["SERVER_NAME"]){
					$file_path = $path.'/runtime/m/index.html';
				}
				if(empty($file_path)){
					return $template;
				}
				if(file_exists($file_path))
					return $file_path;
			}
			
			if(is_category()){
				$file_path = '';
				if( isset($parse['host']) && $_SERVER["SERVER_NAME"]== $parse['host']){
					$file_path = $path.'/runtime/pc/'.$_SERVER['REQUEST_URI'].'/index.html';
				}elseif (isset($option['domain']) && $option['domain']==$_SERVER["SERVER_NAME"]){
					$file_path = $path.'/runtime/m/'.$_SERVER['REQUEST_URI'].'/index.html';
				}
				if(empty($file_path)){
					return $template;
				}
				if(file_exists($file_path))
					return $file_path;
			}
			
			if(is_single()){
				$file_path = '';
				if( isset($parse['host']) && $_SERVER["SERVER_NAME"]== $parse['host']){
					$file_path = $path.'/runtime/pc/'.$_SERVER['REQUEST_URI'];
				}elseif (isset($option['domain']) && $option['domain']==$_SERVER["SERVER_NAME"]){
					$file_path = $path.'/runtime/m/'.$_SERVER['REQUEST_URI'];
				}
				if(empty($file_path)){
					return $template;
				}
				if(file_exists($file_path))
					return $file_path;
			}
			return $template;
		});
		
		/**
		 * 在后台分类目录/标签列表,添加ID显示
		 */
		add_filter('tag_row_actions',function($actions=[],$tag=null) {
			$actions['tag_id'] = "ID：".$tag->term_id;
			return $actions;
		},10,3);
		
		/**
		 * 判断是否使用插件自带首页自动TDK
		 */
		$xyz_seo =  unserialize(get_option("xyz-seo-site",serialize([])));
		if($xyz_seo && $xyz_seo['seo_switch'] =='on')
		{
			add_action( 'wp_head', function () use ($xyz_seo) {
				echo '<title>'.$xyz_seo['seo_title'].'</title>'."\n";
				echo '<meta name="keywords" content="'.$xyz_seo['seo_keywords'].'"/>'."\n";
				echo '<meta name="description" content="'.$xyz_seo['seo_description'].'"/>'."\n";
			},1);
			
		}
		
		/**
		 * 在后台文章列表添加文章推送时间列
		 */
		add_filter('manage_posts_columns' , function ($columns){
			$columns['push_time'] = '推送时间';
			return $columns;
		});
		
		
		/**
		 * 在后台文章列表为文章推送时间列填充数据
		 */
		add_action('manage_posts_custom_column', function ($column_name, $post_id)
		{
			if($column_name == 'push_time')
			{
				$time = get_post_meta($post_id, 'push_time', true);
				
				if (empty($time))
					echo  '';
				else
					echo $time;
			}
			
		}, 10, 2);
		
		/**
		 * 在后台文章列表,标题下方添加推送到百度选项
		 */
		add_filter( 'post_row_actions', function ( $actions, $post )
		{
			$url = urlencode( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
			
			$actions['baidu_push'] = "<a href='/wp-admin/admin-ajax.php?action=xyz_baidu_push_by_href&id=" . $post->ID . "&redirect=" . $url . "'>推送到百度</a>";
			$actions['bing_push'] = "<a href='/wp-admin/admin-ajax.php?action=xyz_bing_push_by_href&id=" . $post->ID . "&redirect=" . $url . "'>推送到必应</a>";
			$actions['sm_push'] = "<a href='/wp-admin/admin-ajax.php?action=xyz_sm_push_by_href&id=" . $post->ID . "&redirect=" . $url . "'>推送到神马</a>";
			
			
			return $actions;
			
		}, 10, 2 );
		
		/**
		 * 文章列表百度推送
		 */
		add_action( 'wp_ajax_xyz_baidu_push_by_href', function ()
		{
			$post_id = (int)$_GET["id"];
			if( $post_id )
				push_post_url($post_id,'baidu_by_push');
			header("Location:" . $_GET["redirect"]);
			exit();
		});
		
		/**
		 * 文章列表必应推送
		 */
		add_action( 'wp_ajax_xyz_bing_push_by_href', function ()
		{
			$post_id = (int)$_GET["id"];
			if( $post_id )
				push_post_url($post_id,'bing_by_push');
			header("Location:" . $_GET["redirect"]);
			exit();
		});
		
		/**
		 * 文章列表神马推送
		 */
		add_action( 'wp_ajax_xyz_sm_push_by_href', function ()
		{
			$post_id = (int)$_GET["id"];
			if( $post_id )
				push_post_url($post_id,'sm_by_push');
			header("Location:" . $_GET["redirect"]);
			exit();
		});
		/**
		 * 回收站
		 */
		add_action('wp_trash_post',function($post_id){
			wp_del_page_static($post_id);
		});
		/**
		 * 推送 publish_post
		 *
		 */
		add_action('post_updated',function ($post_id, $post_after, $post_before)
		{
			if($post_after->post_status == 'publish'){
				wp_page_static($post_id);
			}
			
			if($post_after->post_status != 'publish')
				return;
			if($post_after->post_status == $post_before->post_status)
				return;
			push_post_url($post_id,'publish_type');
			
		},10,3);
		
		/**
		 * WordPress小宇宙插件
		 */
		add_filter( 'admin_footer_text', function (){
			return '欢迎使用WordPress小宇宙插件！';
		}, 9999 );
	}
	
}