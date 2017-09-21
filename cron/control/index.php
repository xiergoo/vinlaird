<?php
/**
 ***/

defined('InShopNC') or exit('Access Invalid!');
class indexControl{
    
    function __construct(){
        if(date('h')!=15){
            die('die');
        }
    }
    
    public function indexOp(){
    }
    
    public function create_periodOp(){
        $result = Logic('period')->get_the_period();
    }
    
    public function get_dpresultOp(){        
        $period_info = Model('period')->where(['pstatus'=>1,'jtime'=>['eq',mktime(15,0,0)]])->find();
        $data['dpnum']=dapan::value();
        if($data['dpnum']>1000){
            $data['jnum']=$data['dpnum']*100%50;
            $data['pstatus']=2;
            Model('period')->where(['id'=>$period_info['id']])->update($data);
        }
    }
    
    public function send_prizeOp(){
        $period_info = Model('period')->where(['pstatus'=>2,'dpnum'=>['gt',0],'jtime'=>['eq',mktime(15,0,0)]])->find();
        if($period_info['id']){
            Logic('score')->luck();
        }
    }    
}
