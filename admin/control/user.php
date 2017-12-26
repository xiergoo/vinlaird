<?php

defined('InShopNC') or exit('Access Invalid!');

class userControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('index');
	}
	public function indexOp(){
		$model_user = Model('user');
        $list = $model_user->order('id desc')->page(20)->select();        
        $page=pagecmd('obj');
        Tpl::output('_page',$page->show());
	}
}
