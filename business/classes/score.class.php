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
    const type_send=7;
    
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
            //没有权限
            return callback(statecodeClass::SOCRE_LIMIT);
        }        
        return $this->changeScore($uid,self::type_daka,self::daka_score,'签到',0);
    }
    
    /**
     * Summary of recharge
     * @param array $params ['uid','amount']
     * @return mixed
     */
    public function recharge($params,$send=false){
        $uid=$params['uid'];
        if($uid<1){
            return callback(statecodeClass::SOCRE_UID,'',$params);
        }
        if(!userClass::I()->checkLimits($uid,userClass::limit_score_rechage)){
            //没有权限
            return callback(statecodeClass::SOCRE_LIMIT);
        }
        $amount = $params['amount'];
        if($amount<10){
            return callback(statecodeClass::SOCRE_VALUE);            
        }
        $sendAmount=0;
        if($send){
            if($amount>=100000){
                $sendAmount=$amount*0.1;
            }elseif($amount>=50000){
                $sendAmount=$amount*0.08;
            }elseif($amount>=10000){
                $sendAmount=$amount*0.05;
            }elseif($amount>=5000){
                $sendAmount=$amount*0.03;
            }elseif($amount>=1000){
                $sendAmount=$amount*0.02;
            }elseif($amount>=500){
                $sendAmount=$amount*0.01;
            }
            $this->getEntity()->beginTransaction();
            $result = $this->changeScore($uid,self::type_recharge,$amount*100,'充值',0,false);
            if($result['state']==statecodeClass::SUCCESS){
                if($sendAmount<=0){
                    $this->getEntity()->commit();
                    return $result;
                }
                $result = $this->changeScore($uid,self::type_send,$sendAmount*100,'充值送',intval($result['data']),false);
                if($result['state']==statecodeClass::SUCCESS){
                    $this->getEntity()->commit();
                    return $result;
                }else{
                    $this->getEntity()->rollback();
                    return $result;
                }
            }else{
                $this->getEntity()->rollback();
                return $result;
            }
            
        }else{
            return $this->changeScore($uid,self::type_recharge,$amount*100,'充值',0);
        }        
    }
    
    public function order($score){
        $uid=$score['uid'];
        if($uid<1){
            return callback(statecodeClass::SOCRE_UID,'',$score);
        }
        if($score['score']==0){
            return callback(statecodeClass::SOCRE_VALUE);
        }
        if($score['order_id']<1){
            return callback(statecodeClass::SOCRE_ORDER);
        }        
        if($score['score']>0){
            $score['score']=0-$score['score'];
        }
        return $this->changeScore($uid,self::type_buy,intval($score['score']),'下单',$score['order_id'],false);        
    }
    
    private function changeScore($uid,$type,$score,$mark,$params=0,$autoTrans=true){
        $autoTrans && $this->getEntity()->beginTransaction();
        $data['uid']=$uid;
        $data['type']=$type;
        $data['params']=$params;
        $data['score']=$score;
        $data['mark']=$mark;
        $data['ctime']=time();
        $scoreID = $result = $this->getEntity()->insert($data);
        if($result){
            $result = userClass::I()->exchangeSocre($uid,$score);
            if($result){
                $autoTrans && $this->getEntity()->commit();
                return callback(statecodeClass::SUCCESS,'',$scoreID);
            }else{
                $autoTrans && $this->getEntity()->rollback();
                return callback(statecodeClass::SOCRE_CHANGE_USER_SCORE_FAIL);
            }
        }else{
            $autoTrans && $this->getEntity()->rollback();
            return callback(statecodeClass::SOCRE_INSERT_DETAIL_FAIL);
        }
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
            //没有权限
            return callback(statecodeClass::SOCRE_LIMIT);
        }
        $to_uid = $score['to_uid'];
        if($to_uid<1){
            return callback(statecodeClass::SOCRE_UID2,'',$score);
        }
        if(!userClass::I()->checkLimits($uid,userClass::limit_score_in)){
            //没有权限
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
        $data['mark']='转出';
        $data['ctime']=time();
        $result=$modelScore->insert($data);
        if($result){
            $data=[];
            $data['uid']=$to_uid;
            $data['type']=self::type_out;
            $data['params']=$uid;
            $data['score']=$score['score'];
            $data['mark']='转入';
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
    //                    //不重复执行
    //                    continue;
    //                }
    //                $data['score']=$order['score']*self::score_times;
    //                $data['mark']='中　奖';
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
