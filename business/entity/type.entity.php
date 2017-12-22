<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class typeEntity extends baseEntity{
    protected $table_name='type';
    protected $fields=['id','name','enable','times','mark'];   
}
?>
