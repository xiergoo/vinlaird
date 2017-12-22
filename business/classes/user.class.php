<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class userClass extends baseClass{
    /**
     * Summary of getEntity
     * @return userEntity
     */
    public function getEntity(){
        return baseClass::E('userEntity');
    }
    
    public function addUser($user){
        if(!$user['openid']){
            return callback(statecodeClass::USER_OPENID);
        }
        $openid=$user['openid'];
        $userInfo = $this->getWhere(['openid'=>$openid]);
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
            'limits'=>'111111111',
			'addtime' => TIMESTAMP
		);
        
        $id = $this->getEntity()->insert($data);
        if($id>0){
            $data['id']=$id;
            return callback(statecodeClass::SUCCESS,'',$data);
        }else{
            return callback(statecodeClass::ERROR,'',$data);
        }
    }
    
    const limit_login=1;
    const limit_daka=2;
    const limit_buy=3;
    const limit_score_out=4;
    const limit_score_in=5;
    const limit_score_rechage=6;
    //7¡¢8¡¢9±£Áô£¬ÔÝÎ´Ê¹ÓÃ
    public function checkLimits($uid,$limit=userClass::limit_login){
        $user_info = $this->find($uid,false);
        if(!$user_info){
            return false;
        }
        return substr($user_info['limits'],$limit-1,1)==1;
    }
}
?>
