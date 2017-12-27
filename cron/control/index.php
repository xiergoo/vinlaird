<?php
/**
 ***/

defined('InShopNC') or exit('Access Invalid!');
class indexControl extends BaseControl{
    
    public function indexOp(){
        try
        {
        	$this->openPrize();
        }
        catch (Exception $exception)
        {
            $this->log($exception);
        }
    }
    
    public function openPrize(){
        $listType = typeClass::I()->lists();
        foreach ($listType as $type)
        {
        	$periodInfo = periodClass::I()->where(['type_id'=>$type['id'],'pstatus'=>periodClass::status_online,'jtime'=>['eq',dapanClass::beforeTime()]])->find();
            if($periodInfo['id']>0){
                $data['dpnum']=dapanClass::value();
                if($data['dpnum']>1000){
                    $data['jnum']=$data['dpnum']*100%$type['mod'];
                    $data['pstatus']=periodClass::status_wait;
                    $result = periodClass::I()->where(['id'=>$period_info['id']])->update($data);
                    if($result){
                        Model('order')->where(['pid'=>$periodInfo['id'],'num'=>$data['jnum']])->update(['is_right'=>1]);
                    }
                }
            }
        }        
    }       
}
