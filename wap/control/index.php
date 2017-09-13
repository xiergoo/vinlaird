<?php
/**
 ***/

defined('InShopNC') or exit('Access Invalid!');
class IndexControl extends WapControl{

    public function __construct(){}
    
    public function indexOp(){
        $str_today=date('Y-m-d');
        echo $str_today;
    }
    
    public function historyOp(){
    
    }
}
