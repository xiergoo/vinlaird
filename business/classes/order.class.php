<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class orderClass extends baseClass{    
    public function getEntity(){
        return baseClass::E('orderEntity');
    }
}
?>
