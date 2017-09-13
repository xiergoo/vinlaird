<?php
/**
 ***/

defined('InShopNC') or exit('Access Invalid!');
class WapControl{

    protected $uid = 0;
    protected $wechat_handler=null;
	public function __construct(){
		if(!in_weixin()){
            //只能在微信中打开
            // die;
        }
        /*
        $this->token = isset($options['token'])?$options['token']:'';
		$this->encodingAesKey = isset($options['encodingaeskey'])?$options['encodingaeskey']:'';
		$this->appid = isset($options['appid'])?$options['appid']:'';
		$this->appsecret = isset($options['appsecret'])?$options['appsecret']:'';
		$this->debug = isset($options['debug'])?$options['debug']:false;
		$this->logcallback = isset($options['logcallback'])?$options['logcallback']:false;
         * */
        $options=[];        
        $this->wechat_handler = new wechatbase($options);
        $user = $this->getUser();
        if(!$user){
            $token_info = $this->wechat_handler->getOauthAccessToken();
            if($token_info){//静默授权成功
                $token=$token_info['access_token'];
                $openid=$token_info['openid'];
                //通过openid 获取db 用户
                $user=Logic('user')->getUser($openid);                
                if(!$user){                    
                    $wechat_user = $this->wechat_handler->getOauthUserinfo($token_info['access_token'],$token_info['openid']);
                    $wechat_user['ivt_id']=intval(base64_decode($_GET['ivt_id']));
                    //注册
                    $result = Logic('user')->addUser($wechat_user);
                    if($result['state']===true){
                        $this->setUser($result['data']);
                    }
                }
            }else{
                if($_GET['state']==1){
                    //静默授权失败，进行非静默授权
                    $this->wechat_handler->getOauthRedirect(url_current(),2,'snsapi_userinfo');
                }elseif($_GET['state']==2){
                    //非静默授权失败
                    die;
                }else{
                    //静默授权
                    $this->wechat_handler->getOauthRedirect(url_current(),1,'snsapi_base');
                }
            }
        }
        if($user['id']>0){
            $this->uid=$user['uid'];
        }else{
            die;
        }
	}

	protected final function getUser(){
		$userId = unserialize(decrypt(cookie('u_key'),md5(MD5_KEY)));
		if ($userId>0){
			$this->setUser($userId);
            $user = Logic('user')->getUser($userId,false);
            return $user;		
		}
        return false;
	}
	protected final function setUserId($userId){
        if($userId>0){
            setNcCookie('u_key',encrypt(serialize($userId),md5(MD5_KEY)),7200,'',null);        
        }
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
