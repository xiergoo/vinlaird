<?php

$site_url = strtolower('http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/index.php')).'/wap/index.php');
//echo $site_url;die;
include('wap/index.php');

