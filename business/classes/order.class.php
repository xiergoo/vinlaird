<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class orderClass extends baseClass{
    /**
     * Summary of getEntity
     * @return orderEntity
     */
    public function getEntity(){
        return baseClass::E('orderEntity');
    }
    
    public function listUserOrder($uid,$is_right=0){
        $where['uid']=$uid;
        if($is_right){
            $where['is_right']=1;
        }
        return $this->lists($where);
    }
    
    public function listPeriodOrder($pid,$is_right=0){
        $where['pid']=$pid;
        if($is_right){
            $where['is_right']=1;
        }
        return $this->lists($where);
    }
    
}
?>
