<?php

defined('InShopNC') or exit('Access Invalid!');

class scoreControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('index');
	}
	public function indexOp(){
        $where=[];
        $uid=intval($_GET['uid']);
        if($uid>0){
            $where['uid']=$uid;
        }
        $type=$_GET('type');
        if($type>0){
            $where['type']=$type;
        }
        $params=intval($_GET['params']);
        if($is_right>0){
            $where['params']=$params;
        }
        $list = Model('score')->where($where)->order('id desc')->page(20)->select();
        $page=pagecmd('obj');
        Tpl::output('_page',$page->show());
	}
}
