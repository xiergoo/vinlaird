<?php
/**
 ***/

defined('InShopNC') or exit('Access Invalid!');
class IndexControl extends WapControl{    
    /**
     * Summary of $class
     * @var periodClass
     */
    private $classPeriod;
    /**
     * Summary of $classOrder
     * @var orderClass
     */
    private $classOrder;
    
    //private $buyScoreArr=['1'=>100,'2'=>1000,'3'=>2000,'4'=>5000,'5'=>10000,'6'=>20000,'7'=>300000];
    private $buyScoreArr=['1'=>100,'2'=>1000,'3'=>2000,'4'=>5000,'5'=>10000];
    protected function init(){
        $this->classPeriod=periodClass::I();
        $this->classOrder=orderClass::I();
    }
    
    public function indexOp(){
        $list =$this->classPeriod->listsing();
        Tpl::output('list',$list);
    }
    
    public function detailOp(){
        $pid = intval($_GET['pid']);
        if($pid<1){
            showMessage(statecodeClass::msg(statecodeClass::PERIOD_ID_ERROR));
        }
        $periodInfo = $this->classPeriod->find($pid,false);
        if($periodInfo['id']<=0){
            showMessage(statecodeClass::msg(statecodeClass::PERIOD_NOT_EXIST));
        }
        if($periodInfo['pstatus']==periodClass::status_offline){
            showMessage(statecodeClass::msg(statecodeClass::PERIOD_OFFLINE));
        }
        Tpl::output('times',$this->buyScore());
        Tpl::output('period',$periodInfo);        
        $str_today=date('Y-m-d');
        Tpl::display('detail');
    }
    
    public function listOrderOp(){
        if(IS_AJAX){
            $jnum='';
            $pid = intval($_REQUEST['pid']);
            $periodInfo = $this->classPeriod->getOne($pid,false);
            $isRight=$_REQUEST['type']==1?1:0;
            $cacheListOrderKey='indexListOrder_'.$pid.'_'.$isRight.'_'.$_REQUEST['curpage'];
            $listOrder = rcache($cacheListOrderKey);
            if(!$listOrder){
                $listOrder = $this->classOrder->listPeriodOrder($pid,$isRight);
                if($listOrder){
                    foreach ($listOrder as &$order)
                    {
                        $userInfo=$this->classUser->getOne($order['uid']);
                        $order['nickname']=$userInfo['nickname'];
                        $order['headimgurl']=user_headimgurl($userInfo['headimgurl']);
                    }
                    wcache($cacheListOrderKey,$listOrder,'',1);
                }
            }
            output_json(statecodeClass::SUCCESS,'',['type'=>$isRight,'list'=>$listOrder,'pstatus'=>$periodInfo['pstatus']]);
        }
    }
    
    public function commitOp(){
        if(!Security::checkToken()){
            output_json(statecodeClass::TOKENERR);
        }
        $pid=intval($_POST['pid']);
        $times=intval($_POST['times']);
        $score=intval($_POST['score']);
        $nums = trim($_POST['num'],',');
        $nums = explode(',',$nums);
        if(!in_array($times,$this->buyScore())){
            output_json(statecodeClass::PARAMSERR);
        }
        if($score!=count($nums)*$times){
            output_json(statecodeClass::PARAMSERR,'',$nums);
        }
        $data['pid']=$pid;
        $data['uid']=$this->uid;
        $data['score']=$score;
        foreach ($nums as $num)
        {
        	$data['items'][]=['num'=>$num,'times'=>$times];
        }
        $buyLogic=new buyLogic();
        $result = $buyLogic->buy($data);
        if($result['state']===statecodeClass::SUCCESS){
            $scoreIndex=$this->scoreIndex($times);
            $this->buyHabit($scoreIndex);
            output_json();
        }else{
            Log::record(['data'=>$data,'result'=>$result]);
            output_json($result['state'],$result['msg']);
        }
    }
    
    public function historyOp(){
        $where['type_id']=$_REQUEST['type_id'];
        if(!$where['type_id']){
            die;
        }
        $where['jtime']=['elt',dapanClass::beforeTime()];
        $where['pstatus']=['in',[periodClass::status_wait,periodClass::status_finish]];
        $list = $this->classPeriod->lists($where);
        Tpl::output('list',$list);
        Tpl::display('history');
    }
    
    private function buyScore(){        
        $scoreIndex = $this->buyHabit();
        $scoreIndex = min(count($this->buyScoreArr)-2,$scoreIndex);
        $scoreIndex = max(3,$scoreIndex);
        $buyScoreArr[$scoreIndex-2]=$this->buyScoreArr[$scoreIndex-2];
        $buyScoreArr[$scoreIndex-1]=$this->buyScoreArr[$scoreIndex-1];
        $buyScoreArr[$scoreIndex]=$this->buyScoreArr[$scoreIndex];
        $buyScoreArr[$scoreIndex+1]=$this->buyScoreArr[$scoreIndex+1];
        $buyScoreArr[$scoreIndex+2]=$this->buyScoreArr[$scoreIndex+2];
        return $buyScoreArr;
    }
    
    private function scoreIndex($score){
        foreach ($this->buyScoreArr as $key=>$value)
        {
        	if($value==$score){
                return $key;
            }
        }
        return 0;
    }
    
    private function buyHabit($scoreIndex=0){
        $key='indexUserBuyHabit_'.$this->uid;
        $buyHabit=rcache($key);
        if($scoreIndex>0){
            if(in_array($scoreIndex,array_keys($this->buyScoreArr))){
                $buyHabit[$scoreIndex]++;
                wcache($key,$buyHabit,'',1296000);
            }
        }else{
            if(count($buyHabit)>=2){
                arsort($buyHabit);
                foreach ($buyHabit as $key=>$value)
                {
                    if($value>20){
                        return $key;
                    }
                	break;
                }
                
            }
        }
        return 0;
    }
}
