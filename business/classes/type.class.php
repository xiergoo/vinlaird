<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class typeClass extends baseClass{
    const status_enable=1;
    const status_disenable=0;
    protected $table_name='type';
    protected $fields=['id','name','enable','times','mark']; 
}
?>
