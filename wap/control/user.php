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
        Tpl::output('user',$user_info);
        Tpl::display('user.index');        
    }    
}
