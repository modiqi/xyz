<?php
	xyz_load_scripts();
	$path = plugin_dir_url(__DIR__);
	$url = esc_url_raw(rest_url());
	$nonce = wp_create_nonce('wp_rest');

    $seo = unserialize(get_option( 'xyz-seo-site', serialize([]) ));
   
    $basic =  xyz_basic_option();
    
	$optimize = array(
		[
			['title'=>'去掉头部shortlink短连接','name'=>'disable_head_shortlink','value'=>'','info'=>'去掉头部shortlink短连接'],
			['title'=>'去掉分类category','name'=>'disable_cat_category','value'=>'','info'=>'去掉分类URL中的category（开启后保存下<a href="/wp-admin/options-permalink.php" target="_blank">固定连接</a>！）'],
			['title'=>'精简分类URL','name'=>'disable_cat_url','value'=>'','info'=>'去掉二级分类URL中的一级分类（开启后保存下<a href="/wp-admin/options-permalink.php" target="_blank">固定连接</a>！）'],
			['title'=>'精简文章URL','name'=>'disable_post_url','value'=>'','info'=>'去掉文章URL中的一级分类（开启后保存下<a href="/wp-admin/options-permalink.php" target="_blank">固定连接</a>！）'],
			['title'=>'禁用wp-sitemap','name'=>'disable_wp_sitemaps','value'=>'','info'=>'WordPress自带的wp-sitemap功能不是很好，推荐禁用'],
			['title'=>'禁用wp-robots','name'=>'disable_wp_robots','value'=>'','info'=>'wp-robots对于新手来说，这是一个毫无用处的东西，head多了一行代码而已，建议禁用'],
			['title'=>'tag标签URL改id展示','name'=>'tag_rewrite_rules_id','value'=>'','info'=>'tag的URL包含中文是不太符合seo优化需求的，所以这个选项能够让tag标签url改id展示'],
			['title'=>'TAG跳转优化','name'=>'tag_redirect_post','value'=>'','info'=>'WordPress 标签对应只有一篇文章时自动跳转到该文章'],
			['title'=>'文章TAG自动添加内链','name'=>'wpxyz_tag_add_link','value'=>'','info'=>'WordPress文章内TAG自动内链已有的TAG标签页面'],
			['title'=>'文章外链自动添加nofollow','name'=>'single_link_add_nofollow','value'=>'','info'=>'给文章外链添加nofollow防止导出权重，可以在这里开启'],
			['title'=>'搜索结果优化','name'=>'search_redirect_post','value'=>'','info'=>'搜索结果只有一篇文章时跳转到该文章'],
		],
	 )
?>
<div class="xyz-body xyz-basic">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this">TDK设置</li>
			<li>SEO优化</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
			<div class="layui-tab-item layui-show">
				<form class="xyz-tab layui-form" id="form1">
					<div class="xyz-tab-item">
						<div class="item-title">首页TDK</div>
						<div>
							<input type="checkbox" name="seo_switch" <?php if(isset($seo['seo_switch']) &&  $seo['seo_switch'] == 'on'){ echo 'checked';}?> lay-skin="switch"  lay-text="ON|OFF">
							<div class="c-md m-t-20">开启首页自定义TDK<span class="c-dg">（确保主题有wp_head()函数，并且无其他SEO插件）<span></div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">分类TDK</div>
						<div>
							<input type="checkbox" name="seo_switch" disabled lay-skin="switch"  lay-text="ON|OFF">
							<div class="c-md m-t-20">开启分类自定义TDK<a class="c-dg" href="/wp-admin/edit-tags.php?taxonomy=category" target="_blank">（点击前往设置）</a></div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">文章TDK</div>
						<div>
							<input type="checkbox" name="seo_switch" disabled lay-skin="switch"  lay-text="ON|OFF">
							<div class="c-md m-t-20">开启分类自定义TDK<a class="c-dg" href="/wp-admin/edit.php" target="_blank">（点击前往设置）</a></div>
						</div>
					</div>
					<div class="xyz-tab-item">
					    <div class="item-title">首页标题</div>
					    <div class="layui-col-md3">
					        <input type="text" name="seo_title" required value="<?php if(isset($seo['seo_title'])){ echo $seo['seo_title'];}?>" placeholder="" autocomplete="off" class="layui-input">
							<div class="c-md m-t-10">填写首页自定义标题</div>
					    </div>
					</div>
					<div class="xyz-tab-item">
					    <div class="item-title">首页关键词</div>
					    <div class="layui-col-md3">
					        <input type="text" name="seo_keywords" required value="<?php if(isset($seo['seo_keywords'])){ echo $seo['seo_keywords'];}?>" placeholder="" autocomplete="off" class="layui-input">
							<div class="c-md m-t-10">填写首页自定义关键词</div>
					    </div>
					</div>
					<div class="xyz-tab-item">
					    <div class="item-title">首页关描述</div>
					    <div class="layui-col-md3">
					        <textarea type="textarea" name="seo_description" placeholder="" class="layui-textarea"><?php if(isset($seo['seo_description'])){ echo $seo['seo_description'];}?></textarea>
					        <div class="c-md m-t-20">填写首页自定义描述</div>
					    </div>
					</div>
					<div class="xyz-tab-item">
						<button type="button" class="layui-btn" id="submit">保存</button>
					</div>
				</form>
			</div>
			<div class="layui-tab-item">
				<form class="xyz-tab layui-form" id="form2">
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
		</div>
	</div>
</div>

<script>
    var apiUrl="<?php echo $url;?>";
    
    layui.use(['form', 'layedit', 'laydate'], function() {
        var form = layui.form
            , layer = layui.layer
            , layedit = layui.layedit
            , laydate = layui.laydate;

        $("#submit").click(function(){
            let datas = $("#form1").serializeArray();
            send_request(apiUrl+'xyz/seo/save',datas,function (res) {
                layer.msg('保存成功')
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })
        
        form.on('switch(basic_switch)',function (obj)
        {
            send_request(apiUrl+'xyz/basic/save',{
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