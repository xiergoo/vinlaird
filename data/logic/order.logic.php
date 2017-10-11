<?php
defined('InShopNC') or exit('Access Invalid!');

class orderLogic {
    const period_min_socre=100;
    const period_max_socre=100000;
    /**
     * Summary of buy
     * @param array $order ['pid','uid','score','items'=>[['num','times'],['num','times']]]
     */
    public function buy($order){
        $uid=$order['uid'];
        if($uid<1){
            return callback(statecode::LOGIC_ORDER_UID,'',$order);
        }
        if(!Logic('user')->limits($uid,userLogic::limit_buy)){
            //没有权限
            return callback(statecode::LOGIC_ORDER_LIMIT);
        }
        $pid=$order['pid'];
        if($pid<1){
            return callback(statecode::LOGIC_ORDER_PID,'',$order);
        }
        $result = Logic('period')->get_the_period();
        if($result['state']!==true){
            return callback(statecode::LOGIC_ORDER_PNOTEXIST,'',$order);
        }
        $period_info=$result['data'];
        if($period_info['pstatus']!=1){
            return callback(statecode::LOGIC_ORDER_POVER,'',$order);        
        }
        if($period_info['jtime']-TIMESTAMP<300){
            return callback(statecode::LOGIC_ORDER_POVER2,'，即将揭晓',$order);
        }
        $score=$order['score'];
        if($score<self::period_min_socre){
            return callback(statecode::LOGIC_ORDER_SCORE,'',$order);
        }
        if($score%100!=0){
            return callback(statecode::LOGIC_ORDER_SCORE,'',$order);
        }
        $user_score = Logic('score')->get_score($uid);
        if($user_score<$score){
            return callback(statecode::LOGIC_ORDER_NOSCORE,'',$order);
        }
        $item_sum_score=0;
        foreach ($order['items'] as $item)
        {
        	$item_sum_score+=$item['times'];
        }
        if($item_sum_score!=$score){
            return callback(statecode::LOGIC_ORDER_SCOREERR,'',$order);
        }
        $data=[];
        $model_order = Model('order');
        $model_order->beginTransaction();
        foreach ($order['items'] as $item)
        {
            $data['uid']=$uid;
            $data['pid']=$pid;
            $data['num']=$item['num'];
            $data['score']=$item['times'];
            $data['is_right']=0;
            $data['stime']=0;
            $data['ctime']=TIMESTAMP;
            $order_id = $model_order->insert($data);
            if($order_id){
                $result = Logic('score')->buy(['uid'=>$uid,'score'=>$item['times'],'order_id'=>$order_id]);
                if($result['state']!==true){
                    $model_order->rollback();
                    return $result;
                }
            }else{
                $model_order->rollback();
                return callback(statecode::LOGIC_ORDER_ORDERERR,'',$data);
            }
        }
        $model_order->commit();
        return callback(statecode::SUCCESS);
    }
        
    public function list_user_order($uid,$is_right=0){
        $where['uid']=$uid;
        if($is_right){
            $where['is_right']=1;
        }
        return Model('order')->where($where)->order('pid desc')->page(20)->select();
    }
    
    public function list_period_order($pid,$is_right=0){
        $where['pid']=$pid;
        if($is_right){
            $where['is_right']=1;
        }
        return Model('order')->where($where)->page($p)->select();
    
    }
}