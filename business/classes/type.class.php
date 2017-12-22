<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class typeClass extends baseClass{
    const status_enable=1;
    const status_disenable=0;
    /**
     * Summary of getEntity
     * @return typeEntity
     */
    public function getEntity(){
        return baseClass::E('typeEntity');
    }
}
?>
