<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class orderClass extends baseClass{
    protected $table_name='order';
    protected $fields=['id','uid','pid','num','score','ctime','is_right','stime'];
    
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
