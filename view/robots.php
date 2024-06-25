<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
    $url = esc_url_raw(rest_url());

    $content = '';
    $file = ABSPATH . '/robots.txt';
    if(file_exists($file)){
	   $content = file_get_contents($file);
    }

?>
<div class="xyz-body xyz-theme">
    <div class="layui-tab layui-tab-card b-a">
        <ul class="layui-tab-title">
            <li class="layui-this">Robots生成</li>
        </ul>
        <div class="layui-tab-content bg-fff p-a-20">
	         <form class="layui-form xyz-tab" id="form">
                <div class="xyz-tab-item">
                	<div class="item-title">添加规则</div>
                    <div class="layui-col-md3">
                        <textarea type="textarea" name="robots" placeholder="请添加Robots规则。" class="layui-textarea"><?php echo $content; ?></textarea>
                        <div class="c-md m-t-20">添加Robots.txt生成规则</div>
                    </div>
                </div>
                <div class="xyz-tab-item">
                	<div class="item-title">参考规则：</div>
                    <div class="layui-col-md3 c-md" style="line-height: 24px;">
						User-agent: *</br>
						Disallow: /wp-admin/</br>
						Disallow: /wp-includes/</br>
						Disallow: /wp-json/</br>
						Disallow: /wp-content/themes</br>
                    </div>
                </div>
                <div class="layui-form-item m-t-20 m-l-20 br-last">
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
            let xyz_push = $("#form").serializeArray();
            send_request(apiUrl+'xyz/robots/save',xyz_push,function (res) {
                layer.msg('保存成功')
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })
        
        form.render();
    });

</script>