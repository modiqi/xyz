<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );
	$nonce = wp_create_nonce( 'wp_rest' );
	$push = get_option( 'xyz-push');
	$cfg = array();
	if(!empty($push)){
		$cfg = (array) unserialize($push);
	}
?>
<div class="xyz-body xyz-push">
	<div class="layui-tab layui-tab-card b-a">
		<ul class="layui-tab-title">
			<li class="layui-this c-md">百度推送</li>
			<li>百度批量推送</li>
			<li>必应推送</li>
			<li>必应批量推送</li>
            <li>神马推送</li>
            <li>神马批量推送</li>
			<li>360推送</li>
			<li>360批量推送</li>
			<li>头条推送</li>
			<li>头条批量推送</li>
		</ul>
		<div class="layui-tab-content bg-fff p-a-20">
			<div class="layui-tab-item layui-show">
				<form class="layui-form xyz-tab" id="form">
					<div class="xyz-tab-item">
						<div class="item-title">百度推送Token</div>
						<div class="layui-col-md3">
	                        <input type="text" name="token" required placeholder="请输入token" value="<?php if(isset($cfg['baidu_push'])){ echo $cfg['baidu_push']['token'];}?>" class="layui-input">
							<div class="c-md m-t-20">请填写百度推送token</div>
						</div>
					</div>
	                <div class="xyz-tab-item">
						<div class="item-title">自动推送</div>
						<div class="layui-col-md3">
	                        <input type="checkbox" <?php if(isset($cfg['baidu_push']['baidu_switch']) && $cfg['baidu_push']['baidu_switch']=='on'){ echo 'checked';}?> name="baidu_switch" lay-skin="switch"  lay-text="ON|OFF">
	                        <div class="c-md m-t-20">开启自动推送（发布文章自动推送百度搜索引擎）</div>
	                    </div>
	                </div>
					<input type="hidden" name="push_type" value="baidu_push"/>
					<div class="xyz-tab-item">
						<button type="button" class="layui-btn" id="submit">保存</button>
					</div>
				</form>
			</div>
			<div class="layui-tab-item">
			    <form class="layui-form xyz-tab" id="form2">
			        <div class="xyz-tab-item">
			        	<div class="item-title">百度批量推送</div>
			            <div class="layui-col-md3">
			                <textarea type="textarea" name="urls" placeholder="" class="layui-textarea"></textarea>
			                <div class="c-md m-t-20">批量输入网址（一行一条,不超过1000）</div>
			            </div>
			        </div>
			        <input type="hidden" name="push_type" value="batch_push"/>
                    <input type="hidden" name="site_type" value="baidu_push"/>
			        <div class="layui-form-item m-t-20 m-l-20 br-last">
			            <button type="button" class="layui-btn" id="submit2">提交</button>
			        </div>
			    </form>
			</div>
			<div class="layui-tab-item">
			    <form class="layui-form xyz-tab" id="form3">
			    	<div class="xyz-tab-item">
						<div class="item-title">必应推送API</div>
			            <div class="layui-col-md3">
			                <input type="text" name="token" required placeholder="请输入密钥" value="<?php if(isset($cfg['bing_push'])){ echo $cfg['bing_push']['token'];}?>" class="layui-input">
			            	<div class="c-md m-t-20">请填写必应站长管理API<a href="https://www.wp-xyz.com/xyz/56.html" target="_blank">（点击查看获取API教程!）</a></div>
			            </div>
			        </div>
			        <div class="xyz-tab-item">
			        	<div class="item-title">自动推送</div>
			        	<div class="layui-col-md3">
			                <input type="checkbox" <?php if(isset($cfg['bing_push']['bing_switch']) && $cfg['bing_push']['bing_switch']=='on'){ echo 'checked';}?> name="bing_switch" lay-skin="switch"  lay-text="ON|OFF">
			                <div class="c-md m-t-20">开启自动推送（发布文章自动推送必应搜索引擎）</div>
			            </div>
			        </div>
			        <input type="hidden" name="push_type" value="bing_push"/>
			        <div class="xyz-tab-item">
			            <button type="button" class="layui-btn" id="submit3">保存</button>
			        </div>
			    </form>
			</div>
			<div class="layui-tab-item">
			    <form class="layui-form xyz-tab" id="form4">
			        <div class="xyz-tab-item">
			        	<div class="item-title">必应批量推送</div>
			            <div class="layui-col-md3">
			                <textarea type="textarea" name="urls" placeholder="" class="layui-textarea"></textarea>
			                <div class="c-md m-t-20">批量输入网址（一行一条,不超过1000）</div>
			            </div>
			        </div>
			        <input type="hidden" name="push_type" value="batch_push"/>
			        <input type="hidden" name="site_type" value="bing_push"/>
			        <div class="layui-form-item m-t-20 m-l-20 br-last">
			            <button type="button" class="layui-btn" id="submit4">提交</button>
			        </div>
			    </form>
			</div>
            <div class="layui-tab-item">
                <form class="layui-form xyz-tab" id="form5">
                    <div class="xyz-tab-item">
                        <div class="item-title">神马PC端Authkey</div>
                        <div class="layui-col-md3">
                            <input type="text" name="token" required placeholder="请输入token" value="<?php if(isset($cfg['sm_push'])){ echo $cfg['sm_push']['token'];}?>" class="layui-input">
                            <div class="c-md m-t-20">请填写神马pc token</div>
                        </div>
                    </div>
                    <div class="xyz-tab-item">
                        <div class="item-title">神马m端Authkey</div>
                        <div class="layui-col-md3">
                            <input type="text" name="m_token" required placeholder="请输入token" value="<?php if(isset($cfg['sm_push']['m_token'])){ echo $cfg['sm_push']['m_token'];}?>" class="layui-input">
                            <div class="c-md m-t-20">请填写神马m token<span class="c-dg">（没有m端就填写PC端的Authkey）</span></div>
                        </div>
                    </div>
                    <div class="xyz-tab-item">
                        <div class="item-title">神马账号</div>
                        <div class="layui-col-md3">
                            <input type="text" name="user_name" required placeholder="请输入账号"  value="<?php if(isset($cfg['sm_push'])){ echo $cfg['sm_push']['user_name'];}?>"  class="layui-input">
                            <div class="c-md m-t-20">请填写神马账号</div>
                        </div>
                    </div>
                    <div class="xyz-tab-item">
                        <div class="item-title">自动推送</div>
                        <div>
                            <input type="checkbox" <?php if(isset($cfg['sm_push']['sm_switch']) && $cfg['sm_push']['sm_switch']=='on'){ echo 'checked';}?> name="sm_switch" lay-skin="switch"  lay-text="ON|OFF">
                            <div class="c-md m-t-20">开启自动推送（发布文章自动推送神马搜索引擎）</div>
                        </div>
                    </div>
                    <input type="hidden" name="push_type" value="sm_push"/>
                    <div class="xyz-tab-item">
                        <button type="button" class="layui-btn" id="submit5" >保存</button>
                    </div>
                </form>
            </div>
            <div class="layui-tab-item">
                <form class="layui-form xyz-tab" id="form6">
                    <div class="xyz-tab-item">
                        <div class="item-title">神马批量推送</div>
                        <div class="layui-col-md3">
                            <textarea type="textarea" name="urls" placeholder="" class="layui-textarea"></textarea>
                            <div class="c-md m-t-20">批量输入网址(一行一条,不超过1000)</div>
                        </div>
                    </div>
                    <input type="hidden" name="push_type" value="batch_push"/>
                    <input type="hidden" name="site_type" value="sm_push"/>
                    <div class="layui-form-item m-t-20 m-l-20 br-last">
                        <button type="button" class="layui-btn" id="submit6">提交</button>
                    </div>
                </form>
            </div>
			<div class="layui-tab-item">
				<div class="xyz-cover"></div>
                <form class="layui-form xyz-tab" id="so_push">
					<div class="xyz-tab-item">
						<div class="item-title">360平台账号</div>
						<div class="layui-col-md3">
							<input type="text" name="account" required placeholder="请输入账号" value="" class="layui-input">
							<div class="c-md m-t-20">请填写360账号</div>
						</div>
					</div>
                	<div class="xyz-tab-item">
						<div class="item-title">360cookie</div>
                        <div class="layui-col-md3">
                            <input type="text" name="cookie" required placeholder="请输入cookie" value="" class="layui-input">
                        	<div class="c-md m-t-20">请填写360cookie</div>
                        </div>
                    </div>
                    <div class="xyz-tab-item">
                    	<div class="item-title">360site_id</div>
                        <div class="layui-col-md3">
                            <input type="text" name="site_id" required placeholder="请输入site_id" value="" class="layui-input">
                            <div class="c-md m-t-20">请填写360站点的site_id </div>
                        </div>
                    </div>
                    <div class="xyz-tab-item">
                    	<div class="item-title">自动推送</div>
                        <div>
                            <input type="checkbox" checked name="sogou_switch" lay-skin="switch"  lay-text="ON|OFF">
                            <div class="c-md m-t-20">开启自动推送(发布文章自动推送360搜索引擎)</div>
                        </div>
                    </div>
                    <input type="hidden" name="push_type" value="sogou_push"/>
                    <div class="xyz-tab-item">
                        <button type="button" class="layui-btn" id="submit3">保存</button>
                    </div>
                </form>
            </div>
			<div class="layui-tab-item">
				<div class="xyz-cover"></div>
			    <form class="layui-form xyz-tab" id="so_push_batch">
			        <div class="xyz-tab-item">
			        	<div class="item-title">360批量推送</div>
			            <div class="layui-col-md3">
			                <textarea type="textarea" name="urls" placeholder="" class="layui-textarea"></textarea>
			                <div class="c-md m-t-20">批量输入网址(一行一条,不超过1000)</div>
			            </div>
			        </div>
			        <input type="hidden" name="push_type" value="batch_push"/>
			        <div class="layui-form-item m-t-20 m-l-20 br-last">
			            <button type="button" class="layui-btn" id="submit2">提交</button>
			        </div>
			    </form>
			</div>
			<div class="layui-tab-item">
				<div class="xyz-cover"></div>
			    <form class="layui-form xyz-tab" id="tt_push">
					<div class="xyz-tab-item">
						<div class="item-title">头条平台账号</div>
						<div class="layui-col-md3">
							<input type="text" name="account" required placeholder="请输入账号" value="" class="layui-input">
							<div class="c-md m-t-20">请填写头条账号</div>
						</div>
					</div>
			    	<div class="xyz-tab-item">
						<div class="item-title">头条cookie</div>
			            <div class="layui-col-md3">
			                <input type="text" name="cookie" required placeholder="请输入cookie" value="" class="layui-input">
			            	<div class="c-md m-t-20">请填写头条cookie</div>
			            </div>
			        </div>
			        <div class="xyz-tab-item">
			        	<div class="item-title">头条site_id</div>
			            <div class="layui-col-md3">
			                <input type="text" name="site_id" required placeholder="请输入site_id" value="" class="layui-input">
			                <div class="c-md m-t-20">请填写头条站点的site_id </div>
			            </div>
			        </div>
			        <div class="xyz-tab-item">
			        	<div class="item-title">自动推送</div>
			            <div>
			                <input type="checkbox" checked name="sogou_switch" lay-skin="switch"  lay-text="ON|OFF">
			                <div class="c-md m-t-20">开启自动推送(发布文章自动推送头条搜索引擎)</div>
			            </div>
			        </div>
			        <input type="hidden" name="push_type" value="sogou_push"/>
			        <div class="xyz-tab-item">
			            <button type="button" class="layui-btn" id="tt_push">保存</button>
			        </div>
			    </form>
			</div>
			<div class="layui-tab-item">
				<div class="xyz-cover"></div>
			    <form class="layui-form xyz-tab" id="tt_push_batch">
			        <div class="xyz-tab-item">
			        	<div class="item-title">头条批量推送</div>
			            <div class="layui-col-md3">
			                <textarea type="textarea" name="urls" placeholder="" class="layui-textarea"></textarea>
			                <div class="c-md m-t-20">批量输入网址(一行一条,不超过1000)</div>
			            </div>
			        </div>
			        <input type="hidden" name="push_type" value="batch_push"/>
			        <div class="layui-form-item m-t-20 m-l-20 br-last">
			            <button type="button" class="layui-btn" id="tt_push_batch">提交</button>
			        </div>
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

        //百度账号添加
        $("#submit").click(function(){
            let xyz_push = $("#form").serializeArray();
            send_request(apiUrl+'xyz/push/save',xyz_push,function (res) {
                layer.msg('保存成功')
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })

		//百度批量推送
        $("#submit2").click(function(){
            let xyz_push = $("#form2").serializeArray();
            send_request(apiUrl+'xyz/push/save',xyz_push,function (res) {
                layer.msg(res.msg)
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })
		
		//必应账号添加
        $("#submit3").click(function(){
            let xyz_push = $("#form3").serializeArray();
            send_request(apiUrl+'xyz/push/save',xyz_push,function (res) {
                layer.msg('保存成功')
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })
        
        //必应批量推送
        $("#submit4").click(function(){
            let xyz_push = $("#form4").serializeArray();
            send_request(apiUrl+'xyz/push/save',xyz_push,function (res) {
                layer.msg(res.msg)
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })

        //神马账号添加
        $("#submit5").click(function(){
            let xyz_push = $("#form5").serializeArray();
            send_request(apiUrl+'xyz/push/save',xyz_push,function (res) {
                layer.msg('保存成功')
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })
		
        //神马批量推送
        $("#submit6").click(function(){
            let xyz_push = $("#form6").serializeArray();
            send_request(apiUrl+'xyz/push/save',xyz_push,function (res) {
                layer.msg(res.msg)
            },function (res) {
                layer.msg(res.msg)
            },wp_nonce)
        })
        form.render();
    });

</script>