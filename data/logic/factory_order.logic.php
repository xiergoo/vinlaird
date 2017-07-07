<?php
defined('InShopNC') or exit('Access Invalid!');

class factory_orderLogic {    
    public function save_form_data($admin_id,$fo_id=0){
        $field = ['factory_id'=>[0,'intval'],'goods_id'=>[0,'intval'],'cost_price'=>[0,'floatval'],'goods_num'=>[0,'intval'],'pay_amount'=>[0,'floatval']];
        $data = get_from_data($field);
        if($data['factory_id']<=0){
            showMessage('请选择工厂','','','error');
        }
        if($data['goods_id']<=0){
            showMessage('请选择商品','','','error');
        }
        if($data['cost_price']<=0){
            showMessage('成本价格必须大于0，请设置商品成本价','','','error');
        }
        if($data['goods_num']<=0){
            showMessage('请输入商品数量','','','error');
        }
        if($data['pay_amount']<=0){
            showMessage('应付金额计算有误','','','error');
        }
        $model = Model('factory_order');
        if($fo_id>0){
            $fo_info = $model->where(['fo_id'=>$fo_id])->find();
            if($fo_info['fo_status']>1){
                showMessage('该订单已经审核，不能修改','','','error');                
            }
            $result = $model->where(['fo_id'=>$fo_id])->update($data);            
        }else{
            $data['fo_status']=1;
            $data['pay_status']=0;
            $data['pay_time']=0;
            $data['check_time']=0;
            $data['check_admin_id']=0;
            $data['finish_time']=0;
            $data['finish_admin_id']=0;
            $data['cancel_time']=0;
            $data['cancel_admin_id']=0;
            $data['create_admin_id']=$admin_id;
            $data['create_time']=TIMESTAMP;
            $result = $model->insert($data);
        }
        return $result;
    }
}