<?php
define('MODULES','cron');
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));
if (!@include(dirname(dirname(__FILE__)).'/global.php')) exit('global.php isn\'t exists!');
if (!@include(BASE_CORE_PATH.'/vinlaird.php')) exit('vinlaird.php isn\'t exists!');

if (!@include(BASE_PATH.'/control/control.php')) exit('control.php isn\'t exists!');

Base::run();
?>