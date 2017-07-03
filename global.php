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