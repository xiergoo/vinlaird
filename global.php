<?php

define('Environmental','.dev');
if(Environmental=='.dev'){
	error_reporting(E_ALL & ~E_NOTICE);
}else{
    ini_set("display_errors", 0);
	error_reporting(0);
}
define('BASE_ROOT_PATH',str_replace('\\','/',dirname(__FILE__)));

define('BASE_CORE_PATH',BASE_ROOT_PATH.'/core');
define('BASE_DATA_PATH',BASE_ROOT_PATH.'/data');
define('DS','/');
define('InShopNC',true);
define('StartTime',microtime(true));
define('TIMESTAMP',time());
define('DIR_ADMIN','admin');

define('DIR_RESOURCE','data/resource');
define('DIR_UPLOAD','data/upload');

define('ATTACH_PATH','attach');
define('TPL_ADMIN_NAME', 'default');

define('DEFAULT_CONNECT_SMS_TIME', 60);//倒计时时间

define('REQUEST_METHOD',$_SERVER['REQUEST_METHOD']);
define('IS_GET',        REQUEST_METHOD =='GET' ? true : false);
define('IS_POST',       REQUEST_METHOD =='POST' ? true : false);
define('IS_PUT',        REQUEST_METHOD =='PUT' ? true : false);
define('IS_DELETE',     REQUEST_METHOD =='DELETE' ? true : false);
define('IS_AJAX',       ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) ? true : false);
