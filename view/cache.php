<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );
?>
<div class="xyz-body xyz-smtp">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this">Memcached配置</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
			<div class="xyz-cover"></div>
			<div class="layui-tab-item layui-show">
				<form class="xyz-tab layui-form" id="form">
					<div class="xyz-tab-item">
						<div class="item-title">开启缓存</div>
						<div>
							<input type="checkbox" name="star" lay-skin="switch"  lay-text="ON|OFF">
							<div class="c-md m-t-20">开启Memcached缓存</div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">配置步骤</div>
						<div>
							<ul>
								<li>1. 在宝塔面板PHP管理中安装<b>memcached</b>拓展</li>
								<li>2. 在小宇宙插件的vendor目录下载<b>object-cache.php</b>文件</li>
								<li>3. 将<b>object-cache.php</b>文件上传到网站的<b>wp-content目录</b></li>
							</ul>
						</div>
					</div>
					<div class="layui-form-item m-t-20 br-last">
						<button type="button" class="layui-btn" id="submit">保存</button>
						<button type="button" class="layui-btn bg-dg" id="submit">清除缓存</button>
					</div>
				</form>
			</div>
        </div>
	</div>
</div>

<script>


</script>