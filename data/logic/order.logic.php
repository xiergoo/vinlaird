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
            return callback(1,'��Ч���û�id',$order);
        }
        if(!Logic('user')->limits($uid,userLogic::limit_buy)){
            //û��Ȩ��
            return callback(2,'��Ч�Ĳ���');
        }
        $pid=$order['pid'];
        if($pid<1){
            return callback(3,'��Ч��pid',$order);
        }
        $period_info = Logic('period')->get_the_period();
        if(!$period_info){
            return callback(4,'���ڲ�����',$order);
        }
        if($period_info['pstatus']!=1){
            return callback(5,'���ڹ����ѽ���',$order);        
        }
        if($period_info['jtime']-TIMESTAMP<300){
            return callback(6,'���ڹ����ѽ�������������',$order);
        }
        $score=$order['score'];
        if($score<self::period_min_socre){
            return callback(7,'��Ч�Ļ�������',$order);
        }
        if($score%100!=0){
            return callback(8,'��Ч�Ļ�������',$order);
        }
        $user_score = Logic('score')->get_score($uid);
        if($user_score<$score){
            return callback(9,'���ֲ���',$order);
        }
        $item_sum_score=0;
        foreach ($order['items'] as $item)
        {
        	$item_sum_score+=$item['score'];
        }
        if($item_sum_score!=$score){
            return callback(10,'������������',$order);
        }
        $data=[];
        $model_order = Model('order');
        $model_order->beginTransaction();
        foreach ($order['items'] as $item)
        {            $data['uid']=$uid;            $data['pid']=$pid;            $data['num']=$item['num'];            $data['score']=$item['score'];            $data['is_right']=0;            $data['stime']=0;            $data['ctime']=TIMESTAMP;            $order_id = $model_order->insert($data);            if($order_id){                $result = Logic('score')->buy(['uid'=>$uid,'score'=>$item['score'],'order_id'=>$order_id]);                if($result['state']!==true){                    $model_order->rollback();                    return $result;                }            }else{                $model_order->rollback();                return callback(false,'��������ʧ��',$data);            }
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