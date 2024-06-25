<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );
	$nonce = wp_create_nonce( 'wp_rest' );
	$res = (array) unserialize(get_option( 'xyz-theme', serialize([]) ));
?>
<div class="xyz-body xyz-theme">
    <div class="layui-tab layui-tab-card b-a">
        <ul class="layui-tab-title">
            <li class="layui-this">移动端主题</li>
        </ul>
        <div class="layui-tab-content bg-fff p-a-20">
	        <form class="xyz-tab layui-form" id="form">
	            <div class="xyz-tab-item">
	                <div class="item-title">移动端域名</div>
	                <div class="layui-input-inline">
	                    <input type="text" name="domain" required value="<?php echo $res['domain']??''; ?>" placeholder="" autocomplete="off" class="layui-input">
						<div class="c-md m-t-10">填入网站移动端绑定的域名, 例如: m.wpxyz.net（不带https/http）</div>
	                </div>
	            </div>
	            <div class="xyz-tab-item">
	            	<div class="item-title">移动端主题</div>
	                <div class="layui-input-inline">
	                    <select name="theme" lay-verify="required" lay-search="">
	                        <option value="">选择主题</option>
	                        <?php 
	                        	foreach (wp_get_themes() as $theme){
	                                if($theme["Template"] == $res['theme']){
	                                    echo '<option value="'.$theme["Template"].'" selected="" >'.$theme["Name"].'</option>';
	                                }else{
	                                    echo '<option value="'.$theme["Template"].'">'.$theme["Name"].'</option>';
	                                }
	                            }
	                        ?>
	                    </select>
						<div class="c-md m-t-10">选择移动端对应域名</div>
	                </div>
	            </div>
				<div class="xyz-tab-item">
				    <div class="item-title">注意事项</div>
				    <div class="layui-input-inline">
						<div class="c-md m-t-10">如果您的站点<b class="c-dg">没有独立的移动端</b>，请不要使用该功能！</div>
				    </div>
				</div>
	            <div class="layui-form-item">
	                <button type="button" class="layui-btn" id="submit">保存</button>
	                <button type="button" class="layui-btn" style="background-color: #FF5722;" id="del">清空</button>
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
            let datas = $("#form").serializeArray();
            send_request(apiUrl+'xyz/theme/save',datas,function (res) {
                layer.msg('保存成功')
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })

        $('#del').click(function () {
            send_request(apiUrl+'xyz/theme/del',{},function (res) {
                parent.layer.msg('数据已清空', {time: 2000}, function () {
                    //重新加载父页面
                    parent.location.reload();
                });
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })
        form.render();
    });

</script>