<?php
/**
 ***/

defined('InShopNC') or exit('Access Invalid!');
class IndexControl extends WapControl{

    private $times_arr=[100,1000,2000,5000,10000];
    
    public function indexOp(){
        $typeData = ['name'=>'test1111111','enable'=>1,'times'=>5.6,'mark'=>'this is a test']; 
        $entity = new typeEntity();
        $entity->id=1;
        dump($entity->get());
        $entity->id=2;
        dump($entity->get());
        die;
        
        $te = new periodEntity(2);
        dump($te->get());die;
        
        $p = typeClass::I();
        dump($p->getTypeInfo(1));
        
        die;
        
        $result = Logic('period')->get_the_period();
        if($result['state']!==true){
            echo '<h1>您访问的页面不存在！</h1>';
            die;
        }
        $period_info=$result['data'];
        if($period_info['pstatus']!=1){
            echo '<h1>您访问的页面不存在！</h1>';
            die;
        }
        Tpl::output('times',$this->times_arr);
        Tpl::output('period',$period_info);        
        $str_today=date('Y-m-d');
        Tpl::display('index');
    }
    
    public function commitOp(){
        if(!Security::checkToken()){
            output_json(statecode::TOKENERR);
        }
        $pid=intval($_POST['pid']);
        $times=intval($_POST['times']);
        $score=intval($_POST['score']);
        $nums = trim($_POST['num'],',');
        $nums = explode(',',$nums);
        if(!in_array($times,$this->times_arr)){
            output_json(statecode::PARAMSERR);
        }
        if($score!=count($nums)*$times){
            output_json(statecode::PARAMSERR,'',$nums);
        }
        $data['pid']=$pid;
        $data['uid']=$this->uid;
        $data['score']=$score;
        foreach ($nums as $num)
        {
        	$data['items'][]=['num'=>$num,'times'=>$times];
        }
        $result = Logic('order')->buy($data);
        if($result['state']===true){
            output_json();
        }else{
            output_json($result['state'],$result['msg']);
        }
    }
    
    public function historyOp(){
        $list = Logic('period')->list_period();
        Tpl::output('list',$list);
        Tpl::display('history');
    }
}
