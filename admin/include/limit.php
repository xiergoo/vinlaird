<?php
/**
 * 载入权限 v3-b12
 *
 * by 33hao 好商城V3  www.33hao.com 开发
 */
defined('InShopNC') or exit('Access Invalid!');
$_limit =  array(
	array('name'=>$lang['nc_config'], 'child'=>array(
		array('name'=>$lang['nc_web_set'], 'op'=>null, 'act'=>'setting'),
		array('name'=>$lang['nc_web_account_syn'], 'op'=>null, 'act'=>'account'),
		array('name'=>$lang['nc_upload_set'], 'op'=>null, 'act'=>'upload'),
		array('name'=>$lang['nc_seo_set'], 'op'=>'seo', 'act'=>'setting'),
		array('name'=>$lang['nc_pay_method'], 'op'=>null, 'act'=>'payment'),
		array('name'=>$lang['nc_message_set'], 'op'=>null, 'act'=>'message'),
		array('name'=>$lang['nc_admin_express_set'], 'op'=>null, 'act'=>'express'),
		array('name'=>'运单模板', 'op'=>null, 'act'=>'waybill'),
		//v3-b12
		array('name'=>$lang['nc_admin_area_manage'], 'op'=>null, 'act'=>'area'),
		array('name'=>$lang['nc_admin_offpay_area_set'], 'op'=>null, 'act'=>'offpay_area'),
	    array('name'=>$lang['nc_admin_clear_cache'], 'op'=>null, 'act'=>'cache'),
	    array('name'=>$lang['nc_admin_perform_opt'], 'op'=>null, 'act'=>'perform'),
	    array('name'=>$lang['nc_admin_search_set'], 'op'=>null, 'act'=>'search'),
	    array('name'=>$lang['nc_admin_log'], 'op'=>null, 'act'=>'admin_log'),
		)),
);
return $_limit;
