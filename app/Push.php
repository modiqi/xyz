<?php
namespace App;

class Push
{
	/**
	 * @param $urls
	 * @param $type  百度 必站
	 */
	public function batch($urls,$type)
	{
		switch ($type)
		{
			case 'baidu_push':
				$result = baidu_push($urls,'batch_push');
				$re = json_decode($result, true);
				$first = $urls[0];
				$p = 'www';
				if( !strpos($first,'//www.') )
					$p = 'm';
				// 推送成功
				if (isset($re['success'])) {
					if($p=='www'){
						//设置pc端剩余配额
						update_option('xyz_baidu_push_pc_total', $re['remain'] ?? 0);
					}else{
						//设置m端剩余配额
						update_option('xyz_baidu_push_m_total', $re['remain'] ?? 0);
					}
					$msg = '推送成功，剩余'.$re['remain'].'配额！';
				}else{
					$msg = '推送失败';
				}
				break;
			case 'bing_push':
				$result = bing_push($urls,'batch_push');
				$first = $urls[0];
				$p = 'www';
				if( !strpos($first,'//www.') )
					$p = 'm';
				// 推送成功
				if (isset($result['success']) && $result['success'] ==200 ) {
					$xyz_bing_push_rest = unserialize(get_option('xyz_bing_push_rest',serialize([])));
					if(!isset($xyz_bing_push_rest['date']) || $xyz_bing_push_rest['date'] != date('Y-m-d') ){
						$xyz_bing_push_rest['date'] = date('Y-m-d');
						$xyz_bing_push_rest['push_pc_total'] = 0;
						$xyz_bing_push_rest['push_m_total'] = 0;
					}
					if($p=='www'){
						$xyz_bing_push_rest['push_pc_total'] += count($urls);
						//设置pc端剩余配额
						update_option('xyz_bing_push_rest', serialize($xyz_bing_push_rest));
						$total = $xyz_bing_push_rest['push_pc_total'];
					}else{
						$xyz_bing_push_rest['push_m_total'] += count($urls);
						//设置pc端剩余配额
						update_option('xyz_bing_push_rest', serialize($xyz_bing_push_rest));
						$total = $xyz_bing_push_rest['push_m_total'];
					}
					$msg = '推送成功,今天推送: '.$total.'';
				}else{
					$msg = '推送失败';
				}
				break;
			case 'sm_push':
				$result = sm_push($urls,'batch_push');
				$first = $urls[0];
				$p = 'www';
				if( !strpos($first,'//www.') )
					$p = 'm';
				// 推送成功
				if (isset($result['success']) && $result['success'] ==200 ) {
					$xyz_sm_push_rest = unserialize(get_option('xyz_sm_push_rest',serialize([])));
					if(!isset($xyz_sm_push_rest['date']) || $xyz_sm_push_rest['date'] != date('Y-m-d') ){
						$xyz_sm_push_rest['date'] = date('Y-m-d');
						$xyz_sm_push_rest['push_pc_total'] = 0;
						$xyz_sm_push_rest['push_m_total'] = 0;
					}
					if($p=='www'){
						$xyz_sm_push_rest['push_pc_total'] += count($urls);
						//设置pc端剩余配额
						update_option('xyz_sm_push_rest', serialize($xyz_sm_push_rest));
						$total = $xyz_sm_push_rest['push_pc_total'];
					}else{
						$xyz_sm_push_rest['push_m_total'] += count($urls);
						//设置pc端剩余配额
						update_option('xyz_sm_push_rest', serialize($xyz_sm_push_rest));
						$total = $xyz_sm_push_rest['push_m_total'];
					}
					$msg = '推送成功,今天推送: '.$total.'';
				}else{
					$msg = '推送失败';
				}
				break;
		}
		return $msg;
	}
	
	/**
	 * 记录当天收录信息
	 *
	 */
	public function push_current()
	{
	
	}
}
