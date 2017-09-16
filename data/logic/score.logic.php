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
            return callback(1,'无效的用户id',$score);
        }
        if(!Logic('user')->limits($uid,userLogic::limit_daka)){
            //没有权限
            return callback(2,'无效的操作');
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
            return callback(true,'',$data);
        }else{            
            return callback(false,'',$data);
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
            return callback(1,'无效的用户id',$score);
        }
        if(!Logic('user')->limits($uid,userLogic::limit_score_rechage)){
            //没有权限
            return callback(2,'无效的操作');
        }
        if($score['score']<1){
            return callback(2,'无效的积分值');            
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
            return callback(true,'',$data);
        }else{            
            return callback(false,'',$data);
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
            return callback(1,'无效的用户id',$score);
        }
        if($score['score']==0){
            return callback(2,'无效的积分值');
        }
        if($score['score']>0){
            $score['score']=0-$score['score'];
        }
        if( $score['order_id']<1){
            return callback(3,'无效的order_id');             
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
            return callback(true,'',$data);
        }else{            
            return callback(false,'',$data);
        }
    }
    
    /**
     * Summary of score_exc
     * @param array $score ['uid','score']
     * @return mixed
     */
    public function score_exc($score){
        $uid=$score['uid'];
        if($uid<1){
            return callback(1,'无效的用户id',$score);
        }
        if(!Logic('user')->limits($uid,userLogic::limit_score_out)){
            //没有权限
            return callback(2,'无效的操作');
        }
        if($score['score']<100 || $score['score']%100>0){
            return callback(2,'只能是100的整数倍');            
        }
        $model_score_exc = Model('score_exc');
        $v_code=mt_rand(1212,9999);
        $where['v_code']=$v_code;
        $where['rec_uid']=0;
        $where['ctime']=['egt'=>TIMESTAMP-600];
        while($model_score_exc->where($where)->find()){
            $v_code=mt_rand(1212,9999);
            $where['v_code']=$v_code;
        }
        $data['uid']=$uid;
        $data['score']=$score['score'];
        $data['rec_uid']=0;
        $data['v_code']=$v_code;
        $data['exctime']=0;
        $data['ctime']=TIMESTAMP;
        $result = $model_score_exc->insert($data);
        if($result){
            $data['id']=$result;
            return callback(true,'',$data);
        }else{            
            return callback(false,'',$data);
        }
    }
    
    /**
     * Summary of score_exc_cmt
     * @param array $score ['uid','v_code']
     * @return mixed
     */
    public function score_exc_cmt($score){
        $uid=$score['uid'];
        if($uid<1){
            return callback(1,'无效的用户id',$score);
        }
        if(!Logic('user')->limits($uid,userLogic::limit_score_in)){
            //没有权限
            return callback(2,'无效的操作');
        }
        if($score['v_code']<100000){
            return callback(2,'无效兑换码');        
        }
        $score_exc_info = Model('score_exc')->where(['v_code'=>$score['v_code']])->order('id desc')->find();
        if($score_exc_info['id']<1){
            return callback(2,'无效兑换码');
        }
        if($score_exc_info['ctime']+600<=TIMESTAMP){
            return callback(2,'无效兑换码已过期，请重新生成');
        }
        if($score_exc_info['rec_uid']>0){
            return callback(2,'兑换码已使用');
        }
        $result=true;
        $model_score = Model('score');
        $score_info = $model_score->where(['type'=>self::score_type_in,'params'=>$score_exc_info['id']])->find();
        $model_score->beginTransaction();
        if($score_info['id']>0){
            if($score_info['uid']!=$uid){
                return callback(2,'该兑换码已被其他人兑换'); 
            }  
        }else{
            $data=[];
            $data['uid']=$uid;
            $data['type']=self::score_type_in;
            $data['params']=$score_exc_info['id'];
            $data['score']=$score['score'];
            $data['mark']='转入';
            $data['ctime']=TIMESTAMP;
            $result=$model_score->insert($data);
        }
        if($result){
            $score_info = $model_score->where(['uid'=>$score_exc_info['uid'],'type'=>self::score_type_out,'params'=>$score_exc_info['id']])->find();
            if(!$score_info){
                $data=[];
                $data['uid']=$uid;
                $data['type']=self::score_type_out;
                $data['params']=$score_exc_info['id'];
                $data['score']=0-$score['score'];
                $data['mark']='转出';
                $data['ctime']=TIMESTAMP;
                $result=$model_score->insert($data);
            }
        }
        if($result){
            $result = Model('score_exc')->where(['id'=>$score_exc_info['id']])->update(['rec_uid'=>$uid,'v_code'=>'','exctime'=>TIMESTAMP]);
        }
        if($result){
            $model_score->commit();
            return callback(true);
        }else{
            $model_score->rollback();
            return callback(false);
        }
    }
    
    public function get_score($uid){
        $score=0;
        if($uid>0){
            $score = Model('score')->where(['uid'=>$uid])->sum('score');
        }
        return intval($score);
    }
    
    public function list_score($uid,$p){
        return Model('score')->where(['uid'=>$uid])->order('id desc')->page($p)->select();
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