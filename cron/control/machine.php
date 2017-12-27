<?php
/**
 ***/

defined('InShopNC') or exit('Access Invalid!');
class machineControl extends BaseControl{
    
    public function indexOp(){
        try
        {
            $key='cronmachineindex';
            $flag = rcache($key);
            if($flag){
                return;
            }
            wcache($key,1,'',600);
            
            $listScore=[100,100,100,100,100,1000,1000,1000,1000,1000,1000,2000,2000,2000,2000,2000,2000,5000,5000,5000,10000];
            $listPeriod=periodClass::I()->listsing();
            $period = $listPeriod[mt_rand(0,count($listPeriod)-1)];
            if(TIMESTAMP-$period['ctime']<1000){
                return;
            }
            
            $key2='cronmachineindex_'.$period['id'];
            $next = rcache($key2);
            $orderInfo = orderClass::I()->where(['pid'=>$period['id']])->order('id desc')->find();
            if(TIMESTAMP-$orderInfo['ctime']<$next){                    
                return;
            }
            $data['uid']=$this->getUid();
            $data['pid']=$period['id'];
            $data['num']=mt_rand(0,49);
            $data['score']=$listScore[mt_rand(0,count($listScore)-1)];
            $data['is_right']=0;
            $data['stime']=0;
            $data['ctime']=TIMESTAMP;
            $result = orderClass::I()->insert($data);           
            if($result){
                wcache($key2,TIMESTAMP+mt_rand(1000,3000),'',86400);
            }
        }
        catch (Exception $exception)
        {
            $this->log($exception);
        }
    }
    
    private function getUid(){
        return mt_rand(1000,1300);
    }
}
