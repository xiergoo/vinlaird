<?php
/**
 ***/

defined('InShopNC') or exit('Access Invalid!');
class IndexControl extends WapControl{

    private $times_arr=[100,1000,2000,5000,10000];
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
        Tpl::output('times',$this->times_arr);
        Tpl::output('period',$period_info);        
        $str_today=date('Y-m-d');
        Tpl::display('index');
    }
    
    public function commitOp(){
        if(!Security::checkToken()){
            output_json(99,'刷新后再试');
        }
        $pid=intval($_POST['pid']);
        $times=intval($_POST['times']);
        $score=intval($_POST['score']);
        $nums = trim($_POST['score'],',');
        $nums = explode(',',$nums);
        if(in_array($times,$this->times_arr)){
        }
        output_json(1,$pid,$_POST);
    }
    
    public function historyOp(){
    
    }
}
