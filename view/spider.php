<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );
?>
<div class="xyz-body xyz-sitemap">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this">蜘蛛分析</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
	        <form class="xyz-tab layui-form" id="form">
				<div class="xyz-cover"></div>
				<div class="xyz-tab-item">
					<div class="item-title">开启蜘蛛分析</div>
					<div>
						<input type="checkbox" name="star" lay-skin="switch"  lay-text="ON|OFF">
						<div class="c-md m-t-20">开启蜘蛛分析功能</div>
					</div>
				</div>
	        </form>
        </div>
	</div>
</div>

<script>


</script>