<?php
defined('InShopNC') or exit('Access Invalid!');

class scoreLogic {
    const score_type_recharge=1;
    const score_type_buy=2;
    const score_type_daka=3;
    const score_type_luck=4;
    
    const score_times=40;
    
    const daka_score=10;
    public function daka($score){
        $uid=$score['uid'];
        if($uid<1){
            return callback(1,'无效的用户id',$score);
        }       
        if($score['score']<1){
            return callback(2,'无效的积分值');            
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
    
    public function recharge($score){
        $uid=$score['uid'];
        if($uid<1){
            return callback(1,'无效的用户id',$score);
        }
        $user = Logic('user')->getUser($uid);
        if($user['limits'] && in_array('recharge',explode(',',$user['limits']))){
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
    
    public function buy($socre){
        $uid=$score['uid'];
        if($uid<1){
            return callback(1,'无效的用户id',$score);
        }
        if($score['score']>=0){
            return callback(2,'无效的积分值');            
        }
        if( $socre['order_id']<1){
            return callback(3,'无效的order_id');             
        }
        $data['uid']=$uid;
        $data['type']=self::score_type_buy;
        $data['params']=$socre['order_id'];
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
    
    public function luck(){
        $model = Model();
        $model_period = Model('period');
        $model_order = Model('order');
        $list = $model_period->where(['pstatus'=>2])->select();
        foreach ($list as $period)
        {
            while($list_order = $model_order->where(['pid'=>$period['id'],'num'=>$period['jnum'],'is_right'=>0])->limit(1000)->select()){
                foreach ($list_order as $order)
                {
                    $model->beginTransaction();                    
                    $data['uid']=$order['uid'];
                    $data['type']=self::score_type_luck;
                    $data['params']=$order['id'];
                    $data['score']=$order['score']*self::score_times;
                    $data['mark']='中　奖';
                    $data['ctime']=TIMESTAMP;
                    $result = Model('score')->insert($data);
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