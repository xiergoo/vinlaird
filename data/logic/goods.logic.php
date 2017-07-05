<?php
defined('InShopNC') or exit('Access Invalid!');

class goodsLogic {
        
    public function save_form_data($goods_id=0){
        $field = ['goods_name'=>'','goods_market_price'=>[0,'intval'],'goods_buy_price'=>[0,'intval'],'goods_stock'=>[0,'intval'],'stock_warning'=>[0,'intval'],'goods_sort'=>[0,'intval'],'can_order'=>[0,'intval'],'can_saler_order'=>[0,'intval'],'can_factory_order'=>[0,'intval']];
        $data = get_from_data($field);
        if(!$data['goods_name']){
            showMessage('请输入商品名','','','error');
        }
        if($data['goods_market_price']<=0){
            showMessage('请输入商品市场价','','','error');
        }
        if($data['goods_buy_price']<=0){
            showMessage('请输入商品成本价','','','error');
        }
        if($data['goods_market_price']<=$data['goods_buy_price']){
            showMessage('商品市场价不能低于成本价','','','error');
        }
        if($data['stock_warning']<=0){
            showMessage('请输入商品库存预警值','','','error');
        }
        $data['can_order']=$data['can_order']>0?1:0;
        $data['can_saler_order']=$data['can_saler_order']>0?1:0;
        $data['can_factory_order']=$data['can_factory_order']>0?1:0;
        if($goods_id>0){
            $data['update_time']=TIMESTAMP;
            $result = Model('goods')->where(['goods_id'=>$goods_id])->update($data);            
        }else{
            $data['create_time']=$data['update_time']=TIMESTAMP;
            $result = Model('goods')->insert($data);
        }
        return $result;
    }
}