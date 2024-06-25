<?php
namespace App;



/**
 * 百度地址
 * Class BaiduSitemap
 * @package App
 */
class BaiduSitemap
{
	/**
	 * 域名
	 * @var mixed|void|null
	 */
	protected $pc_domain = null;
	protected $m_domain = null;
	
	/**
	 * 文章数量
	 * @var int
	 */
	protected $limit = 5000;
	
	public function __construct()
	{
		//设置无限期响应时间
		set_time_limit(0);
		ini_set("max_execution_time", 0);
		ini_set('memory_limit', '1024M');
		
		$this->pc_domain = get_option('home');
		
		$parse = parse_url($this->pc_domain);
		
		$option = unserialize(get_option("xyz-theme"));
		if($option)
			$this->m_domain = $parse['scheme'].'://'.$option['domain'];
	}
	
	/**
	 * 初示数据
	 * @param string $type
	 */
	public function init($type='xml')
	{
		global $wpdb;
		
		$options = get_option( 'xyz-sitemap', [] );
		if(empty($options))
			return;
		
		$this->limit = isset($options['num']) && $options['num']>1000 ? $options['num']:5000;
		
		// 查看用户设置关闭
		$options = unserialize($options);
		
		// 保存链接
		$urls = array();
		
		// 首页
		if($this->pc_domain && isset($options['page_index'])){
			$urls[] = [
				'url' => $this->pc_domain,
				'date' => date('Y-m-d H:i:s')
			];
		}
		
		// 列表页面链接
		$category = get_categories([
			'orderby' => 'name',
			'hide_empty' => false, //显示所有分类
			'order' => 'DESC'
		]);
		if($category && isset($options['page_list'])){
			foreach ($category as $item){
				$urls[] = [
					'url' => get_category_link($item->term_id),
					'date' => date('Y-m-d H:i:s')
				];
			}
		}
		
		// 标签页面链接
		$args = get_tags();
		if($args && isset($options['page_tag'])) {
			foreach ($args as $arg) {
				$urls[] = [
					'url' => get_tag_link($arg),
					'date' => date('Y-m-d H:i:s')
				];
			}
		}
		
		// 单页面链接
		$pages = $wpdb->get_results("select ID,post_date from $wpdb->posts where post_type='page' and  post_status='publish'");
		if($pages  && isset($options['page_page']) ){
			foreach ($pages as $page){
				$urls[] = [
					'url' => get_permalink($page->ID),
					'date' => $page->post_date
				];
			}
		}
		
		// 详细页面链接
		$posts = $wpdb->get_results("select ID,post_date from $wpdb->posts where post_type='post' and  post_status='publish'");
		if($posts && isset($options['page_art']) ){
			
			foreach ($posts as $post) {
				$urls[] = [
					'url' => get_permalink($post->ID),
					'date' => $post->post_date
				];
			}
		}
		
		/**
		 *  生成xml 地图
		 */
		if($type=='xml'){
			$this->sitemap_xml_index($urls);
			$this->sitemap_xml($urls);
		}
		
		/**
		 * 生成txt 地图
		 */
		if($type=='txt'){
			$this->sitemap_txt($urls);
		}

	}
	
	
	// ======================= xml - txt 地图 =====================
	
	protected function sitemap_xml($data)
	{
		$platform = array('pc'=>$this->pc_domain,'m'=>$this->m_domain);
		
		$res = array_chunk($data,$this->limit);
		
		foreach ($platform as $_index=>$domain) {
			if (empty($domain))
				continue;
			
			foreach ($res as $k=>$re){
				
				$content = "<urlset>".PHP_EOL;
				foreach ($re as $item){
					
					$content.="\t<url>".PHP_EOL;
					$content.="\t\t<loc>".(str_replace($this->pc_domain,$domain,$item['url']))."</loc>".PHP_EOL;
					
					if($_index=='m')
						$content.="\t\t<mobile:mobile type='mobile'/>".PHP_EOL;
					
					$content.="\t\t<priority>0.8</priority>".PHP_EOL;
					$content.="\t\t<lastmod>".$item['date']."</lastmod>".PHP_EOL;
					$content.="\t\t<changefreq>daily</changefreq>".PHP_EOL;
					$content.="\t</url>".PHP_EOL;
				}
				
				$content .= "</urlset>";
				
				$path = ABSPATH.'sitemap_'.($k+1).'.xml';
				if($_index=='m')
					$path = ABSPATH.'m_sitemap_'.($k+1).'.xml';
				
				file_put_contents($path,$content);
			}
		}
	}
	
	/**
	 * 生成地图首页索引
	 * @param $data
	 */
	protected function sitemap_xml_index($data)
	{
		$platform = array('pc'=>$this->pc_domain,'m'=>$this->m_domain);
		
		$res = array_chunk($data,$this->limit);
		
		foreach ($platform as $_index=>$item)
		{
			if(empty($item))
				continue;
			
			$content = '<sitemapindex>'.PHP_EOL;
			for($i=0;$i<count($res);$i++){
				$content.="\t<sitemap>".PHP_EOL;
				$content.="\t\t<loc>{$item}/sitemap_".($i+1).".xml</loc>".PHP_EOL;
				$content.="\t\t<lastmod>".date('Y-m-d H:i:s')."</lastmod>".PHP_EOL;
				$content.="\t</sitemap>".PHP_EOL;
			}
			
			$content .= '</sitemapindex>';
			
			$path = ABSPATH.'sitemap.xml';
			
			if($_index=='m')
				$path = ABSPATH.'m_sitemap.xml';
			
			file_put_contents($path,$content);
		}
		
	}
	
	/**
	 * 生成地图txt
	 * @param $data
	 */
	protected function sitemap_txt($data)
	{
		$res = array_chunk($data,$this->limit);
		
		foreach ($res as $k=>$re)
		{
			$content = "";
			
			foreach ($re as $item){
				$content .= $item['url'];
				if($this->m_domain)
					$content .= "\t".(str_replace($this->pc_domain,$this->m_domain,$item['url']));
				
				$content .= PHP_EOL;
			}
			
			$path = ABSPATH.'sitemap'.($k+1).'.txt';
			
			file_put_contents($path,$content);
		}
	}
}