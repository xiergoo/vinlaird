<?php

defined('InShopNC') or exit('Access Invalid!');

class periodControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('index');
	}
	public function indexOp(){
        $pnum=intval($_GET['pnum']);
        $where=[];
        if($pnum>=100){
            $where['pnum']=$pnum;
        }
        $list = Model('period')->where($where)->order('id desc')->page(20)->select();        
        $page=pagecmd('obj');
        Tpl::output('_page',$page->show());
	}
    
    public function orderOp(){
        $where=[];
        $pnum=intval($_GET['pnum']);
        if($pnum>=100){
            $p_info = Model('period')->field('id')->where(['pnum'=>$pnum])->find();
            if($p_info['id']>0){
                $where['pid']=$p_info['id'];
            }
        }
        $uid=intval($_GET['uid']);
        if($uid>0){
            $where['uid']=$uid;
        }
        $_GET['is_right']==1?$where['is_right']=1:$_GET['is_right']==2?$where['is_right']=0:'';
        $list = Model('order')->where($where)->order('id desc')->page(20)->select();
        $page=pagecmd('obj');
        Tpl::output('_page',$page->show());
    }
}
