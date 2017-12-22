<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class scoreEntity extends baseEntity{
    protected $table_name='score';
    protected $fields=['id','uid','type','params','score','mark','ctime'];
}
?>
