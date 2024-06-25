<?php

namespace App;


class Muen
{
	
	public function run()
	{
		
		add_action('admin_menu', function (){
			$path  = plugin_dir_url( __DIR__ );
			$custom_icon_url = $path.'static/images/menu-logo.png';
			add_menu_page('小宇宙','小宇宙','manage_options','wpxyz',function ()
			{
				include dirname(plugin_dir_path(__FILE__), 1).'/view/index.php';
			},$custom_icon_url,100);
			
			add_submenu_page('wpxyz','静态化生成','静态化','manage_options',
				'static-list', function ()
				{
					include dirname(plugin_dir_path(__FILE__), 1).'/view/static.php';
				},1);

			add_submenu_page('wpxyz','网站优化','网站优化','manage_options',
				'basic-list', function ()
				{
					include dirname(plugin_dir_path(__FILE__), 1).'/view/basic.php';
				},2);
			
			add_submenu_page('wpxyz','SEO优化','SEO优化','manage_options',
				'seo-list', function ()
				{
					include dirname(plugin_dir_path(__FILE__), 1).'/view/seo.php';
				},3);
				
			add_submenu_page('wpxyz','文章推送','文章推送','manage_options',
				'push-list', function ()
				{
					include dirname(plugin_dir_path(__FILE__), 1).'/view/push.php';
				},4);
				
			add_submenu_page('wpxyz','网站地图','网站地图','manage_options',
				'sitemap-list', function ()
				{
					include dirname(plugin_dir_path(__FILE__), 1).'/view/sitemap.php';
				},5);
			
			
			add_submenu_page('wpxyz','自动发布','自动发布','manage_options',
				'publish-list', function ()
				{
					include dirname(plugin_dir_path(__FILE__), 1).'/view/publish.php';
				},6);
				
			add_submenu_page('wpxyz','备案页面','备案页面','manage_options',
				'beian-list', function ()
				{
					include dirname(plugin_dir_path(__FILE__), 1).'/view/beian.php';
				},7);
				
			add_submenu_page('wpxyz','Robots生成','Robots生成','manage_options',
				'robots-list', function ()
				{
					include dirname(plugin_dir_path(__FILE__), 1).'/view/robots.php';
				},8);
				
			add_submenu_page('wpxyz','移动端设置','移动端设置','manage_options',
				'mobile-list', function ()
				{
					include dirname(plugin_dir_path(__FILE__), 1).'/view/mobile.php';
				},9);
				
				
			// add_submenu_page('wpxyz','(测)数据缓存','(测)数据缓存','manage_options',
			// 	'cache-list', function ()
			// 	{
			// 		include dirname(plugin_dir_path(__FILE__), 1).'/view/cache.php';
			// 	},999);
				
				
			// add_submenu_page('wpxyz','(测)蜘蛛分析','(测)蜘蛛分析','manage_options',
			// 	'spider-list', function ()
			// 	{
			// 		include dirname(plugin_dir_path(__FILE__), 1).'/view/spider.php';
			// 	},9999);
				
			// add_submenu_page('wpxyz','(测)邮箱配置','(测)邮箱配置','manage_options',
			// 	'smtp-list', function ()
			// 	{
			// 		include dirname(plugin_dir_path(__FILE__), 1).'/view/smtp.php';
			// 	},9999);

			// add_submenu_page('wpxyz','(测)GPT写作','(测)GPT写作','manage_options',
			// 	'gpt-list', function ()
			// 	{
			// 		include dirname(plugin_dir_path(__FILE__), 1).'/view/gpt.php';
			// 	},99999);

			// add_submenu_page('wpxyz','(测)违禁词屏蔽','(测)违禁词屏蔽','manage_options',
			// 	'ban-list', function ()
			// 	{
			// 		include dirname(plugin_dir_path(__FILE__), 1).'/view/ban.php';
			// 	},999998);

			// add_submenu_page('wpxyz','(测)关键词内链','(测)关键词内链','manage_options',
			// 	'keywords-list', function ()
			// 	{
			// 		include dirname(plugin_dir_path(__FILE__), 1).'/view/keywords.php';
			// 	},999999);

			// add_submenu_page('wpxyz','(测)图片本地化','(测)图片本地化','manage_options',
			// 	'images-list', function ()
			// 	{
			// 		include dirname(plugin_dir_path(__FILE__), 1).'/view/image.php';
			// 	},9999999);
				
			// add_submenu_page('wpxyz','主题推荐','<b style="color: #FF5722;">主题推荐</b>','manage_options',
			// 	'themes-list', function ()
			// 	{
			// 		include dirname(plugin_dir_path(__FILE__), 1).'/view/themes.php';
			// 	},99999999);
		});
		
		
		
		add_action( 'rest_api_init', function () {
			
			$files = glob(  dirname(plugin_dir_path(__FILE__), 1)   . "/api" . DIRECTORY_SEPARATOR . "*" );
			
			foreach ( $files as $file ) {
				
				$r = new \ReflectionClass('\Api\\'. basename( $file, '.php' ) );
				
				
				foreach ( $r->getMethods( \ReflectionMethod::IS_PUBLIC ) as $v ) {
					
					
					register_rest_route( 'xyz', strtolower( basename( $file, '.php' ) ) . "/" . $v->getName(), [
						
						'methods'   =>  in_array($v->getName(),['index','look','plan']) ? 'GET,POST' : 'POST',
						'callback'  =>  function ( $request ) use ( $v,$r )
						{
							return $v->invokeArgs( $r->newInstance(), [ $request ] );
						},
						
						'permission_callback' => function (\WP_REST_Request $request) use ($v) {
							
							if(in_array($v->class,['Api\Article','Api\Plan'])){
								return true;
							}
							
							if(in_array($v->getName(),['index','look','plan'])){
								return true;
							}
							
							if(get_current_user_id()<=0){
								return false;
							}
							
							
							return true;
							
						}
					
					]);
				}
			}
			
		} ,9999);
		
	}
	
}