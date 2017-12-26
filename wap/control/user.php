<?php
/**
 ***/

defined('InShopNC') or exit('Access Invalid!');
class UserControl extends WapControl{

    public function __construct(){
        parent::__construct();
        if($this->uid<1){
            redirect(url());
        }
    }
    
    public function indexOp(){
        $user_info = Logic('user')->get_user($this->uid);
        $score = Logic('score')->get_score($this->uid);
        Tpl::output('user',$user_info);
        Tpl::output('score',$score);
        Tpl::display('user.index');        
    } 
    
    public function scoreOp(){
        $list = Logic('score')->list_score($this->uid);
        if(IS_AJAX){
            output_json(statecodeClass::SUCCESS,'',$list);
        }
        $page=pagecmd('obj');
        Tpl::output('page_total',$page->getTotalPage());
        Tpl::output('list',$list);
        Tpl::display('user.score'); 
    }
    
    public function orderOp(){
        $list = Logic('order')->list_user_order($this->uid);
        foreach ($list as &$li)
        {
            $pno=Model('period')->field('pno')->where(['id'=>$li['pid']])->find();
        	$li['pno']=$pno['pno'];
        }
        if(IS_AJAX){
            output_json(statecodeClass::SUCCESS,'',$list);
        }
        $page=pagecmd('obj');
        Tpl::output('page_total',$page->getTotalPage());
        Tpl::output('list',$list);
        Tpl::display('user.order'); 
    }
    
    public function luckOp(){
        $list = Logic('order')->list_user_order($this->uid,1);
        foreach ($list as &$li)
        {
            $pno=Model('period')->field('pno')->where(['id'=>$li['pid']])->find();
        	$li['pno']=$pno['pno'];
        }
        if(IS_AJAX){
            output_json(statecodeClass::SUCCESS,'',$list);
        }
        $page=pagecmd('obj');
        Tpl::output('page_total',$page->getTotalPage());
        Tpl::output('list',$list);
        Tpl::display('user.luck'); 
    }
    
    public function giveOp(){
        if(IS_POST){
            if(IS_AJAX){
                $uid=$this->uid;
                if($uid<1){
                    output_json(statecodeClass::UNLOGIN);
                }
                $touid=intval($_POST['touid']);
                if($touid<1){
                    output_json(statecodeClass::ERROR,'请填写有效的接收积分的uid');
                }
                $result = Logic('score')->score_exc(['uid'=>$this->uid,'to_uid'=>$touid,'score'=>intval($_POST['score'])]);
                output_json($result['state'],$result['msg']);
            }
            exit('');
        }
        Tpl::display('user.give'); 
    }
}
