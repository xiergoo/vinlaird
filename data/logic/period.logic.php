<?php
defined('InShopNC') or exit('Access Invalid!');

class periodLogic {
    public function get_the_period(){
        $result=true;
        $week=date('w');
        $start_time=strtotime('today');
        if($week==6){
            $start_time+=86400*2;
        }elseif($week==0){
            $start_time+=86400;
        }
        $end_time=$start_time+86399; 
        $model_period = Model('period');       
        $period_info = $model_period->where(['jtime'=>['between',$start_time,$end_time]])->find();
        if($period_info['id']<1){
            $pno=$model_period->field('max(pno) pno')->find();
            $data['pno']=$pno['pno']>=100?$pno['pno']+1:'100';//从100期开始
            $data['pstatus']=1;
            $data['dpnum']=0;
            $data['jnum']=0;
            $data['inscore']=0;
            $data['outscore']=0;
            $data['ctime']=TIMESTAMP;
            $h=date('h');
            $jtime=mktime(15,0,0);
            if(in_array($week,[1,2,3,4,5])){
                if($h>=15){
                    $jtime+86400;
                }
            }elseif($week==6){
                $jtime+=86400*2;
            }elseif($week==0){
                $jtime+=86400;
            }
            $data['jtime']=$jtime;
            $result = $model_period->insert($data);
            if($result){
                $data['id']=$result;
                $period_info=$data;
            }
        }
        if($result){
            return callback(true,'',$period_info);
        }else{
            return callback(false,'',$period_info);
        }
    }
    
    public function list_period(){
        $key = md5('periodLogic_list_period');
        $list = rcache($key);
        if(!$list){            
            $list = Model('period')->where(['pstatus'=>['in',[2,3]]])->order('id desc')->limit(30)->select();
            if($list){
                if(date('h')<15){
                    $cache_time=mktime(15)-TIMESTAMP;
                }else{
                    $cache_time=mktime(15,0,0,date('n')+1)-TIMESTAMP;
                }
                wcache($key,$list);
            }
        }
        return $list;
    }
}