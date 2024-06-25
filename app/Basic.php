<?php

namespace App;


use WpOrg\Requests\Exception;

class Basic {
	protected $basicOptions = [];

	/**
	 * @param array $basicOptions
	 */
	public function __construct() {
		
		$this->basicOptions = (array) unserialize(get_option( 'xyz-basic', serialize([]) ));
		
	}

	function run()
	{
		foreach ( $this->basicOptions as $key => $value ) {
			
			if(empty($key) || $value=='false'){
				continue;
			}
			
			$value = "1";
			
			switch ( $key ) {

				/*
				 * 性能优化 开始
				 */

				//屏蔽古腾堡编辑器
				case "disable_gutenberg":
					if ( $value !== "1" ) {
						break;
					}
					
					add_filter( 'use_block_editor_for_post_type', '__return_false' );
					add_action( 'wp_enqueue_scripts', function () {
						wp_dequeue_style( 'wp-block-library' );
					}, 100 );
					remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );
					
					break;

				//移除头部工具栏
				case "disable_admin_bar":
					if ( $value !== "1" ) {
						break;
					}
					
					add_filter( 'show_admin_bar', '__return_false' );
					
					break;

				//屏蔽文章修订
				case "disable_post_revisions":
					if ( $value !== "1" ) {
						break;
					}
					
					if ( ! defined( 'WP_POST_REVISIONS' ) ) {
						define( 'WP_POST_REVISIONS', false );
					}
					
					if ( ! defined( 'AUTOSAVE_INTERVAL' ) ) {
						define( 'AUTOSAVE_INTERVAL', false );
					}
					
					break;

				//屏蔽Trackbacks
				case "disable_trackback":
					if ( $value !== "1" ) {
						break;
					}
					
					//彻底关闭 pingback
					add_filter( 'xmlrpc_methods', function ( $methods ) {
						$methods['pingback.ping']                    = '__return_false';
						$methods['pingback.extensions.getPingbacks'] = '__return_false';

						return $methods;
					} );
					//禁用 pingbacks, enclosures, trackbacks
					remove_action( 'do_pings', 'do_all_pings', 10 );
					//去掉 _encloseme 和 do_ping 操作。
					remove_action( 'publish_post', '_publish_post_hook', 5 );
					
					break;

				//屏蔽字符转码
				case "disable_wptexturize":
					if ( $value !== "1" ) {
						break;
					}
					
					add_filter( 'run_wptexturize', '__return_false' );
					
					break;

				//屏蔽站点Feed
				case "disable_feeds":
					if ( $value !== "1" ) {
						break;
					}
					
					add_action( 'do_feed', function () {
						wp_die( __( '<h1>本站不再提供 Feed，请访问网站<a href="' . get_bloginfo( 'url' ) . '">首页</a>！</h1>' ) );
					}, 1 );
					add_action( 'do_feed_rdf', function () {
						wp_die( __( '<h1>本站不再提供 Feed，请访问网站<a href="' . get_bloginfo( 'url' ) . '">首页</a>！</h1>' ) );
					}, 1 );
					add_action( 'do_feed_rss', function () {
						wp_die( __( '<h1>本站不再提供 Feed，请访问网站<a href="' . get_bloginfo( 'url' ) . '">首页</a>！</h1>' ) );
					}, 1 );
					add_action( 'do_feed_rss2', function () {
						wp_die( __( '<h1>本站不再提供 Feed，请访问网站<a href="' . get_bloginfo( 'url' ) . '">首页</a>！</h1>' ) );
					}, 1 );
					add_action( 'do_feed_atom', function () {
						wp_die( __( '<h1>本站不再提供 Feed，请访问网站<a href="' . get_bloginfo( 'url' ) . '">首页</a>！</h1>' ) );
					}, 1 );
					function itsme_disable_feed() {
						wp_die( __( 'No feed available, please visit the <a href="' . esc_url( home_url( '/' ) ) . '">homepage</a>!' ) );
					}
					add_action( 'do_feed', 'itsme_disable_feed', 1 );
					add_action( 'do_feed_rdf', 'itsme_disable_feed', 1 );
					add_action( 'do_feed_rss', 'itsme_disable_feed', 1 );
					add_action( 'do_feed_rss2', 'itsme_disable_feed', 1 );
					add_action( 'do_feed_atom', 'itsme_disable_feed', 1 );
					add_action( 'do_feed_rss2_comments', 'itsme_disable_feed', 1 );
					add_action( 'do_feed_atom_comments', 'itsme_disable_feed', 1 );
					remove_action( 'wp_head', 'feed_links_extra', 3 );
					remove_action( 'wp_head', 'feed_links', 2 );
					
					break;

				//屏蔽后台隐私
				case "disable_admin_privacy":
					if ( $value !== "1" ) {
						break;
					}
					
					add_action( 'admin_menu', function () {
						remove_submenu_page( 'options-general.php', 'options-privacy.php' );
						remove_submenu_page( 'tools.php', 'export-personal-data.php' );
						remove_submenu_page( 'tools.php', 'erase-personal-data.php' );
					}, 11 );
					add_action( 'admin_init', function () {
						remove_action( 'admin_init', [ 'WP_Privacy_Policy_Content', 'text_change_check' ], 100 );
						remove_action( 'edit_form_after_title', [ 'WP_Privacy_Policy_Content', 'notice' ] );
						remove_action( 'admin_init', [ 'WP_Privacy_Policy_Content', 'add_suggested_content' ], 1 );
						remove_action( 'post_updated', [ 'WP_Privacy_Policy_Content', '_policy_page_updated' ] );
						remove_filter( 'list_pages', '_wp_privacy_settings_filter_draft_page_titles', 10, 2 );
					}, 1 );
					
					break;

				//屏蔽Auto Embeds
				case "disable_admin_embeds":
					if ( $value !== "1" ) {
						break;
					}
					
					remove_filter( 'the_content', [ $GLOBALS['wp_embed'], 'autoembed' ], 8 );
					remove_filter( 'widget_text_content', [ $GLOBALS['wp_embed'], 'autoembed' ], 8 );
					remove_filter( 'widget_block_content', [ $GLOBALS['wp_embed'], 'autoembed' ], 8 );
					
					break;

				//屏蔽XML-RPC
				case "disable_xml_rpc":
					if ( $value !== "1" ) {
						break;
					}
					
					add_filter( 'xmlrpc_enabled', '__return_false' );
					add_filter( 'xmlrpc_methods', '__return_empty_array' );
					
					break;
					
				//禁用谷歌字体
				case "disable_google_font":
					if ( $value !== "1" ) {
						break;
					}
					
					add_action( 'init', function () {
						wp_deregister_style( 'open-sans' );
						wp_register_style( 'open-sans', false );
						wp_enqueue_style( 'open-sans', '' );
				
					} );
					
					break;
				
				//gravatar头像加速
				case "gravatar_speed":
				
					if ( $value === "0" || $value === "" ) {
						break;
					}
					
					add_filter('get_avatar', function ($avatar){
						$avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="//gravatar.loli.net/avatar/$1?s=$2" class="avatar avatar-$2" height="50" width="50">',$avatar);
						return $avatar;
					});

					break;

				/*
				 * 性能优化 结束
				 * 头部优化 开始
				 */
				
				//屏蔽默认的 max-image-preview:large 指令
				case "disable_head_max_image_preview":
					if ( $value !== "1" ) {
						break;
					}
					
					remove_filter( 'wp_robots', 'wp_robots_max_image_preview_large' );
					
					break;
				
				//屏蔽Emoji图片
				case "disable_head_emoji":
					if ( $value !== "1" ) {
						break;
					}
					
					remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
					remove_action( 'admin_print_styles', 'print_emoji_styles' );
					remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
					remove_action( 'wp_print_styles', 'print_emoji_styles' );
					remove_action( 'embed_head', 'print_emoji_detection_script' );
					remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
					remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
					remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
					add_filter( 'emoji_svg_url', '__return_false' );
					
					break;

				//屏蔽5.9版本多余CSS
				case "disable_head_v59_css":
					if ( $value !== "1" ) {
						break;
					}
					
					add_action( 'wp_enqueue_scripts', function () {
						wp_dequeue_style( 'wp-block-library' );
						wp_dequeue_style( 'wp-block-library-theme' );
						wp_dequeue_style( 'wc-block-style' ); # 移除WOO插件区块样式
						wp_dequeue_style( 'global-styles' ); # 移除 THEME.JSON
					}, 100 );
					
					break;

				//移除头部版本号
				case "disable_head_version":
					if ( $value !== "1" ) {
						break;
					}
					
					remove_action( 'wp_head', 'wp_generator' );
					add_filter( 'style_loader_src', [ $this, 'xyz_disable_cssjs_v' ], 999 );
					add_filter( 'script_loader_src', [ $this, 'xyz_disable_cssjs_v' ], 999 );
					
					break;

				//禁用dns-prefetch标签
				case "disable_head_dnsPrefetch":
					if ( $value !== "1" ) {
						break;
					}
					
					remove_action( 'wp_head', 'wp_resource_hints', 2 );
					
					break;

				//移除头部application/json+oembed和text/xml+oembe
				case "disable_head_json":
					if ( $value !== "1" ) {
						break;
					}
					
					add_action( 'init', function(){
						// 移除 application/json+oembed 嵌入支持
						remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
						// 移除 application/json+oembed 提供者端点
						remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
						remove_action( 'wp_head', 'wp_oembed_add_host_js' );
						// 移除 REST API 中的 oEmbed 路由
						remove_action( 'rest_api_init', 'wp_oembed_register_route' );
						// 移除 oEmbed 格式
						
					} );
					
					break;

				//禁用头部rsd+xml+wlwmanifest标签
				case "disable_head_rsd_wlwmanifest":
					if ( $value !== "1" ) {
						break;
					}
					
					remove_action( 'wp_head', 'rsd_link' );
					remove_action( 'wp_head', 'wlwmanifest_link' );
					
					break;
					
				//屏蔽头部classic-theme-styles-inline-css样式
				case "disable_classic_theme_styles":
					if ( $value !== "1" ) {
						break;
					}
					
					add_action( 'wp_enqueue_scripts', function(){
						wp_dequeue_style( 'classic-theme-styles' );
					}, 20 );
					
					break;
					
				/*
				 * 头部优化 结束
				 * SEO优化 开始
				 */


				//去掉头部shortlink短连接
				case "disable_head_shortlink":
					if ( $value !== "1" ) {
						break;
					}

					remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );
					remove_action('template_redirect', 'wp_shortlink_header',11,0);

					break;
					
				//精简分类URL，去掉分类url中的一级分类
				case "disable_cat_category":
					if ( $value !== "1" ) {
						break;
					}

					add_filter('request', function($query_vars) {
						if(!isset($_GET['page_id']) && !isset($_GET['pagename']) && !empty($query_vars['pagename'])){
							$pagename	= $query_vars['pagename'];
							$categories	= get_categories(['hide_empty'=>false]);
							$categories	= wp_list_pluck($categories, 'slug');
							if(in_array($pagename, $categories)){
								$query_vars['category_name']	= $query_vars['pagename'];
								unset($query_vars['pagename']);
							}
						}
						return $query_vars;
					});
					add_filter('pre_term_link', function($term_link, $term){
						if($term->taxonomy == 'category'){
							return '%category%';
						}
						return $term_link;
					}, 10, 2);

					break;
					
				//精简分类URL，去掉分类url中的一级分类
				case "disable_cat_url":
					if ( $value !== "1" ) {
						break;
					}
					add_filter( 'category_link', function ( $catlink, $category_id ) {
						$cate = get_category( $category_id );

						return esc_url( home_url( '/' ) ) . $cate->slug . "/";
					}, 10, 2 );
					break;
				
				//精简文章URL，去掉分类url中的一级分类
				case "disable_post_url":
					if ( $value !== "1" ) {
						break;
					}
					add_filter( 'post_link', function ( $permalink, $post, $leavename ) {
						$category = get_the_category( $post->ID )[0] ?? null;
						if ( ! $category ) {
							return esc_url( home_url( '/' ) ) . $post->ID . "/";
						}

						return esc_url( home_url( '/' ) ) . $category->slug . "/" . $post->ID . ".html";
					}, 10, 3 );
					break;
					
				//禁用自带wp-sitemap功能
				case "disable_wp_sitemaps":
					if ( $value !== "1" ) {
						break;
					}
					add_filter( 'wp_sitemaps_enabled', '__return_false' );
					break;

				//禁用wp-robots功能
				case "disable_wp_robots":
					if ( $value !== "1" ) {
						break;
					}
					remove_filter( 'wp_robots', 'wp_robots_max_image_preview_large' );
					break;

				//tag标签url改id展示
				case "tag_rewrite_rules_id":
					if ( $value !== "1" ) {
						break;
					}
					add_action( 'generate_rewrite_rules', function ( $wp_rewrite ) {
						$new_rules         = array(
							'tag/(\d+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?tag_id=$matches[1]&feed=$matches[2]',
							'tag/(\d+)/(feed|rdf|rss|rss2|atom)/?$'      => 'index.php?tag_id=$matches[1]&feed=$matches[2]',
							'tag/(\d+)/embed/?$'                         => 'index.php?tag_id=$matches[1]&embed=true',
							'tag/(\d+)/page/(\d+)/?$'                    => 'index.php?tag_id=$matches[1]&paged=$matches[2]',
							'tag/(\d+)/?$'                               => 'index.php?tag_id=$matches[1]',
						);
						$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
					} );
					add_filter( 'term_link', function ( $link, $term, $taxonomy ) {
						if ( $taxonomy == 'post_tag' ) {
							return home_url( '/tag/' . $term->term_id . '/' );
						}

						return $link;
					}, 10, 3 );
					add_action( 'query_vars', function ( $public_query_vars ) {
						$public_query_vars[] = 'tag_id';

						return $public_query_vars;
					} );
					break;
				
				//tag跳转优化
				case "tag_redirect_post":
					if ( $value !== "1" ) {
						break;
					}
					add_action( 'template_redirect', function () {
						if ( is_tag() ) {
							global $wp_query;
							if ( $wp_query->post_count == 1 ) {
								wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
							}
						}
					} );
					break;
				
				//文章TAG自动内链已有的TAG标签
				case "wpxyz_tag_add_link":
					if ( $value !== "1" ) {
						break;
					}
					add_filter('the_content',function($content){
						$match_num_from = 1;  //一个标签少于几次不链接
						$match_num_to = 1;  //一个标签最多链接几次
						$posttags = get_the_tags();
						if ($posttags) {
							usort($posttags, function($a, $b){
								if ( $a->name == $b->name ) return 0;
								return ( strlen($a->name) > strlen($b->name) ) ? -1 : 1;
							});
							foreach($posttags as $tag) {
								$link = get_tag_link($tag->term_id);
								$keyword = $tag->name;
								//链接代码
								$cleankeyword = stripslashes($keyword);
								$url = "<a href=\"$link\" ";
								$url .= ' target="_blank"';
								$url .= ">".addcslashes($cleankeyword, '$')."</a>";
								$limit = rand($match_num_from,$match_num_to);
								//不链接代码
								$content = preg_replace( '|(<a[^>]+>)(.*)<pre.*?>('.$ex_word.')(.*)<\/pre>(</a[^>]*>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
								$content = preg_replace( '|(<img)(.*?)('.$ex_word.')(.*?)(>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
								$cleankeyword = preg_quote($cleankeyword,'\'');
								$regEx = '\'(?!((<.*?)|(<a.*?)))('. $cleankeyword . ')(?!(([^<>]*?)>)|([^>]*?</a>))\'s' . $case;
								$content = preg_replace($regEx,$url,$content,$limit);
								$content = str_replace( '%&&&&&%', stripslashes($ex_word), $content);
							}
						}
						return $content;
					},1);
				break;

				//文章外链自动添加nofollow
				case "single_link_add_nofollow":
					if ( $value !== "1" ) {
						break;
					}
					add_filter( 'the_content', function ( $content ) {
						preg_match_all( '/href="(.*?)"/', $content, $matches );
						if ( $matches ) {
							foreach ( $matches[1] as $val ) {
								if ( strpos( $val, home_url() ) === false ) {
									$content = str_replace( "href=\"$val\"", "href=\"$val\" rel=\"external nofollow\" ",
										$content );
								}
							}
						}

						return $content;
					}, 999 );
					break;


				//搜索结果优化
				case "search_redirect_post":
					if ( $value !== "1" ) {
						break;
					}
					add_action( 'template_redirect', function () {
						if ( is_search() ) {
							global $wp_query;
							if ( $wp_query->post_count == 1 && $wp_query->max_num_pages == 1 ) {
								wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
								exit;
							}
						}
					} );
					break;

				//去掉分类url中的一级分类
				case "disable_cats_url":
					if ( $value !== "1" ) {
						break;
					}
					
					// 分类url处理
					add_filter( 'category_link', function ( $catlink, $category_id ) {
						$cate = get_category( $category_id );

						return esc_url( home_url( '/' ) ) . $cate->slug . "/";
					}, 10, 2 );
					
					// 文章url处理
					add_filter( 'post_link', function ( $permalink, $post, $leavename ) {
						$category = get_the_category( $post->ID )[0] ?? null;
						if ( ! $category ) {
							return esc_url( home_url( '/' ) ) . $post->ID . ".html";
						}
						
						return esc_url( home_url( '/' ) ) . $category->slug . "/" . $post->ID . ".html";
					}, 10, 3 );
					
					break;

					
				/*
				 * SEO优化 结束
				 * 附件优化 开始
				 */

				//上传文件重命名
				case "upload_filter_rename":
					if ( $value !== "1" ) {
						break;
					}
					add_filter( 'wp_handle_upload_prefilter', function ( $file ) {
						$time         = date( "YmdHis" );
						$file['name'] = $time . "" . mt_rand( 1, 100 ) . "." . pathinfo( $file['name'],
								PATHINFO_EXTENSION );

						return $file;
					} );
					break;

				//上传图片增加时间戳
				case "upload_prefilter_add_time":
					if ( $value !== "1" ) {
						break;
					}
					add_filter( 'wp_handle_upload_prefilter', function ( $file ) {
						$file['name'] = time()  . $file['name'];

						return $file;
					} );
					break;

				//图片添加alt和title
				case "image_add_alt_title":
					if ( $value !== "1" ) {
						break;
					}
					add_filter( 'the_content', function ( $content ) {
						global $post;
						preg_match_all( '/<img (.*?)\/>/', $content, $images );
						if ( ! is_null( $images ) ) {
							foreach ( $images[1] as $index => $value ) {
								$new_img = str_replace( '<img',
									'<img alt="' . get_the_title() . '" title="' . get_the_title() . '" ',
									$images[0][ $index ] );
								$content = str_replace( $images[0][ $index ], $new_img, $content );
							}
						}

						return $content;
					}, 99999 );
					break;

				//删除文章同时删除图片附件
				case "disable_post_and_filter":
					if ( $value !== "1" ) {
						break;
					}
					add_action( 'before_delete_post', function ( $post_ID ) {
						global $wpdb;
						#删除特色图片
						$thumbnails = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID" );
						foreach ( $thumbnails as $thumbnail ) {
							wp_delete_attachment( $thumbnail->meta_value, true );
						}
						#删除图片附件
						$attachments = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_parent = $post_ID AND post_type = 'attachment'" );
						foreach ( $attachments as $attachment ) {
							wp_delete_attachment( $attachment->ID, true );
						}
						$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID" );
					} );
					break;

				//禁用自动生成的图片附件
				case "disable_add_thumbnail":
					if ( $value !== "1" ) {
						break;
					}
					add_action( 'intermediate_image_sizes_advanced', function ( $sizes ) {
						unset( $sizes['thumbnail'] );    # disable thumbnail size
						unset( $sizes['medium'] );       # disable medium size
						unset( $sizes['large'] );        # disable large size
						unset( $sizes['medium_large'] ); # disable medium-large size
						unset( $sizes['1536x1536'] );    # disable 2x medium-large size
						unset( $sizes['2048x2048'] );    # disable 2x large size

						return $sizes;
					} );
					# 禁用缩放尺寸
					add_filter( 'big_image_size_threshold', '__return_false' );
					# 禁用其他图片尺寸
					add_action( 'init', function () {
						remove_image_size( 'post-thumbnail' ); # disable images added via set_post_thumbnail_size()
						remove_image_size( 'another-size' );   # disable any other added image sizes
					} );
					break;

				/*
				 * 附件优化 结束
				 * 其他优化 开始
				 */

				//浏览量设置
				case "disable_auto_view":
					if ( $value !== "1" ) {
						break;
					}
					
					//后台文章列表添加浏览量、添加数据、设置为可排序
					add_filter('manage_posts_columns' , function($columns){
						$columns['views'] = '浏览';
						return $columns;
					});
					add_action('manage_posts_custom_column', function($column_name, $post_id){
						$views	= wpxyz_post_views($post_id) ?: 0;
						if($column_name == 'views'){
							$views = '<a class="update_views">'.$views.'</a>';
							echo $views;
						}
					}, 10, 2);
					//添加排序按钮
					add_filter('manage_edit-post_sortable_columns', function($columns){
					    $columns['views'] = 'views';
					    return $columns;
					});
					//设置排序
					add_action('pre_get_posts', function($query) {
						$orderby = $query->get('orderby');
						if('views' == $orderby) {
							$query->set('meta_key', 'views');
							$query->set('orderby', 'meta_value_num');
						}
					});
					
					break;
					
				//禁止自动更新
				case "disable_auto_udates":
					if ( $value !== "1" ) {
						break;
					}
					// 关闭核心提示
//					add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );
//					// 关闭插件提示
//					add_filter( 'pre_site_transient_update_themes', create_function( '$a', "return null;" ) );
					// 关闭主题提示
					remove_action( 'admin_init', '_maybe_update_core' );
					// 禁止 WordPress 检查更新
					remove_action( 'admin_init', '_maybe_update_plugins' );
					// 禁止 WordPress 更新插件
					remove_action( 'admin_init', '_maybe_update_themes' );
					// 禁止 WordPress 更新主题
					break;
				
				//屏蔽自动更新
				case "disable_mail_verification":
					if ( $value !== "1" ) {
						break;
					}
					add_filter( 'admin_email_check_interval', '__return_false' );
					break;

				//屏蔽后台登录语言选择
				case "disable_login_lang":
					if ( $value !== "1" ) {
						break;
					}
					add_filter( 'login_display_language_dropdown', '__return_false' );
					break;

				//开启友情链接
				case "open_admin_links":
					if ( $value !== "1" ) {
						break;
					}
					add_filter( 'pre_option_link_manager_enabled', '__return_true' );
					break;

				//开启小工具
				case "open_admin_sidebar":
					if ( $value !== "1" ) {
						break;
					}
					
					register_sidebar(array(
						'id'=>'sidebar-1'
					));
					
					break;

			}

		}

	}

	//功能优化封装方法
	function xyz_disable_cssjs_v( $src ) {
		if ( strpos( $src, 'ver=' ) ) {
			$src = remove_query_arg( 'ver', $src );
		}

		return $src;
	}

	//去除菜单多余类名
	function xyz_disable_navbar_class( $var ) {
		return is_array( $var ) ? array_intersect( $var,
			array(
				'current-menu-item',
				'current-post-ancestor',
				'current-menu-ancestor',
				'current-menu-parent'
			) ) : '';

	}
	
}