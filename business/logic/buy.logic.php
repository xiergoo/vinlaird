<?php
defined('InShopNC') or exit('Access Invalid!');

class buyLogic {    
    /**
     * Summary of $entityOrder
     * @var orderEntity
     */
    private $entityOrder;
    /**
     * Summary of $entityScore
     * @var scoreEntity
     */
    private $entityScore;
    /**
     * Summary of $classOrder
     * @var orderClass
     */
    private $classOrder;
    /**
     * Summary of $classSocre
     * @var scoreClass
     */
    private $classSocre;
    /**
     * Summary of $classUser
     * @var userClass
     */
    private $classUser;
    
    private function __construct(){
        $this->classOrder=orderClass::I();
        $this->classSocre=scoreClass::I();
        $this->classUser=userClass::I();
        $this->entityOrder=$this->classOrder->getEntity();
        $this->entityScore=$this->classSocre->getEntity();
    }
    
    public static function I(){
        static $i=null;
        if($i===null){
            $i=new buyLogic();
        }
        return $i;
    }
    
    /**
     * Summary of buy
     * @param array $order ['pid','uid','score','items'=>[['num','times'],['num','times']]]
     */
    public function buy($order){
        $uid=$order['uid'];
        if($uid<1){
            return callback(statecodeClass::ORDER_UID,'',$order);
        }
        if(!$this->classUser->checkLimits($uid,userClass::limit_buy)){
            //没有权限
            return callback(statecodeClass::ORDER_LIMIT);
        }
        $pid=$order['pid'];
        if($pid<1){
            return callback(statecodeClass::ORDER_PID,'',$order);
        }
        $periodInfo = periodClass::I()->find($pid,false);     
        if($periodInfo['id']<1){
            return callback(statecodeClass::ORDER_PNOTEXIST,'',$order);
        }
        if($periodInfo['pstatus']!=periodClass::status_online){
            return callback(statecodeClass::ORDER_POVER,'',$order);        
        }
        if($periodInfo['jtime']<dapanClass::beforeTime()){
            return callback(statecodeClass::PERIOD_NO_START,'',$order);
        }
        if($periodInfo['jtime']>=dapanClass::afterTime()){
            $result = callback(statecodeClass::PERIOD_FINISHED,'',$order);
        }
        if($periodInfo['jtime']-TIMESTAMP<periodClass::protected_time){
            return callback(statecodeClass::PERIOD_FINISHED_WILL_OPEN,'',$order);
        }
        $score=$order['score'];
        if($score<periodClass::socre_min){
            return callback(statecodeClass::ORDER_SCORE,'',$order);
        }
        if($score%100!=0){
            return callback(statecodeClass::ORDER_SCORE,'',$order);
        }
        $userScore = $this->classSocre->getScore($uid);
        if($userScore<$score){
            return callback(statecodeClass::ORDER_NOSCORE,'',$order);
        }
        $itemSumScore=0;
        foreach ($order['items'] as $item)
        {
        	$itemSumScore+=$item['times'];
        }
        if($itemSumScore!=$score){
            return callback(statecodeClass::ORDER_SCOREERR,'',$order);
        }
        $data=[];
        $modelOrder = $this->entityOrder;
        $modelOrder->beginTransaction();
        foreach ($order['items'] as $item)
        {
            $data['uid']=$uid;
            $data['pid']=$pid;
            $data['num']=$item['num'];
            $data['score']=$item['times'];
            $data['is_right']=0;
            $data['stime']=0;
            $data['ctime']=time();
            $orderID = $modelOrder->insert($data);
            if($orderID){
                $result = $this->classSocre->order(['uid'=>$uid,'score'=>$item['times'],'order_id'=>$orderID]);
                if($result['state']!==statecodeClass::SUCCESS){
                    $modelOrder->rollback();
                    return $result;
                }
            }else{
                $modelOrder->rollback();
                return callback(statecodeClass::ORDER_ORDERERR,'',$data);
            }
        }
        $modelOrder->commit();
        return callback(statecodeClass::SUCCESS);
    }
}