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
            output_json(0,'',$list);
        }
        $page=pagecmd('obj');
        Tpl::output('page_total',$page->getTotalPage());
        Tpl::output('list',$list);
        Tpl::display('user.score'); 
    }
}
