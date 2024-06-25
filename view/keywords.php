<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );
?>
<div class="xyz-body xyz-sitemap">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this">关键词内链</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
	        <form class="xyz-tab layui-form" id="form">
				<div class="xyz-tab-item">
					<div class="item-title">开启内链</div>
					<div>
						<input type="checkbox" name="switch" lay-skin="switch" lay-text="ON|OFF">
						<div class="c-md m-t-20">开启关键词内链功能</div>
					</div>
				</div>
				<div class="xyz-tab-item">
                	<div class="item-title">添加关键词</div>
                    <div class="layui-col-md4">
                        <textarea type="textarea" name="robots" placeholder="格式为：关键词-网址" class="layui-textarea"></textarea>
                        <div class="c-md m-t-20">添加关键词和对应的链接文章（格式为：关键词-网址）</div>
                        <div class="c-md m-t-20">案例：小宇宙插件-https://www.wp-xyz.com</div>
                        <div class="c-dg m-t-20">注意：一行一条！不要添加任何额外符号！</div>
                    </div>
                </div>
				<div class="xyz-tab-item">
					<button type="button" class="layui-btn" id="submit">保存</button>
				</div>
	        </form>
        </div>
	</div>
</div>

<script>
   

</script>