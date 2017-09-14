<?php
defined('InShopNC') or exit('Access Invalid!');

class scoreLogic {
    const score_type_recharge=1;
    const score_type_buy=2;
    const score_type_daka=3;
    
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
        $data['exptime']=mktime(23,59,59,date('n'),date('j'),date('Y')+3);
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
        $data['exptime']=mktime(23,59,59,date('n'),date('j'),date('Y')+3);
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
        $data['exptime']=mktime(23,59,59,date('n'),date('j'),date('Y')+3);
        $data['ctime']=TIMESTAMP;
        $result = Model('score')->insert($data);        
        if($result){
            $data['id']=$result;
            return callback(true,'',$data);
        }else{            
            return callback(false,'',$data);
        }
    }
}