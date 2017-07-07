<?php
defined('InShopNC') or exit('Access Invalid!');

class factoryLogic {
    public function save_form_data($factory_id=0){
        $field = ['factory_name'=>['','strval'],'factory_goods'=>[[]],'factory_status'=>[0,'intval'],'factory_sort'=>[0,'intval'],'factory_mark'=>['','strval']];
        $data = get_from_data($field);
        if(!$data['factory_name']){
            showMessage('请输入工厂名','','','error');
        }        
        $data['factory_status']=$data['factory_status']==1?1:0;
        $data['factory_goods']=implode(',',$data['factory_goods']);
        if($factory_id>0){
            $result = Model('factory')->where(['factory_id'=>$factory_id])->update($data);            
        }else{
            $data['create_time']=TIMESTAMP;
            $result = Model('factory')->insert($data);
        }
        return $result;
    }    
}