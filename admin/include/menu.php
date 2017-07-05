<?php
/**
 * 菜单 
 *
 *   开发
 */
defined('InShopNC') or exit('Access Invalid!');
/**
 * top 数组是顶部菜单 ，left数组是左侧菜单
 * left数组中'args'=>'welcome,dashboard,dashboard',三个分别为op,act,nav，权限依据act来判断
 */
$arr = array(
		'top' => array(
			0 => array(
				'args' 	=> 'dashboard',
				'text' 	=> $lang['nc_console']),
			1 => array(
				'args' 	=> 'setting',
				'text' 	=> $lang['nc_config']),
            2 => array(
                'args' 	=> 'goods',
				'text' 	=> $lang['nc_goods']),
            3 => array(
                'args' 	=> 'saler',
				'text' 	=> $lang['nc_saler']),
            4 => array(
                'args' 	=> 'factory',
				'text' 	=> $lang['nc_factory']),
		),
		'left' =>array(
			0 => array(
				'nav' => 'dashboard',
				'text' => $lang['nc_normal_handle'],
				'list' => array(
					array('args'=>'welcome,dashboard,dashboard',			'text'=>$lang['nc_welcome_page']),
				)
			),
			1 => array(
				'nav' => 'setting',
				'text' => $lang['nc_config'],
				'list' => array(
                    //array('args'=>'base,setting,setting',			'text'=>$lang['nc_web_set']),	
                    //array('args'=>'email,message,setting',			'text'=>$lang['nc_message_set']),
					array('args'=>'admin,admin,setting',			'text'=>$lang['nc_limit_manage']),
					//
					array('args'=>'clear,cache,setting',			'text'=>$lang['nc_admin_clear_cache']),
					array('args'=>'db,db,setting',			'text'=>'数据备份'),
					array('args'=>'list,admin_log,setting',			'text'=>$lang['nc_admin_log']),
				)
			),
            2 => array(
				'nav' => 'goods',
				'text' => $lang['nc_goods'],
				'list' => array(
					array('args'=>'goods,goods,goods',						'text'=>$lang['nc_goods_manage']),
				)
			),
            3 => array(
				'nav' => 'saler',
				'text' => $lang['nc_saler'],
				'list' => array(
					array('args'=>'saler,saler,saler',						'text'=>$lang['nc_saler_manage']),
				)
			),
			4 => array(
				'nav' => 'factory',
				'text' => $lang['nc_config'],
				'list' => array(
					array('args'=>'factory,factory,factory',			'text'=>$lang['nc_factory_manage']),
				)
			),
		),
);
return $arr;
?>
