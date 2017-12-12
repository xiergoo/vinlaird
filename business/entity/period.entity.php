<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class periodEntity extends baseEntity{
    protected $table='period';
    protected $fields=['id','type_id','pno','jtime','pstatus','dpnum','jnum','inscore','outscore','ctime'];
    
}
?>
