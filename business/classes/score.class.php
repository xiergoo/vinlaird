<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class scoreClass extends baseClass{    
    /**
     * Summary of getEntity
     * @return scoreEntity
     */
    public function getEntity(){
        return baseClass::E('scoreEntity');
    }    
    const type_recharge=1;
    const type_buy=2;
    const type_daka=3;
    const type_luck=4;
    const type_in=5;
    const type_out=6;
    
    const score_times=40;
    
    const daka_score=10;
    /**
     * Summary of daka
     * @param array $score ['uid']
     * @return mixed
     */
    public function daka($score){
        $uid=$score['uid'];
        if($uid<1){
            return callback(statecodeClass::SOCRE_UID,'',$score);
        }
        if(!userClass::I()->checkLimits($uid,userClass::limit_daka)){
            //û��Ȩ��
            return callback(statecodeClass::SOCRE_LIMIT);
        }
        $data['uid']=$uid;
        $data['type']=self::type_daka;
        $data['params']=0;
        $data['score']=self::daka_score;
        $data['mark']='ǩ��';
        $data['ctime']=time(); 
        return $this->getEntity()->insert($data);
    }
    
    /**
     * Summary of recharge
     * @param array $score ['uid','score']
     * @return mixed
     */
    public function recharge($score){
        $uid=$score['uid'];
        if($uid<1){
            return callback(statecodeClass::SOCRE_UID,'',$score);
        }
        if(!userClass::I()->checkLimits($uid,userClass::limit_score_rechage)){
            //û��Ȩ��
            return callback(statecodeClass::SOCRE_LIMIT);
        }
        if($score['score']<1){
            return callback(statecodeClass::SOCRE_VALUE);            
        }  
        $data['uid']=$uid;
        $data['type']=self::type_recharge;
        $data['params']=0;
        $data['score']=$score['score'];
        $data['mark']='��ֵ';
        $data['ctime']=time();
        return $this->getEntity()->insert($data);
    }
    
    /**
     * Summary of score_exc
     * @param array $score ['uid','to_uid','score']
     * @return mixed
     */
    public function scoreExc($score){
        $uid=$score['uid'];
        if($uid<1){
            return callback(statecodeClass::SOCRE_UID,'',$score);
        }
        if(!userClass::I()->checkLimits($uid,userClass::limit_score_out)){
            //û��Ȩ��
            return callback(statecodeClass::SOCRE_LIMIT);
        }
        $to_uid = $score['to_uid'];
        if($to_uid<1){
            return callback(statecodeClass::SOCRE_UID2,'',$score);
        }
        if(!userClass::I()->checkLimits($uid,userClass::limit_score_in)){
            //û��Ȩ��
            return callback(statecodeClass::SOCRE_LIMIT);
        }
        $score['score'] = abs($score['score']);
        if($score['score']<10000){
            return callback(statecodeClass::SOCRE_COUNT);
        }        
        $scoreValue = $this->getScore($uid);
        if($scoreValue<$score['score']){
            return callback(statecodeClass::SOCRE_LESS);            
        }        
        $modelScore = $this->getEntity();
        $modelScore->beginTransaction();        
        $data=[];
        $data['uid']=$uid;
        $data['type']=self::type_out;
        $data['params']=$to_uid;
        $data['score']=0-$score['score'];
        $data['mark']='ת��';
        $data['ctime']=time();
        $result=$modelScore->insert($data);
        if($result){
            $data=[];
            $data['uid']=$to_uid;
            $data['type']=self::type_out;
            $data['params']=$uid;
            $data['score']=$score['score'];
            $data['mark']='ת��';
            $data['ctime']=time();
            $result=$modelScore->insert($data);
        }
        if($result){
            $modelScore->commit();
            return callback(statecodeClass::SUCCESS);
        }else{
            $modelScore->rollback();
            return callback(statecodeClass::ERROR);
        }
    }
    
    public function getScore($uid){
        $score=0;
        if($uid>0){
            $score = $this->getEntity()->where(['uid'=>$uid])->sum('score');
        }
        return intval($score);
    }
    
    public function listScore($uid){
        return $this->getEntity()->where(['uid'=>$uid])->order('id desc')->page(20)->select();
    }
    
    //public function sendLuckScore(){
    //    $model = Model();
    //    $model_period = periodClass::I()->getEntity();
    //    $model_order = orderClass::I()->getEntity();        
    //    $model_score = scoreClass::I()->getEntity();
    //    $list = $model_period->where(['pstatus'=>2])->select();
    //    foreach ($list as $period)
    //    {
    //        while($list_order = $model_order->where(['pid'=>$period['id'],'num'=>$period['jnum'],'is_right'=>0])->limit(1000)->select()){
    //            foreach ($list_order as $order)
    //            {
    //                $data=[];
    //                $data['uid']=$order['uid'];
    //                $data['type']=self::score_type_luck;
    //                $data['params']=$order['id'];
    //                $has_send = $model_score->where($data)->find();
    //                if($has_send){
    //                    //���ظ�ִ��
    //                    continue;
    //                }
    //                $data['score']=$order['score']*self::score_times;
    //                $data['mark']='�С���';
    //                $data['ctime']=TIMESTAMP;
    //                $model->beginTransaction();
    //                $result = $model_score->insert($data);
    //                if($result){
    //                    $result = $model_order->where(['id'=>$order['id']])->update(['is_right'=>1,'stime'=>TIMESTAMP]);
    //                }
    //                if($result){
    //                    $model->commit();
    //                }else{
    //                    $model->rollback();
    //                }
    //            }                
    //        }
    //    }
    //}
    
}
?>