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
}
