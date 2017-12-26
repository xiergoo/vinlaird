<?php
/**
 ***/

defined('InShopNC') or exit('Access Invalid!');
class WapControl{

    /**
     * Summary of $classUser
     * @var userClass
     */
    protected $classUser;
    
    protected $uid = 0;
	public function __construct(){
		if(!in_weixin()){
            if(!C('debug')){
                //只能在微信中打开
                die;
            }
        }
        $this->init();
        $user = $this->classUser->getLoginUser();
        if(!$user){
            $wechat_handler = get_wechat_handler();
            $token_info = $wechat_handler->getOauthAccessToken();
            if($token_info){//静默授权成功
                $token=$token_info['access_token'];
                $openid=$token_info['openid'];
                //通过openid 获取db 用户
                $user=$this->classUser->find(['openid'=>$openid]);                
                if(!$user){                    
                    $wechat_user = $wechat_handler->getOauthUserinfo($token_info['access_token'],$token_info['openid']);
                    $wechat_user['ivt_id']=intval(base64_decode($_GET['ivt_id']));
                    //注册
                    $result = $this->classUser->addUser($wechat_user);
                    if($result['state']===true){
                        $user=$result['data'];
                    }
                }
            }else{
                if($_GET['state']==1){
                    //静默授权失败，进行非静默授权
                    $wechat_handler->getOauthRedirect(url_current(),2,'snsapi_userinfo');
                }elseif($_GET['state']==2){
                    //非静默授权失败
                    die;
                }else{
                    //静默授权
                    $wechat_handler->getOauthRedirect(url_current(),1,'snsapi_base');
                }
            }
        }
        if($user['id']>0){
            $this->uid=$user['uid'];
            if(!$this->classUser->checkLimits($this->uid,userClass::limit_login)){
                exit(statecodeClass::msg(statecodeClass::USER_LOGIN_FORBIDDEN));
            }
            $this->classUser->setLoginUser($this->uid);
        }else{
            if(C('debug')){
                $this->uid=1;
            }else{
                die;
            }
        }
        $_SESSION['member_id']=$this->uid;
	}

    protected function init(){
        $this->classUser=userClass::I();
    }
    
    protected final function goLogin(){
        $this->setReferer();
        @header('Location: index.php?act=login&op=login');exit;
    }
    
    protected final function setReferer(){
        setNcCookie('lgref',urlencode(url_current()));  
    }
    
    protected final function getReferer(){
        return cookie('lgref')? urldecode(cookie('lgref')) :'';
    }

}
