<?php
defined('InShopNC') or exit('Access Invalid!');

class orderLogic {
    const period_min_socre=100;
    const period_max_socre=100000;
    /**
     * Summary of buy
     * @param array $order ['pid','uid','score','items'=>[['num','score'],['num','score']]]
     */
    public function buy($order){
        $uid=$order['uid'];
        if($uid<1){
            return callback(1,'无效的用户id',$order);
        }
        if(!Logic('user')->limits($uid,userLogic::limit_buy)){
            //没有权限
            return callback(2,'无效的操作');
        }
        $pid=$order['pid'];
        if($pid<1){
            return callback(3,'无效的pid',$order);
        }
        $period_info = Logic('period')->get_the_period();
        if(!$period_info){
            return callback(4,'本期不存在',$order);
        }
        if($period_info['pstatus']!=1){
            return callback(5,'本期购买已结束',$order);        
        }
        if($period_info['jtime']-TIMESTAMP<300){
            return callback(6,'本期购买已结束，即将揭晓',$order);
        }
        $score=$order['score'];
        if($score<self::period_min_socre){
            return callback(7,'无效的积分数量',$order);
        }
        if($score%100!=0){
            return callback(8,'无效的积分数量',$order);
        }
        $user_score = Logic('score')->get_score($uid);
        if($user_score<$score){
            return callback(9,'积分不足',$order);
        }
        $item_sum_score=0;
        foreach ($order['items'] as $item)
        {
        	$item_sum_score+=$item['score'];
        }
        if($item_sum_score!=$score){
            return callback(10,'积分数量有误',$order);
        }
        $data=[];
        $model_order = Model('order');
        $model_order->beginTransaction();
        foreach ($order['items'] as $item)
        {            $data['uid']=$uid;            $data['pid']=$pid;            $data['num']=$item['num'];            $data['score']=$item['score'];            $data['is_right']=0;            $data['stime']=0;            $data['ctime']=TIMESTAMP;            $order_id = $model_order->insert($data);            if($order_id){                $result = Logic('score')->buy(['uid'=>$uid,'score'=>$item['score'],'order_id'=>$order_id]);                if($result['state']!==true){                    $model_order->rollback();                    return $result;                }            }else{                $model_order->rollback();                return callback(false,'订单插入失败',$data);            }
        }
        $model_order->commit();
        return callback(true);
    }
        
    public function list_user_order($uid,$p=1,$is_right=0){
        $where['uid']=$uid;
        if($is_right){
            $where['is_right']=1;
        }
        return Model('order')->where($where)->order('pid desc')->page($p)->select();
    }
    
    public function list_period_order($pid,$is_right=0){
        $where['pid']=$pid;
        if($is_right){
            $where['is_right']=1;
        }
        return Model('order')->where($where)->page($p)->select();
    
    }
}