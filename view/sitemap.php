<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );
	$nonce = wp_create_nonce( 'wp_rest' );
    $sitemap = (array) unserialize( get_option( 'xyz-sitemap', serialize([])));
?>
<div class="xyz-body xyz-sitemap">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this">网站地图</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
	        <form class="xyz-tab layui-form" id="form">
				<div class="xyz-tab-item">
					<div class="item-title">文章数量</div>
					<div class="layui-col-md3">
						<input type="text" name="num" required placeholder="默认5000篇" value="<?php if(isset($sitemap['num'])){ echo $sitemap['num'];}?>" class="layui-input">
						<div class="c-md m-t-10">设置生成xml的文章数量,默认5000篇文章</div>
					</div>
				</div>
				<div class="xyz-tab-item">
					<div class="item-title">生成频率</div>
					<div class="layui-col-md3">
						<input type="text" name="days" required placeholder="默认1天生成一次" value="<?php if(isset($sitemap['days'])){ echo $sitemap['days'];}?>" class="layui-input">
						<div class="c-md m-t-10">生成网站地图的周期,默认1天生成一次</div>
					</div>
				</div>
				<div class="xyz-tab-item">
					<div class="item-title">覆盖页面</div>
					<div class="layui-col-md6">
						<input type="checkbox" name="page_index" title="首页" <?php if(isset($sitemap['page_index'])){ echo 'checked';}?> />
						<input type="checkbox" name="page_list" title="列表页" <?php if(isset($sitemap['page_list'])){ echo 'checked';}?> />
						<input type="checkbox" name="page_art"  title="文章页" <?php if(isset($sitemap['page_art'])){ echo 'checked';}?> />
						<input type="checkbox" name="page_page"  title="单页面" <?php if(isset($sitemap['page_page'])){ echo 'checked';}?> />
						<input type="checkbox" name="page_tag"  title="标签页" <?php if(isset($sitemap['page_tag'])){ echo 'checked';}?> />
						<div class="c-md m-t-10">sitemap文件包含页面选择</div>
					</div>
				</div>
				<div class="xyz-tab-item">
					<div class="item-title">生成格式</div>
					<div class="layui-col-md3">
						<input type="checkbox" name="mark_xml" title="XML" <?php if(isset($sitemap['mark_xml'])){ echo 'checked';}?> />
						<!--input type="checkbox" name="mark_txt" title="TXT"<?php if(isset($sitemap['mark_txt'])){ echo 'checked';}?> /-->
						<div class="c-md m-t-10">sitemap生成格式选择</div>
					</div>
				</div>
				<div class="xyz-tab-item">
					<div class="item-title">文件预览</div>
					<div class="">
						<a class="layui-btn layui-btn-sm " href="<?php echo home_url();?>/sitemap.xml" target="_blank">XML</a>
					</div>
				</div>
				<div class="xyz-tab-item">
					<button type="button" class="layui-btn" id="submit">保存设置</button>
					<button type="button" class="layui-btn layui-btn-normal" id="sitemapxml">生成 xml</button>
					<!--button type="button" class="layui-btn layui-btn-warm" id="sitemaptxt">生成 txt</button-->
				</div>
	        </form>
        </div>
	</div>
</div>

<script>
    var apiUrl="<?php echo $url;?>";
    layui.use(['form', 'layedit', 'laydate'], function() {
        var form = layui.form
            , layer = layui.layer

        $("#submit").click(function(){
            let xyz_sitemaps = $("#form").serializeArray();
            send_request(apiUrl+'xyz/sitemap/save',{
                'xyz_sitemap':xyz_sitemaps
            },function (res) {
                layer.msg(res.msg)
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })

        $("#sitemapxml").click(function(){
            send_request(apiUrl+'xyz/sitemap/create_map_xml',{},function (res) {
                layer.msg(res.msg)
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })

        $("#sitemaptxt").click(function(){
            send_request(apiUrl+'xyz/sitemap/create_map_txt',{},function (res) {
                layer.msg(res.msg)
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })
        
        form.render();
    });

</script>