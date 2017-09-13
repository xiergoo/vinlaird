<?php
defined('InShopNC') or exit('Access Invalid!');

class userLogic {
    
    public function addUser($user){        
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
    
    public function getUser($idOrOpenid,$readCache=true){
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