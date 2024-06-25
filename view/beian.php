<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );
    $page_path_file = array(
        ['path'=>'static/beian_page/beian01.php','name'=>'备案页面1'],
        ['path'=>'static/beian_page/beian02.php','name'=>'备案页面2'],
    );
    $option = unserialize(get_option('xyz-beian',serialize([])));
?>
<div class="xyz-body xyz-sitemap">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this">备案页面</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
	        <form class="xyz-tab layui-form" id="form">
				<div class="xyz-tab-item">
					<div class="item-title">开启备案页面</div>
					<div>
						<input type="checkbox" name="status" lay-skin="switch"  <?php if(isset($option['status']) && $option['status']=='on'){ echo 'checked';}?> lay-text="ON|OFF">
						<div class="c-md m-t-20">开启开启备案页面<a class="c-dg" href="https://www.wp-xyz.com/jc/130.html" target="_blank">（备案页面功能有什么用？）</a></div>
					</div>
				</div>
				<div class="xyz-tab-item">
					<div class="item-title">选择备案页面</div>
					<div class="layui-col-md2">
						<select name="beian_page" lay-verify="required" lay-search="">
				            <option value="">请选择备案模板</option>
							<?php
							foreach ($page_path_file as $item){
								if(isset($option['beian_page']) && $item["path"] == $option['beian_page']){
									echo '<option value="'.$item["path"].'" selected="" >'.$item["name"].'</option>';
								}else{
									echo '<option value="'.$item["path"].'">'.$item["name"].'</option>';
								}
							}
							?>
				        </select>
				        <div class="c-md m-t-10">选择喜欢的备案页面</div>
					</div>
				</div>
                <div class="xyz-tab-item">
                    <div class="item-title">网站名称</div>
                    <div class="layui-input-inline">
                        <input type="text" name="beian_site_name" required value="<?php echo $option['beian_site_name']??''; ?>" placeholder="" autocomplete="off" class="layui-input">
                        <div class="c-md m-t-10">填写正确网站名称</div>
                    </div>
                </div>
                
				<div class="xyz-tab-item">
				    <div class="item-title">填写备案号</div>
				    <div class="layui-input-inline">
				        <input type="text" name="beian_hao" required value="<?php echo $option['beian_hao']??''; ?>" placeholder="" autocomplete="off" class="layui-input">
						<div class="c-md m-t-10">填写正确网站备案号码</div>
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
    var apiUrl="<?php echo $url;?>";
    layui.use(['form', 'layedit', 'laydate'], function() {
        var form = layui.form
            , layer = layui.layer

        $("#submit").click(function(){
            let params = $("#form").serializeArray();
            send_request(apiUrl+'xyz/beian/save',params,function (res) {
                layer.msg('保存成功')
            },function (res) {
                layer.msg('保存失败')
            },wp_nonce)
        });

        form.render();
    });

</script>