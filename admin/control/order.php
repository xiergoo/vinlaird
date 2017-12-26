<?php

defined('InShopNC') or exit('Access Invalid!');

class orderControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('index');
	}
	public function indexOp(){
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
        $type_id=$_GET('type_id');
        if($type_id>0){
            $where['type_id']=$type_id;
        }
        $is_right=intval($_GET['is_right']);
        if($is_right>0){
            if($is_right==1){
                $where['is_right']=1;
            }else{
                $where['is_right']=0;
            }
        }
        $list = Model('order')->where($where)->order('id desc')->page(20)->select();
        $page=pagecmd('obj');
        Tpl::output('_page',$page->show());
	}
}
