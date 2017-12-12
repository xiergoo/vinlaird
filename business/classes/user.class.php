<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class userClass extends baseClass{    
    public function getEntity(){
        return baseClass::E('userEntity');
    }
}
?>
