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
    
    /**
     * Summary of order
     * @param mixed $saler_id 
     * @param mixed $goods_id 
     * @param mixed $goods_num 
     * @param mixed $goods_price 折扣后的价格
     * @param mixed $so_amount 
     * @return mixed
     */
    public function order($saler_id,$goods_id,$goods_num,$goods_price,$so_amount){
        if($saler_id>0){
            if($saler_id<=0){
                return callback(false,'无效的销售商id');
            }
            if($goods_id<=0){
                return callback(false,'无效的商品id');
            }
            if($goods_num<=0){
                return callback(false,'无效的商品数量');
            }
            if($goods_price<=0){
                return callback(false,'无效的商品单价');
            }
            if($$so_amount<=0){
                return callback('无效的商品总价','','','error');
            }
            $goods_info = Model('goods')->where(['goods_id'=>$data['goods_id']])->find();
            if($saler_info['saler_status']!=1){
                return callback(false,'帐号已经禁用，请与平台联系');        
            }
            $saler_info = Model('saler')->where(['saler_id'=>$data['saler_id']])->find();
            if(!$goods_info['can_saler_order']){
                return callback(false,'抱歉，该商品暂时停止订货，请与平台联系');        
            }
            
            global $setting_config;
            if($saler_info['saler_level']==1){
                $rate = $setting_config['goods_price_rate_vip1'];
            }else{
                $rate = $setting_config['goods_price_rate_vip2'];
            }
            if( price_format($goods_info['goods_buy_price']*$rate)!=price_format($goods_price)){
                return callback(false,'商品价格有误');
            }            
            if(price_format($goods_price*$goods_num) != price_format($so_amount) ){
                return callback(false,'订单金额有误');
            }
            $data['saler_id']=$saler_id;
            $data['goods_id']=$goods_id;
            $data['goods_price']=price_format($goods_price);
            $data['goods_num']=$goods_num;
            $data['so_amount']=price_format($so_amount);
            $data['so_status']=1;
            $data['check_admin_id']=0;
            $data['check_time']=0;
            $data['create_time']=TIMESTAMP;
            $result = Model('saler_order')->insert($data);
            if($result){
                return callback(true,'订货成功',$result);
            }else{
                return callback(false,'订单金额有误');
            }
        }
    }
    
    public function checking($so_id,$status,$admin_id){
        if($so_id>0 && $admin_id>0){
            if(in_array($status,[2,0])){
                return callback(false,'参数错误');
            }            
            $model = Model('saler_order');
            $so_info = $model->where(['so_id'=>$so_id])->find();
            if($so_info['so_status']==1){
                $update['so_status']=$status==2?2:0;
                $update['check_admin_id']=$admin_id;
                $update['check_time']=TIMESTAMP;
                $result = $model->where(['so_id'=>$so_id])->update($update);
                if($result){
                    return callback(true,'审核'.($update['so_status']==2?'':'不').'通过');
                }else{
                    return callback(false,'审核失败');
                }
            }else{
                return callback(false,'状态错误');
            }            
        }else{
            return callback(false,'参数缺失');
        }
        
    }
}