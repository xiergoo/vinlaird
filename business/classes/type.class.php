<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class typeClass extends baseClass{    
    public function getEntity(){
        return baseClass::E('typeEntity');
    }
}
?>