<?php
	xyz_load_scripts();
	$path  = plugin_dir_url( __DIR__ );
	$url  = esc_url_raw( rest_url() );
?>
<div class="xyz-body xyz-sitemap">
	<div class="xyz-themes">
		<div class="themes-head">
			<h3 class="m-b-15">WordPress主题</h3>
			<p class="c-md m-b-15">为您推荐各行业优质WordPress主题模板！</p>
			<a class="customized b-r-4" href="" target="_blank">个性定制</a>
		</div>
		<div class="themes-warp">
			<div class="themes-item">
				<div class="imte-box bg-fff">
					<div class="xyz-cover"></div>
					<div class="title"><a href="https://aj0.cn/zhuti/51.html" target="_blank">Qzdy主题</a></div>
					<div class="thumb">
						<a href="https://aj0.cn/zhuti/51.html" target="_blank">
							<img src="https://www.wp-xyz.com/wp-content/uploads/2023/10/16967495452023100807190545.png">
						</a>
						<span class="price free">免费</span>
					</div>
					<div class="imte-desc c-md">WordPress简约博客主题</div>
					<b class="c-sc">免费</b>
					<a class="more" href="" target="_blank">详情</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$('.themes-warp').html();
$('.themes-warp').append($('.themes-warp').html());
$('.themes-warp').append($('.themes-warp').html());
$('.themes-warp').append($('.themes-warp').html());

</script>
<style>
.xyz-themes {
	padding: 20px
}
.xyz-themes .themes-head {
	margin-bottom: 30px
}
.xyz-themes .themes-head h3 {
	font-weight: bold;
	font-size: 17px;
}
.xyz-themes .themes-head .customized {
	display: inline-block;
	background: var(--pm-c);
	color: #fff;
	padding: 8px 16px;
}
.xyz-themes .themes-warp {
	display: flex;
	flex-wrap: wrap;
	margin: 0;
	padding: 0;
	list-style: none;
	margin-left: -20px;
}
.xyz-themes .themes-item {
	width: 20%;
	box-sizing: border-box;
    max-width: 100%;
	padding-left: 20px;
	margin: 0;
	margin-bottom: 20px;
}
.xyz-themes .themes-item .imte-box {
	padding: 20px;
	border-radius: 6px;
	position: relative;
}
.xyz-themes .themes-item .title {
    font-weight: bold;
    font-size: 17px;
	margin-bottom: 20px
}
.xyz-themes .themes-item .thumb {
	overflow: hidden;
	position: relative;
	background-color: #f6f6f6;
	border-radius: 6px
}
.xyz-themes .themes-item .thumb a {
	display: block;
	padding: 20px 50px;
}
.xyz-themes .themes-item .thumb img {
	width: 100%
}
.xyz-themes .themes-item .price {
    position: absolute;
    top: 0;
    left: 0;
    margin: 10px;
    background-color: var(--sc-c);
    border-radius: 20px;
    color: #fff;
    display: inline-block;
    font-size: 13px;
    padding: 4px 8px 5px 8px;
    text-align: center;
}

.xyz-themes .themes-item .imte-desc {
    font-size: 15px;
    margin: 20px 0;
}
.xyz-themes .themes-item .item-info {
	align-items: center;
}
.xyz-themes .themes-item .more {
	position: absolute;
	right: 0;
	bottom: 0;
	background-color: var(--pm-c);
	color: #fff;
	padding: 4px 6px;
	border-radius: 4px;
	margin: 20px
}
</style>
