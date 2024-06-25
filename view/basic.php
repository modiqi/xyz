<?php
	xyz_load_scripts();
	$path = plugin_dir_url(__DIR__);
	
    $basic =  xyz_basic_option();
    
	$optimize = array(
		 [
			['title'=>'禁用古腾堡编辑器','name'=>'disable_gutenberg','value'=>'','info'=>'<a class="c-md" href="https://www.wpxyz.net/jc/145.html" target="_blank">不习惯用古腾堡编辑器朋友，可以禁用Gutenberg</a>'],
			['title'=>'禁用顶部工具条','name'=>'disable_admin_bar','value'=>'','info'=>'<a class="c-md" href="https://www.wpxyz.net/jc/145.html" target="_blank">建议禁用，影响美观</a>'],
			['title'=>'禁用文章修订','name'=>'disable_post_revisions','value'=>'','info'=>'<a class="c-md" href="https://www.wpxyz.net/jc/149.html" target="_blank">文章修订会在 Posts 表中插入多条历史数据，造成 Posts 表冗余，建议禁用文章修订功能，提高数据库效率</a>'],
			['title'=>'禁用Trackbacks','name'=>'disable_trackback','value'=>'','info'=>'<a class="c-md" href="https://www.wpxyz.net/jc/150.html" target="_blank">彻底关闭Trackbacks，防止垃圾留言</a>'],
			['title'=>'禁用字符转码','name'=>'disable_wptexturize','value'=>'','info'=>'禁用字符换成格式化的HTML实体功能'],
			['title'=>'禁用站点Feed','name'=>'disable_feeds','value'=>'','info'=>'WordPress Feed 主要用于阅读器使用，但是现在使用阅读器的用户越来越少，而 Feed 更多被人用于采集，造成不必要的资源消耗，建议关闭站点 Feed'],
			['title'=>'禁用后台隐私','name'=>'disable_admin_privacy','value'=>'','info'=>'禁用为欧洲通用数据保护条例而生成的隐私页面'],
			['title'=>'禁用Auto Embeds','name'=>'disable_admin_embeds','value'=>'','info'=>'禁用Auto Embeds功能，加快页面解析速度'],
			['title'=>'禁用XML-RPC','name'=>'disable_xml_rpc','value'=>'','info'=>'关闭XML-RPC功能，只在后台发布文章'],
			['title'=>'禁用谷歌字体','name'=>'disable_google_font','value'=>'','info'=>'禁用后台谷歌字体,加速后台访问速度'],
			['title'=>'Gravatar头像加速','name'=>'gravatar_speed','value'=>'','info'=>'WordPress本身的头像是国外的，这边建议换国内的'],
		 ],
		[
			['title'=>'禁用头部max-image-preview','name'=>'disable_head_max_image_preview','value'=>'','info'=>'禁用头部max-image-preview:large'],
			['title'=>'禁用头部Emoji图片','name'=>'disable_head_emoji','value'=>'','info'=>'禁用Emoji图片转换功能，直接使用Emoji'],
			['title'=>'禁用头部5.9版本多余CSS','name'=>'disable_head_v59_css','value'=>'','info'=>'WordPress升级.9版本后头部head会多很多变量CSS,建议禁用'],
			['title'=>'禁用头部版本号','name'=>'disable_head_version','value'=>'','info'=>'禁用头部版本号 meta信息<span class="c-dg">（6.4版本后会影响古腾堡区块，建议不开启）</span>'],
			['title'=>'禁用头部dns-prefetch','name'=>'disable_head_dns','value'=>'','info'=>'禁用头部dns-prefetch meta信息'],
			['title'=>'移除头部application/json+oembed和text/xml+oembe','name'=>'disable_head_json','value'=>'','info'=>'移除头部application/json+oembed和text/xml+oembe meta信息'],
			['title'=>'禁用头部rsd+xml+wlwmanifest标签','name'=>'disable_head_rsd_wlwmanifest','value'=>'','info'=>'禁用头部rsd+xml+wlwmanifestmeta信息'],
			['title'=>'屏蔽头部classic-theme-styles样式','name'=>'disable_classic_theme_styles','value'=>'','info'=>'屏蔽头部classic-theme-styles-inline-css样式'],
		],
		[
			['title'=>'上传图片重命名','name'=>'upload_filter_rename','value'=>'','info'=>'防止上传图片名称是中文名，或者其他花里胡哨，建议开启'],
			['title'=>'上传图片增加时间戳','name'=>'upload_prefilter_add_time','value'=>'','info'=>'防止上传的图片重名，加上时间戳'],
			['title'=>'图片添加alt和title','name'=>'image_add_alt_title','value'=>'','info'=>'自动添加图片的alt和title，方便快捷，推荐开启'],
			['title'=>'删除文章同时删除图片附件','name'=>'disable_post_and_filter','value'=>'','info'=>'节省服务器空间，清理无用图片附件'],
			['title'=>'禁用自动生成的图片附件','name'=>'disable_add_thumbnail','value'=>'','info'=>'上传图片的时候，会自动生成各个尺寸的缩略图，推荐禁用，减少服务器负担'],
		],
		[
			['title'=>'浏览量设置','name'=>'disable_auto_view','value'=>'','info'=>'手动设置文章浏览量'],
			['title'=>'屏蔽自动更新','name'=>'disable_auto_udates','value'=>'','info'=>'WordPress的自动更新很坏事，建议禁用'],
			['title'=>'屏蔽邮箱验证','name'=>'disable_mail_verification','value'=>'','info'=>'禁用站点管理员邮箱定期验证功能'],
			['title'=>'禁用后台登录语言选择','name'=>'disable_login_lang','value'=>'','info'=>'禁用在 WordPress 5.9 中登录页面的语言选择器'],
			['title'=>'开启后台友情链接','name'=>'open_admin_links','value'=>'','info'=>'有些低版本WordPress自带的友情链接功能没有打开，可以在这里开启'],
			['title'=>'开启后台小工具','name'=>'open_admin_sidebar','value'=>'','info'=>'有些低版本WordPress自带的小工具功能没有打开，可以在这里开启'],
		]
	 )
