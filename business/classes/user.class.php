<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class userClass extends baseClass{
    const limit_login=1;
    const limit_daka=2;
    const limit_buy=3;
    const limit_score_out=4;
    const limit_score_in=5;
    const limit_score_rechage=6;
    //7、8、9保留，暂未使用
    protected $table_name='user';
    protected $fields=['id','openid','nickname','headimgurl','gender','subscribe','subscribetime','ivt_uid','limits','mobile','score','addtime']; 
    
    public function addUser($user){
        if(!$user['openid']){
            return callback(statecodeClass::USER_OPENID);
        }
        $openid=$user['openid'];
        $userInfo = $this->getOne(['openid'=>$openid]);
        if($userInfo['id']>0){
            return callback(statecodeClass::USER_EXIST);
        }
        $data = array (
            'openid'=>$openid,
			'nickname' => $user ['nickname'],
			'headimgurl' => trim($user['headimgurl'],'0'),
			'gender' => $user['sex']==1?1:($user['sex']==2?2:0),
			'subscribe' => intval ( $user ['subscribe'] ),
			'subscribetime' => intval ( $user ['subscribe_time'] ),
            'ivt_uid'=>intval($user['ivt_uid']),
            'limits'=>'111111000',
			'addtime' => TIMESTAMP
		);
        
        $id = $this->insert($data);
        if($id>0){
            $data['id']=$id;
            return callback(statecodeClass::SUCCESS,'',$data);
        }else{
            return callback(statecodeClass::ERROR,'',$data);
        }
    }    
    
    public function checkLimits($userID,$limit=userClass::limit_login){
        $userInfo = $this->getOne($userID,false);
        if(!$userInfo){
            return false;
        }
        return substr($userInfo['limits'],$limit-1,1)==1;
    }
    
    public function limits($limit=''){
        $limits = [
            self::limit_login=>'登录',
            self::limit_daka=>'打卡',
            self::limit_buy=>'下单',
            self::limit_score_out=>'转出',
            self::limit_score_in=>'转入',
            self::limit_score_rechage=>'充值',
        ];
        if($limit){
            if(array_key_exists($limit,$limits)){
                return $limits[$limit];
            }
            return '';
        }
        return $limits;
    }
    
	public function setLoginUser($userID){
        if($userID>0){
            setNcCookie('u_key',encrypt(serialize($userID),md5(MD5_KEY)),86400,'',null);
        }
	}
    
    public function getLoginUser(){
        $userID = unserialize(decrypt(cookie('u_key'),md5(MD5_KEY)));
		if ($userID>0){
            $user = $this->getOne($userID);
            return $user;		
		}
        return false;
    }
    
    public function getScore($userID){
        if($userID>0){
            $userInfo = $this->getOne($userID,false);
            return intval($userInfo['score']);
        }
        return 0;
    }
    
    public function exchangeSocre($userID,$score){
        return $this->where(['id'=>$userID])->setInc('score',$score);
    }
    
}
?>
