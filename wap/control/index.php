<?php
/**
 ***/

defined('InShopNC') or exit('Access Invalid!');
class IndexControl extends WapControl{

    public function __construct(){}
    
    public function indexOp(){
        $result = Logic('period')->get_the_period();
        if($result['state']!==true){
            echo '<h1>您访问的页面不存在！</h1>';
            die;
        }
        $period_info=$result['data'];
        if($period_info['pstatus']!=1){
            echo '<h1>您访问的页面不存在！</h1>';
            die;
        }
        Tpl::output('period',$period_info);        
        $str_today=date('Y-m-d');
        Tpl::display('index');
    }
    
    public function historyOp(){
    
    }
}
