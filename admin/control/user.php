<?php

defined('InShopNC') or exit('Access Invalid!');

class userControl extends SystemControl{
    /**
     * Summary of $classUser
     * @var userClass
     */
    private $classUser;    
	public function __construct(){
		parent::__construct();
		Language::read('index');
	}
	public function indexOp(){
        $list = Model('user')->where($where)->order('id desc')->page(20)->select();
        $page=pagecmd('obj');
        Tpl::output('_page',$page->show());
	}
    
    public function setLimitOp(){
        if(IS_POST){
        }else{
            Tpl::output('limits',$this->classUser->limits());
        }
    }
}
