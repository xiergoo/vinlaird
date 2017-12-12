<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class periodClass extends baseClass{
    public function getEntity(){
        return baseClass::E('periodEntity');
    }
    
    public function lists(){
        $where['jtime']=['between',[dapanClass::beforeTime(),dapanClass::afterTime()]];
        $where['pstatus']=1;
        return parent::lists($where);
    }
}
?>
