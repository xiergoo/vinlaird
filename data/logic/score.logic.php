<?php
defined('InShopNC') or exit('Access Invalid!');

class scoreLogic {
    const score_type_recharge=1;
    const score_type_buy=2;
    const score_type_daka=3;
    const score_type_luck=4;
    const score_type_in=5;
    const score_type_out=6;
    
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
            return callback(statecode::LOGIC_SOCRE_UID,'',$score);
        }
        if(!Logic('user')->limits($uid,userLogic::limit_daka)){
            //没有权限
            return callback(statecode::LOGIC_SOCRE_LIMIT);
        }
        $data['uid']=$uid;
        $data['type']=self::score_type_daka;
        $data['params']=0;
        $data['score']=self::daka_score;
        $data['mark']='签到';
        $data['ctime']=TIMESTAMP;
        $result = Model('score')->insert($data);        
        if($result){
            $data['id']=$result;
            return callback(statecode::SUCCESS,'',$data);
        }else{            
            return callback(statecode::ERROR,'签到失败',$data);
        }
    }
    
    /**
     * Summary of recharge
     * @param array $score ['uid','score']
     * @return mixed
     */
    public function recharge($score){
        $uid=$score['uid'];
        if($uid<1){
            return callback(statecode::LOGIC_SOCRE_UID,'',$score);
        }
        if(!Logic('user')->limits($uid,userLogic::limit_score_rechage)){
            //没有权限
            return callback(statecode::LOGIC_SOCRE_LIMIT);
        }
        if($score['score']<1){
            return callback(statecode::LOGIC_SOCRE_VALUE);            
        }  
        $data['uid']=$uid;
        $data['type']=self::score_type_recharge;
        $data['params']=0;
        $data['score']=$score['score'];
        $data['mark']='充值';
        $data['ctime']=TIMESTAMP;
        $result = Model('score')->insert($data);        
        if($result){
            $data['id']=$result;
            return callback(statecode::SUCCESS,'',$data);
        }else{            
            return callback(statecode::ERROR,'',$data);
        }
    }
    
    /**
     * Summary of buy
     * @param array $score ['uid','score','order_id']
     * @return mixed
     */
    public function buy($score){
        $uid=$score['uid'];
        if($uid<1){
            return callback(statecode::LOGIC_SOCRE_UID,'',$score);
        }
        if($score['score']==0){
            return callback(statecode::LOGIC_SOCRE_VALUE);
        }
        if($score['score']>0){
            $score['score']=0-$score['score'];
        }
        if( $score['order_id']<1){
            return callback(statecode::LOGIC_SOCRE_ORDER);             
        }
        $data['uid']=$uid;
        $data['type']=self::score_type_buy;
        $data['params']=$score['order_id'];
        $data['score']=$score['score'];
        $data['mark']='下单';
        $data['ctime']=TIMESTAMP;
        $result = Model('score')->insert($data);
        if($result){
            $data['id']=$result;
            return callback(statecode::SUCCESS,'',$data);
        }else{            
            return callback(statecode::ERROR,'下单失败',$data);
        }
    }
    
    /**
     * Summary of score_exc
     * @param array $score ['uid','to_uid','score']
     * @return mixed
     */
    public function score_exc($score){
        $uid=$score['uid'];
        if($uid<1){
            return callback(statecode::LOGIC_SOCRE_UID,'',$score);
        }
        if(!Logic('user')->limits($uid,userLogic::limit_score_out)){
            //没有权限
            return callback(statecode::LOGIC_SOCRE_LIMIT);
        }
        $to_uid = $score['to_uid'];
        if($to_uid<1){
            return callback(statecode::LOGIC_SOCRE_UID2,'',$score);
        }
        if(!Logic('user')->limits($to_uid,userLogic::limit_score_in)){
            //没有权限
            return callback(statecode::LOGIC_SOCRE_LIMIT);
        }
        $score['score'] = abs($score['score']);
        if($score['score']<10000){
            return callback(statecode::LOGIC_SOCRE_COUNT);
        }
        $has_socre = $this->get_score($uid);
        if($has_socre<$score['score']){
            return callback(statecode::LOGIC_SOCRE_LESS);            
        }        
        $model_score = Model('score');
        $model_score->beginTransaction();        
        $data=[];
        $data['uid']=$uid;
        $data['type']=self::score_type_out;
        $data['params']=$to_uid;
        $data['score']=0-$score['score'];
        $data['mark']='转出';
        $data['ctime']=TIMESTAMP;
        $result=$model_score->insert($data);
        if($result){
            $data=[];
            $data['uid']=$to_uid;
            $data['type']=self::score_type_out;
            $data['params']=$uid;
            $data['score']=$score['score'];
            $data['mark']='转入';
            $data['ctime']=TIMESTAMP;
            $result=$model_score->insert($data);
        }
        if($result){
            $model_score->commit();
            return callback(statecode::SUCCESS);
        }else{
            $model_score->rollback();
            return callback(statecode::ERROR);
        }
    }
    
    public function get_score($uid){
        $score=0;
        if($uid>0){
            $score = Model('score')->where(['uid'=>$uid])->sum('score');
        }
        return intval($score);
    }
    
    public function list_score($uid){
        return Model('score')->where(['uid'=>$uid])->order('id desc')->page(20)->select();
    }
    
    public function luck(){
        $model = Model();
        $model_period = Model('period');
        $model_order = Model('order');
        $model_score = Model('score');
        $list = $model_period->where(['pstatus'=>2])->select();
        foreach ($list as $period)
        {
            while($list_order = $model_order->where(['pid'=>$period['id'],'num'=>$period['jnum'],'is_right'=>0])->limit(1000)->select()){
                foreach ($list_order as $order)
                {
                    $data=[];
                    $data['uid']=$order['uid'];
                    $data['type']=self::score_type_luck;
                    $data['params']=$order['id'];
                    $has_send = $model_score->where($data)->find();
                    if($has_send){
                        //不重复执行
                        continue;
                    }
                    $data['score']=$order['score']*self::score_times;
                    $data['mark']='中　奖';
                    $data['ctime']=TIMESTAMP;
                    $model->beginTransaction();
                    $result = $model_score->insert($data);
                    if($result){
                        $result = $model_order->where(['id'=>$order['id']])->update(['is_right'=>1,'stime'=>TIMESTAMP]);
                    }
                    if($result){
                        $model->commit();
                    }else{
                        $model->rollback();
                    }
                }                
            }
        }
    }
    
}