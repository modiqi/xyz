<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );
?>
<div class="xyz-body xyz-smtp">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this">邮箱配置</li>
			<li>测试发件</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
			<div class="xyz-cover"></div>
			<div class="layui-tab-item layui-show">
				<form class="xyz-tab layui-form" id="form">
					<div class="xyz-tab-item">
						<div class="item-title">开启邮件配置</div>
						<div>
							<input type="checkbox" name="star" lay-skin="switch"  lay-text="ON|OFF">
							<div class="c-md m-t-20">开启邮件配置</div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">SMTP服务器</div>
						<div class="layui-col-md3">
							<input type="text" name="host" required placeholder="请输入token" value="" class="layui-input">
							<div class="c-md m-t-20">请填写SMTP主机（例:smtp.qq.com）</div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">发送协议</div>
						<div class="layui-col-md3">
							<input type="text" name="ssl" required placeholder="请输入token" value="" class="layui-input">
							<div class="c-md m-t-20">请填写发送协议（例:ssl）</div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">SSL端口</div>
						<div class="layui-col-md3">
							<input type="text" name="port" required placeholder="请输入token" value="" class="layui-input">
							<div class="c-md m-t-20">请填写SSL端口（例:465）</div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">邮箱用户名</div>
						<div class="layui-col-md3">
							<input type="text" name="username" required placeholder="请输入token" value="" class="layui-input">
							<div class="c-md m-t-20">请填写邮箱用户名（例:1098816988@qq.com）</div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">邮箱授权码</div>
						<div class="layui-col-md3">
							<input type="text" name="token" required placeholder="请输入token" value="" class="layui-input">
							<div class="c-md m-t-20">请填写邮箱授权码（在邮箱设置里获取）</div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">发件人姓名</div>
						<div class="layui-col-md3">
							<input type="text" name="sendname" required placeholder="请输入token" value="" class="layui-input">
							<div class="c-md m-t-20">请填写SMTP发件人姓名（例:小宇宙）</div>
						</div>
					</div>
					<div class="layui-form-item m-t-20 br-last">
						<button type="button" class="layui-btn" id="submit">保存</button>
					</div>
				</form>
			</div>
			<div class="layui-tab-item">
				<form class="xyz-tab layui-form" id="form">
					<div class="xyz-tab-item">
						<div class="item-title">收件人</div>
						<div class="layui-col-md3">
							<input type="text" name="addressee" required placeholder="请输入token" value="" class="layui-input">
							<div class="c-md m-t-20">请填写收件人邮箱</div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">邮件标题</div>
						<div class="layui-col-md3">
							<input type="text" name="title" required placeholder="请输入token" value="" class="layui-input">
							<div class="c-md m-t-20">请填写邮件标题</div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">邮件内容</div>
						<div class="layui-col-md3">
							<textarea name="content" placeholder="请输入内容" class="layui-textarea"></textarea>
							<div class="c-md m-t-20">请填写邮件标题内容</div>
						</div>
					</div>
					<div class="layui-form-item m-t-20 br-last">
						<button type="button" class="layui-btn" id="submit">发送</button>
					</div>
				</form>
			</div>
        </div>
	</div>
</div>

<script>


</script>