?>
<div class="xyz-body xyz-basic">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this">性能优化</li>
			<li>头部优化</li>
			<li>附件优化</li>
			<li>其他优化</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
			<div class="layui-tab-item layui-show">
				<form class="xyz-tab layui-form" id="form1">
					<?php foreach ($optimize[0] as $item){ ?>
					<div class="xyz-tab-item">
						<div class="item-title"><?php echo $item['title'];?></div>
						<div>
							<input type="checkbox" <?php if(isset($basic[$item['name']]) &&  $basic[$item['name']] == 'true'){ echo 'checked';}?> name="<?php echo $item['name'];?>" lay-filter="basic_switch" lay-skin="switch"  lay-text="ON|OFF">
							<div class="c-md m-t-20"><?php echo $item['info'];?></div>
						</div>
					</div>
					<?php } ?>
				</form>
			</div>
			<div class="layui-tab-item">
				<form class="xyz-tab layui-form">
					<?php foreach ($optimize[1] as $item){ ?>
						<div class="xyz-tab-item">
							<div class="item-title"><?php echo $item['title'];?></div>
							<div>
								<input type="checkbox" <?php if(isset($basic[$item['name']]) &&  $basic[$item['name']] == 'true'){ echo 'checked';}?> name="<?php echo $item['name'];?>" lay-filter="basic_switch" lay-skin="switch"  lay-text="ON|OFF">
								<div class="c-md m-t-20"><?php echo $item['info'];?></div>
							</div>
						</div>
					<?php } ?>
				</form>
			</div>
			<div class="layui-tab-item">
				<form class="xyz-tab layui-form">
					<?php foreach ($optimize[2] as $item){ ?>
						<div class="xyz-tab-item">
							<div class="item-title"><?php echo $item['title'];?></div>
							<div>
								<input type="checkbox" <?php if(isset($basic[$item['name']]) &&  $basic[$item['name']] == 'true'){ echo 'checked';}?> name="<?php echo $item['name'];?>" lay-filter="basic_switch" lay-skin="switch"  lay-text="ON|OFF">
								<div class="c-md m-t-20"><?php echo $item['info'];?></div>
							</div>
						</div>
					<?php } ?>
				</form>
			</div>
			<div class="layui-tab-item">
				<form class="xyz-tab layui-form">
					<?php foreach ($optimize[3] as $item){ ?>
						<div class="xyz-tab-item">
							<div class="item-title"><?php echo $item['title'];?></div>
							<div>
								<input type="checkbox" <?php if(isset($basic[$item['name']]) &&  $basic[$item['name']] == 'true'){ echo 'checked';}?> name="<?php echo $item['name'];?>" lay-filter="basic_switch" lay-skin="switch"  lay-text="ON|OFF">
								<div class="c-md m-t-20"><?php echo $item['info'];?></div>
							</div>
						</div>
					<?php } ?>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
  
    layui.use(['form', 'layedit', 'laydate'], function() {
        var form = layui.form
            , layer = layui.layer

        form.on('switch(basic_switch)',function (obj)
        {
            send_request(rest_url+'xyz/basic/save',{
                'status':obj.elem.checked,
                'name'  :obj.elem.name,
            },function (res) {
                layer.msg('保存成功')
            },function (res) {
                layer.msg('保存失败')
            },wp_nonce)
        });
        
        form.render();
    });
    
</script>