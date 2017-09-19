<?php
/**
 ***/

defined('InShopNC') or exit('Access Invalid!');
class indexControl{
    public function indexOp(){
        
    }
    
    private function __create_period(){
        $period_info = Model('period')->order('id desc')->find();
        
    }
}
