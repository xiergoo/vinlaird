<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class periodEntity extends baseEntity{
    protected $table_name='period';
    protected $fields=['id','type_id','pno','jtime','pstatus','dpnum','jnum','inscore','outscore','ctime'];
    
}
?>
