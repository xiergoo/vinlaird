<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class orderEntity extends baseEntity{
    protected $table='order';
    protected $fields=['id','uid','pid','num','score','ctime','is_right','stime'];   
}
?>
