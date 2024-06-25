<?php
	xyz_load_scripts();
	global $wpdb;
	#WordPress获取24H发布文章总数
	function xyz_posts_count_24h( $post_type = 'post' ) {
		global $wpdb;
		$numposts = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(ID) " .
				"FROM {$wpdb->posts} " .
				"WHERE " .
				"post_status='publish' " .
				"AND post_type= %s " .
				"AND post_date> %s",
				$post_type, date( 'Y-m-d H:i:s', strtotime( '-24 hours' ) )
			)
		);
		return $numposts;
	}
	
	//插件信息
	$xyz_plugin_desc = xyz_plugin_desc();
	$plugin_description = str_replace( '<cite>作者 小宇宙。</cite>', '', $xyz_plugin_desc['plugin_description']);
	
	// 百度推送
    $baidu_pc_total = get_option('xyz_baidu_push_pc_total', 0);
    $baidu_m_total  = get_option('xyz_baidu_push_m_total', 0);
    // 必应推送
    $bing_push = unserialize(get_option('xyz_bing_push_rest',serialize([])));
    // 神马推送
    $sm_push   = unserialize(get_option('xyz_sm_push_rest',serialize([])));
    
    try {
        $api = 'https://www.wpxyz.net/xyz-admin.json';
        $response = wp_remote_get($api);
        $body     = wp_remote_retrieve_body( $response );
        $xyz_list = json_decode( $body, true );
        if(!isset($xyz_list['promotion'])){
	        $xyz_list = array('promotion'=>[],'post'=>[],'sponsor'=>[]);
        }
    } catch (\Exception $e) {
	    $xyz_list = array('promotion'=>[],'post'=>[],'sponsor'=>[]);
    }
   
    //请求推广支持Json
    $xyz_help_list = $xyz_list['promotion']??[];
	//请求插件动态
    $xyz_post_list = $xyz_list['post']??[];
	//请求赞助大使
    $xyz_sponsor_list = $xyz_list['sponsor']??[];
    
