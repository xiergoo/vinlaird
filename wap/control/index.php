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
    
    private $times_arr=[100,1000,2000,5000,10000];
    
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
        Tpl::output('times',$this->times_arr);
        Tpl::output('period',$periodInfo);        
        $str_today=date('Y-m-d');
        Tpl::display('detail');
    }
    
    public function listOrderOp(){
        if(IS_AJAX){
            $jnum='';
            $pid = intval($_REQUEST['pid']);
            $periodInfo = $this->classPeriod->find($pid,false);
            $isRight=$_REQUEST['type']==1?1:0;
            $cacheListOrderKey='indexListOrder_'.$pid.'_'.$isRight.'_'.$_REQUEST['curpage'];
            $listOrder = rcache($cacheListOrderKey);
            if(!$listOrder){
                $listOrder = $this->classOrder->listPeriodOrder($pid,$isRight);
                if($listOrder){
                    foreach ($listOrder as &$order)
                    {
                        $userInfo=$this->classUser->find($order['uid']);
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
        if(!in_array($times,$this->times_arr)){
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
        $result = buyLogic::I()->buy($data);
        if($result['state']===statecodeClass::SUCCESS){
            output_json();
        }else{
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
}
