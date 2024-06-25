<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );

    $option = unserialize(get_option('xyz-publish',serialize([])));
?>
<div class="xyz-body xyz-sitemap">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this">自动发布</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
	        <form class="xyz-tab layui-form" id="form">
				<div class="xyz-tab-item">
					<div class="item-title">开启发布</div>
					<div>
						<input type="checkbox" name="switch" lay-skin="switch" <?php if(isset($option['switch']) &&  $option['switch'] == 'on'){ echo 'checked';}?>  lay-text="ON|OFF">
						<div class="c-md m-t-20">开启文章自动发布</div>
					</div>
				</div>
				<div class="xyz-tab-item">
					<div class="item-title">发布状态</div>
					<div class="layui-col-md1">
						<select name="status" lay-verify="required" lay-search="">
				            <option value="draft"   <?php if(isset($option['status']) &&  $option['status'] == 'draft'){ echo 'selected=""';}?> >草稿</option>
				            <option value="pending" <?php if(isset($option['status']) &&  $option['status'] == 'pending'){ echo 'selected=""';}?> >待审核</option>
				        </select>
				        <div class="c-md m-t-10">选择文章状态</div>
					</div>
				</div>
				<div class="xyz-tab-item">
					<div class="item-title">发布顺序</div>
					<div class="layui-col-md1">
						<select name="sort" lay-verify="required" lay-search="">
	                        <option value="desc_sort" <?php if(isset($option['sort']) &&  $option['sort'] == 'desc_sort'){ echo 'selected=""';}?> >最新排序</option>
	                        <option value="asc_sort"  <?php if(isset($option['sort']) &&  $option['sort'] == 'asc_sort'){ echo 'selected=""';}?> >最旧排序</option>
	                        <option value="rand_sort" <?php if(isset($option['sort']) &&  $option['sort'] == 'rand_sort'){ echo 'selected=""';}?> >随机排序</option>
	                    </select>
	                    <div class="c-md m-t-10">设置发布顺序</div>
					</div>
				</div>
				<div class="xyz-tab-item">
					<div class="item-title">定时发布</div>
					<div class="layui-col-md6">
						<ul>
							<li>1. 宝塔创建计划任务</li>
							<li>2. 任务类型选择<b>访问URL</b>，地址填写：https://www.xxx.com/wp-json/xyz/plan/look（www.xxx.com修改为你的网址）</li>
							<li>3. 执行周期看个人了</li>
							<li>4. 确定保存，然后执行任务试试。</li>
							<li>还不会的朋友可以点击这里看<a href="https://www.wp-xyz.com/xyz/90.html" target="_blank">定时发布文章教程!</a></li>
						</ul>
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
            send_request(apiUrl+'xyz/publish/save',params,function (res) {
                layer.msg('保存成功')
            },function (res) {
                layer.msg('保存失败')
            },wp_nonce)
        });

        form.render();
    });

</script>