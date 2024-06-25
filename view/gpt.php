<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );
?>
<div class="xyz-body xyz-gpt xyz-sitemap">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this">GPT写作</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
			<div class="xyz-cover"></div>
	        <form class="xyz-tab layui-form" id="form">
				<div class="xyz-tab-item">
					<div class="item-title">GPTToken</div>
					<div class="layui-col-md3">
						<input id="gpt-token" type="text" name="token" required placeholder="请填写token" value="<?php if(isset($cfg['baidu_push'])){ echo $cfg['baidu_push']['token'];}?>" class="layui-input">
					</div>
				</div>
				<div class="xyz-tab-item">
					<div class="item-title">GPT提问</div>
					<div class="layui-col-md5 d-f">
						<input id="submit-title" type="text" name="token" required placeholder="请填写标题" value="" class="layui-input">
						<button id="gpt-submit" type="button" class="layui-btn m-l-10" id="submit">生成</button>
					</div>
				</div>
	        </form>
        </div>
	</div>
	<div class="xyz-gpt-main m-t-20">
		<div class="xyz-cover"></div>
		<div class="gpt-question">
			<div class="question-box">
				<div class="ava"></div>
				<div class="gpt-title">WordPress小宇宙是什么？</div>
			</div>
		</div>
		<div class="gpt-answer">
			<div class="answer-box">
				<div class="gpt-content">
					<p>WordPress小宇宙是一款专为站长们量身打造的网站性能优化、SEO优化插件，插件功能包括了网站优化、SiteMap生成、文章推送、自动发布、文章静态化用功能，并且不断新增功能模块，致力于成为一款建站必备WordPress优化插件！</p>
				</div>
				<div class="ava"></div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#gpt-submit').click(function(){
		var title = $("#submit-title").val();
		var gptToken = $("#gpt-token").val();
		if( gptToken.length == 0 ) {
			alert('token不能为空！');
		}else {
			if( title.length == 0 ) {
				alert('提问内容不能为空！');
			}else {
				var html = '<div class="gpt-question"><div class="question-box"><div class="ava"></div><div class="gpt-title">' + title + '</div></div></div>';
				$('.xyz-gpt-main').append(html);
				var html = '<div class="gpt-answer"><div class="answer-box"><div class="gpt-content"><p>抱歉！GPT写作功能正在研发中！</p></div><div class="ava"></div></div></div>';
				
				setTimeout(function () {
					$('.xyz-gpt-main').append(html);
				}, 500); 
			}
		}
	  });
</script>