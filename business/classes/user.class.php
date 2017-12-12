<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class userClass extends baseClass{    
    public function getEntity(){
        return baseClass::E('userEntity');
    }
    
    public function addUser($user){
        if(!$user['openid']){
            return callback(statecode::LOGIC_USER_OPENID);
        }
        $openid=$user['openid'];
        $userInfo = $this->getWhere(['openid'=>$openid]);
        if($userInfo['id']>0){
            return callback(statecode::LOGIC_USER_EXIST);
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
        
        $id = $this->getEntity()->add($data);
        if($id>0){
            $data['id']=$id;
            return callback(statecode::SUCCESS,'',$data);
        }else{
            return callback(statecode::ERROR,'',$data);
        }
    }
    
    const limit_login=1;
    const limit_daka=2;
    const limit_buy=3;
    const limit_score_out=4;
    //5,6,7默认允许，先占用
    const limit_score_in=8;
    const limit_score_rechage=9;
    public function checkLimits($uid,$limit=userClass::limit_login){
        $user_info = $this->get($uid,false);
        if(!$user_info){
            return false;
        }
        return substr($user_info['limits'],$limit-1,1)==1;
    }
}
?>
