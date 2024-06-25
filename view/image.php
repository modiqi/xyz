<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );
?>
<div class="xyz-body xyz-sitemap">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this">本地化设置</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
			<div class="xyz-cover"></div>
	        <form class="xyz-tab layui-form" id="form">
				<div class="xyz-tab-item">
					<div class="item-title">开启本地化</div>
					<div>
						<input type="checkbox" name="star" lay-skin="switch"  lay-text="ON|OFF">
						<div class="c-md m-t-20">自动把文章内的外链图片保存到本地</div>
					</div>
				</div>
				<div class="layui-form-item m-t-20 m-l-20 br-last">
				    <button type="button" class="layui-btn" id="submit">保存</button>
				</div>
	        </form>
        </div>
	</div>
</div>

<script>


</script>