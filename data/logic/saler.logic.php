<?php
defined('InShopNC') or exit('Access Invalid!');

class salerLogic {
    public function save_form_data($admin_id, $saler_id=0){
        $field = ['saler_name'=>['','strval'],'saler_password'=>['','strval'],'saler_realname'=>['','strval'],'saler_level'=>[0,'intval'],'role_id'=>[0,'intval'],'store_id'=>[0,'intval'],'is_owner'=>[1,'intval'],'cash_pledge'=>[0,'intval'],'cash_status'=>[0,'intval']];
        $data = get_from_data($field);
        if(!$data['saler_realname']){
            showMessage('请输入销售商名称','','','error');
        }
        if(!$data['saler_name']){
            showMessage('请输入销售商用户名','','','error');
        } 
        if($saler_id<=0){       
            if(!$data['saler_password']){
                showMessage('请输入登录密码','','','error');
            }
            $password = hash_password($data['saler_password']);
            $data['saler_password']=$password['password'];
            $data['saler_salt']=$password['salt'];
        }
        
        if($data['saler_level']<=0){
            showMessage('请选择销售商级别','','','error');
        }
        if(!in_array($data['saler_level'],[1,2])){
            showMessage('销售商级别错误','','','error');
        }
        if($data['cash_pledge']<=0){
            showMessage('请输入押金金额','','','error');
        }
        $model = Model('saler');
        $saler_info = $model->where(['saler_realname'=>$data['saler_realname']])->find();
        if($saler_info['saler_id']>0 && $saler_info['saler_id']!=$saler_id){
            showMessage('销售商用户名已占用','','','error');            
        }
        $data['role_id']=0;
        $data['is_owner']=1;
        if($saler_id>0){
            $result = Model('saler')->where(['saler_id'=>$saler_id])->update($data);            
        }else{
            $data['create_admin_id']=$admin_id;
            $data['create_time']=TIMESTAMP;
            $result = Model('saler')->insert($data);
        }
        return $result;
    }
}