?>
<div class="xyz-body xyz-index"> 
	<div class="index-quota layui-row layui-col-space20">
		<div class="layui-col-md2">
			<div class="quota-item b-r-4">
				<i class="quota-icon baidu"></i>
				<div class="item-box">
					<span><?php echo $baidu_pc_total; ?></span>
					<small>百度推送配额</small>
				</div>
			</div>
		</div>
		<div class="layui-col-md2">
			<div class="quota-item b-r-4">
				<i class="quota-icon bing"></i>
				<div class="item-box">
					<span><?php if(isset($bing_push['push_pc_total'])){ echo 1000 - $bing_push['push_pc_total'];}else{ echo 1000; } ?></span>
					<small>必应推送配额</small>
				</div>
			</div>
		</div>
		<div class="layui-col-md2">
			<div class="quota-item b-r-4">
				<i class="quota-icon sm"></i>
				<div class="item-box">
		            <span><?php if(isset($sm_push['push_pc_total'])){ echo 1000 - $sm_push['push_pc_total'];}else{ echo 1000; } ?></span>
		            <small>神马推送配额</small>
				</div>
			</div>
		</div>
		<div class="layui-col-md2">
			<div class="quota-item b-r-4">
				<i class="quota-icon sogou"></i>
				<div class="item-box">
					<span><?php echo 0;?></span>
					<small>搜狗推送配额</small>
				</div>
			</div>
		</div>
		<div class="layui-col-md2">
			<div class="quota-item b-r-4">
				<i class="quota-icon soso"></i>
				<div class="item-box">
					<span><?php echo  0; ?></span>
					<small>360推送配额</small>
				</div>
			</div>
		</div>
		<div class="layui-col-md2">
			<div class="quota-item b-r-4">
				<i class="quota-icon toutiao"></i>
				<div class="item-box">
					<span>0</span>
					<small>头条推送配额</small>
				</div>
			</div>
		</div>
	</div>
	<div class="layui-row layui-col-space20">
		<div class="layui-col-md6">
			<div class="bg-fff b-a p-a-20 b-r-4">
				<div class="panel-title b-b p-b-20 m-b-20">网站信息</div>
				<div class="site-count layui-row layui-col-space10">
					<div class="layui-col-md2">
						<div class="count-item p-a-15 b-r-4 bg-dg">
							<b><?php echo wp_count_posts()->publish; ?></b>
							<small class="m-t-5">已发布文章总数</small>
						</div>
					</div>
					<div class="layui-col-md2">
						<div class="count-item p-a-15 b-r-4 bg-sc">
							<b><?php echo xyz_posts_count_24h(); ?></b>
							<small class="m-t-5">24H发布文章总数</small>
						</div>
					</div>
					<div class="layui-col-md2">
						<div class="count-item p-a-15 b-r-4 bg-wn">
							<b><?php echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments"); ?></b>
							<small class="m-t-5">评论总数</small>
						</div>
					</div>
					<div class="layui-col-md2">
						<div class="count-item p-a-15 b-r-4">
							<b><?php echo $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users"); ?></b>
							<small class="m-t-5">用户总数</small>
						</div>
					</div>
					<div class="layui-col-md2">
						<div class="count-item p-a-15 b-r-4 bg-dg"">
							<b><?php echo wp_count_terms('post_tag'); ?></b>
							<small class="m-t-5">TAG总数</small>
						</div>
					</div>
					<div class="layui-col-md2">
						<div class="count-item p-a-15 b-r-4 bg-sc">
							<b><?php echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->links WHERE link_visible = 'Y'"); ?></b>
							<small class="m-t-5">友链总数</small>
						</div>
					</div>
				</div>
			</div>
			<div class="bg-fff b-a p-a-20 b-r-4 m-t-20">
				<div class="panel-title b-b p-b-20 m-b-20">
					<span>主题推荐</span>
				</div>
				<div class="index-themes">
					<div class="item">
						<div class="imte-box">
							<div class="thumb b-r-4">
								<a href="https://aj0.cn/zhuti/51.html" target="_blank">
									<img src="https://www.wpxyz.net/wp-content/uploads/2023/10/16967495452023100807190545.png" />
								</a>
								<span class="price free">免费</span>
							</div>
							<div class="item-bottom">
								<div class="title"><a href="https://aj0.cn/zhuti/51.html" target="_blank">Qzdy主题</a></div>
								<div class="desc c-md">WordPress简约博客主题</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="imte-box">
							<div class="thumb b-r-4">
								<a href="https://gitee.com/kannafay/iFalse" target="_blank">
									<img src="https://www.wpxyz.net/wp-content/uploads/2023/10/16967493082023100807150897.png" />
								</a>
								<span class="price free">免费</span>
							</div>
							<div class="item-bottom">
								<div class="title"><a href="https://gitee.com/kannafay/iFalse" target="_blank">iFalse主题</a></div>
								<div class="desc c-md">清新感设计WordPress主题</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="imte-box">
							<div class="thumb b-r-4">
								<a href="https://gitee.com/zhuige_com/jiangqie_theme" target="_blank">
									<img src="https://www.wpxyz.net/wp-content/uploads/2023/10/16967492372023100807135732.png" />
								</a>
								<span class="price free">免费</span>
							</div>
							<div class="item-bottom">
								<div class="title"><a href="https://gitee.com/zhuige_com/jiangqie_theme" target="_blank">酱茄主题</a></div>
								<div class="desc c-md">WordPress资讯、自媒体主题</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="imte-box">
							<div class="thumb b-r-4">
								<a href="https://www.lovestu.com/corepress-free" target="_blank">
									<img src="https://www.wpxyz.net/wp-content/uploads/2023/10/1696749640202310080720402.png" />
								</a>
								<span class="price free">免费</span>
							</div>
							<div class="item-bottom">
								<div class="title"><a href="https://www.lovestu.com/corepress-free" target="_blank">CorePress主题</a></div>
								<div class="desc c-md">功能功能WordPress资讯主题</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="bg-fff b-a p-a-20 b-r-4 m-t-20">
				<div class="panel-title b-b p-b-20 m-b-20">推广支持</div>
				<div class="index-thanks">
					<div class="xyz-tips xyz-tips-dg">感谢以下朋友对小宇宙插件的推广与支持!</div>
					<ul class="m-t-10">
						<?php 
							if(!empty($xyz_help_list)) {
							foreach ($xyz_help_list as $item) {
						?>
						<li><a href="<?php echo $item['url'];?>" target="_blank"><?php echo $item['title']; ?></a></li>
						<?php } } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="layui-col-md3">
			<div class="bg-fff b-a p-a-20 b-r-4">
				<div class="panel-title b-b p-b-20 m-b-20">关于小宇宙</div>
				<div class="plugin-about">
					<div class="c-md desc m-b-10"><?php echo $plugin_description; ?></div>
				</div>
			</div>
			<div class="bg-fff b-a p-a-20 b-r-4 m-t-20">
				<div class="panel-title b-b p-b-20 m-b-20">版本信息</div>
				<div class="plugin-var">
					<div class="plugin-bg"></div>
					<div class="var-title m-t-30"><?php echo $xyz_plugin_desc['plugin_name']; ?></div>
					<div class="var-info c-md m-t-20">
						<span>当前版本：v<?php echo $xyz_plugin_desc['plugin_version']; ?></span>
					</div>
					<div class="var-btn m-t-20 m-b-10">
						<a class="check-updates" id="check_updates">在线更新</a>
						<a href="https://www.wpxyz.net/update/" target="_blank">更新日志</a>
					</div>
				</div>
			</div>
		</div>
		<div class="layui-col-md3">
			<div class="bg-fff b-a p-a-20 b-r-4">
				<div class="panel-title b-b p-b-20 m-b-20">插件动态</div>
				<div class="plugin-news">
					<ul>
						<?php
							if(!empty($xyz_post_list)) {
							foreach ($xyz_post_list as $item) {
						?>
						<li>
							<a href="<?php echo $item['url']?>" target="_blank"><?php echo $item['title']?></a>
							<span class="c-md"><?php echo $item['time']?></span>
						</li>
						<?php }} ?>
					</ul>
				</div>
			</div>
			<div class="bg-fff b-a p-a-20 b-r-4 m-t-20">
				<div class="panel-title b-b p-b-20 m-b-20 flex">
					<span class="flex-1">联系我们</span>
				</div>
				<div class="index-contact">
					<ul>
						<li>广告合作：aye1991927 (微信)</li>
						<li>商务合作：1098816988 (QQ)</li>
						<li>技术交流：shenyan1840 (微信)</li>
					</ul>
				</div>
			</div>
			<div class="bg-fff b-a p-a-20 b-r-4 m-t-20">
				<div class="panel-title b-b p-b-20 m-b-20">赞助大使</div>
				<div class="index-adds">
					<?php
						if(!empty($xyz_sponsor_list)) {
						foreach ($xyz_sponsor_list as $item) {
					?>
					<a href="<?php echo $item['url']?>" target="_blank"><img src="<?php echo $item['img']?>" alt="<?php echo $item['title']?>" /></a>
					<?php }} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>


    layui.use(['form', 'layedit', 'laydate'], function() {
        var form = layui.form
            , layer = layui.layer

         $('#check_updates').click(function ()
         {
             send_request(rest_url+'xyz/purge/check',{},function (res) {
                 check(res.data.msg);
             },function (res) {
                 check('当前插件为最高版本');
             },wp_nonce)
             
         })
        
        
        function check(msg)
        {
            if(msg=='当前已是最新版本'){
                layer.open({
                    title: '版本检查',
                    type: 1,
                    closeBtn: false,
                    content: '<div class="updates-box">'+msg+'</p>',
                     btnAlign: 'c' //按钮居中
                    ,btn: '关闭',
                });
            } else {
                layer.open({
                    title: '版本检查',
                    type: 1,
                    closeBtn: false,
                    //content: '<div class="updates-box">当前已是最新版本！</p>'
                    content: '<div class="updates-box">'+msg+'</p>',
                    btn: ['更新', '取消'],
                    yes: function(index, layero){
                        layer.load();
                        send_request(rest_url+'xyz/purge/update',{},function (res) {
                            parent.layer.msg(res.msg, {time: 2000}, function () {
                                //重新加载父页面
                                parent.location.reload();
                            });
                        },function (res) {},wp_nonce)
                    }
                });
                
            }
            
          
        }
        
        form.render();
    });
    
    

</script>