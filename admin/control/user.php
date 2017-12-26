<?php

defined('InShopNC') or exit('Access Invalid!');

class userControl extends SystemControl{
    /**
     * Summary of $classUser
     * @var userClass
     */
    private $classUser;    
	public function __construct(){
		//parent::__construct();
		Language::read('index');
        $this->classUser = userClass::I();
	}
	public function indexOp(){
        $list = $this->classUser->lists();
        dump($list);
        $page=pagecmd('obj');
        dump($page);
        Tpl::output('_page',$page->show());
	}
    
    public function setLimitOp(){
        if(IS_POST){
        }else{
            Tpl::output('limits',$this->classUser->limits());
        }
    }
}
