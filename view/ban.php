<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );
?>
<div class="xyz-body xyz-smtp">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this">违禁词屏蔽</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
			<div class="xyz-cover"></div>
			<div class="layui-tab-item layui-show">
				<form class="xyz-tab layui-form" id="form">
					<div class="xyz-tab-item">
						<div class="item-title">开启屏蔽</div>
						<div>
							<input type="checkbox" name="star" lay-skin="switch"  lay-text="ON|OFF">
							<div class="c-md m-t-20">开启违禁词屏蔽</div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">添加违禁词</div>
					    <div class="layui-col-md3">
					        <textarea type="textarea" name="robots" placeholder="请添加Robots规则。" class="layui-textarea"><?php echo $content; ?></textarea>
					        <div class="c-md m-t-20">添加违禁词，一行一个</div>
					    </div>
					</div>
					<div class="layui-form-item m-t-20 br-last">
						<button type="button" class="layui-btn" id="submit">保存</button>
					</div>
				</form>
			</div>
        </div>
	</div>
</div>

<script>


</script>