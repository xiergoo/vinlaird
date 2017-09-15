<?php
defined('InShopNC') or exit('Access Invalid!');

class userLogic {
    const limit_login=1;
    const limit_daka=2;
    const limit_buy=3;
    const limit_score_out=4;
    //5,6,7默认允许，先占用
    const limit_score_in=8;
    const limit_score_rechage=9;
    public function limits($uid,$limit){
        $user_info = $this->get_user($uid);
        if(!$user_info){
            return false;
        }
        return substr($user_info['limits'],$limit-1,1)==1;
    }
    
    public function add_user($user){        
        if(!$user['openid']){
            return callback(1,'无效的openid');
        }
        $model = Model('user');
        $openid=$user['openid'];
        $userInfo = $model->where(['openid'=>$data['openid']])->find();
        if($userInfo['id']>0){
            return callback(1,'用户已存在');
        }
        $data = array (
            'openid'=>$openid,
			'nickname' => $user ['nickname'],
			'headimgurl' => trim($user['headimgurl'],'0'),
			'gender' => $user['sex']==1?1:($user['sex']==2?2:0),
			'subscribe' => intval ( $user ['subscribe'] ),
			'subscribetime' => intval ( $user ['subscribe_time'] ),
            'limits'=>'1111111',
			'addtime' => TIMESTAMP
		);
        $id = $model->insert($data);
        if($id>0){
            $data['id']=$id;
            return callback(true,'',$data);
        }else{
            return callback(false,'',$data);
        }
    }
    
    public function get_user($idOrOpenid,$readCache=true){
        $userInfo=null;
        if($idOrOpenid>0){
            $where['id']=$idOrOpenid;
        }else{
            $where['openid']=$idOrOpenid;
        }
        if($readCache){
            $key=md5('userLogic_getUser_'.$idOrOpenid);
            $userInfo=rcache($key);
        }
        if(!$userInfo){
            $model = Model('user');
            $userInfo = $model->where($where)->find();
            if($userInfo['id']>0){
                wcache($key,$userInfo);
            }
        }
        return $userInfo;
    }

}