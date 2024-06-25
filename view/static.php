<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );
    $xyz_page=  unserialize(get_option("xyz-page-static",serialize([])));
    $xyz_open_status = $xyz_page['xyz-open-static']??'false';
    $category = get_categories(['hide_empty' => false]);
?>
<div class="xyz-body xyz-static">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this">静态化设置</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
			<div class="layui-tab-item layui-show">
		        <form class="xyz-tab layui-form" id="form">
					<div class="xyz-tab-item">
						<div class="item-title">开启静态化</div>
						<div>
							<input type="checkbox" name="xyz-open-static" <?php if(isset($xyz_page['xyz-open-static']) &&  $xyz_page['xyz-open-static'] == 'true'){ echo 'checked';}?> lay-filter="basic_switch"  lay-skin="switch"  lay-text="ON|OFF">
							<div class="c-md m-t-20">开启静态化功能（静态化文件读取）</div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">首页静态化</div>
						<div>
							<button type="button" class="layui-btn" id="home">生成首页</button>
							<div class="c-md m-t-20">点击生成首页静态化文件</div>
						</div>
					</div>
					<div class="xyz-tab-item">
						<div class="item-title">分类静态化</div>
						<div>
							<button type="button" class="layui-btn" id="category">生成分类</button>
							<div class="c-md m-t-20">点击生成所有分类静态化文件</div>
						</div>
					</div>

                    <div class="xyz-tab-item">
                        <div class="item-title">分类文章静态化</div>
                        <div>
                            <button type="button" class="layui-btn" id="category_art">选择分类</button>
                            <div class="c-md m-t-20">点击生成指定分类下文章静态化文件</div>
                        </div>
                    </div>
                    <div class="xyz-tab-item">
                        <div class="item-title">整站文章静态化</div>
                        <div>
                            <button type="button" class="layui-btn layui-btn-disabled">文章生成</button>
                            <div class="c-md m-t-20">点击生成整站文章静态化文件<span class="c-dg">（任务开启后无法停止,文章数量多请谨慎使用!）</span></div>
                        </div>
                    </div>
		        </form>
	        </div>
        </div>
	</div>
</div>
<style>
	.xyz-static-form {}
	.xyz-static-form table {
		overflow-y: scroll;
	}
</style>
<script id="category_art_id" type="text/html">
    <form class="xyz-static-form p-a-20" id="form">
        <b>请选择分类：</b>
		<table class="layui-table">
			<colgroup>
				<col width="50">
				<col width="80">
				<col>
				<col width="80">
			</colgroup>
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th>分类名称</th>
					<th>数量</th>
				</tr> 
			</thead>
			<tbody id="cate_ids">
				<?php foreach ($category as $cate){ ?>
				<tr>
					<th><input type="checkbox" name="ids" value="<?php echo $cate->term_id?>" lay-skin="primary"></th>
					<td><?php echo $cate->term_id?></td>
					<td><?php echo $cate->name;?></td>
					<td><?php echo $cate->count?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
        <button type="button" class="layui-btn m-t-10" onclick="select_cate()">静态化生成</button>
		<div class="layui-progress layui-progress-big m-t-20" lay-showpercent="true">
			<div class="layui-progress-bar layui-bg-blue" style="width: 0%;" id="progress"><span class="layui-progress-text" id="progress-text">0%</span></div>
		</div>
    </form>
</script>

<script>
    let static = <?php echo $xyz_open_status; ?>;
    layui.use(['form', 'layedit', 'laydate','element'], function() {
        var form = layui.form
            , layer = layui.layer
        
        static_open_close(static,['#home','#category','#category_art'])

        form.on('switch(basic_switch)',function (obj)
        {
            static_open_close(obj.elem.checked,['#home','#category','#category_art'])
            
            send_request(rest_url+'xyz/pagestatic/save',{
                'status':obj.elem.checked,
                'name'  :obj.elem.name,
            },function (res) {
                layer.msg(res.msg)
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        });

        $('#home').click(function () {
            let index = layer.load();
            send_request(rest_url+'xyz/pagestatic/home',{},function (res) {
                parent.layer.msg(res.msg, {time: 2000}, function () {
                    //重新加载父页面
                    layer.close(index);
                });
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })

        $('#category').click(function () {
            let index = layer.load();
            send_request(rest_url+'xyz/pagestatic/category',{},function (res) {
                parent.layer.msg(res.msg, {time: 2000}, function () {
                    //重新加载父页面
                    layer.close(index);
                });
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })
        
        $('#category_art').click(function () {
            layer.open({
                type: 1,
                title:'分类文章生成',
                area: ['600px', '320px'],
                content: $('#category_art_id').html()
            });
            form.render();
        });
        
        form.render();
    });

    function static_open_close(status,ids_index) {
        if(status) {
            $.each(ids_index,function (k,v) {
                $(v).removeClass("layui-btn-disabled");
                $(v).attr('disabled',false)
            })
        } else {
            $.each(ids_index,function (k,v) {
                $(v).addClass("layui-btn-disabled");
                $(v).attr('disabled',true)
            })
        }
    }
    let index = null
    function select_cate() {

        let cate_id = [];
        $('input[name="ids"]:checked').each(function(o) {
            cate_id.push($(this).attr('value'))
        });
        
        if(cate_id.length<=0){
            layer.msg('未选择分类')
            return;
        }
        index = layer.load();
        send_cate(cate_id,1,0)
    }
    function send_cate(cate_id,page,total) {
        send_request(rest_url+'xyz/pagestatic/category_art'
            ,{term_id:cate_id,page:page,total:total}
            ,function (res) {
                if(res.data.total<=0){
                    layer.msg('选中分类无文章')
                    return
                }
                if(res.data.total>res.data.grean_total){
                    p = parseInt((res.data.grean_total/res.data.total)*100)
                    $('#progress').css('width',p+'%')
                    $('#progress-text').text(p+'%')
                    send_cate(cate_id,res.data.page,res.data.total)
                }else{
                    $('#progress').css('width','100%')
                    $('#progress-text').text('100%')
                    layer.msg('生成完成')
                    layer.close(index);
                }
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
    }

</script>
