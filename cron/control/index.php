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
                
                $dpnum=dapanClass::value();
                if($dpnum>1000){
                    $jnum=$dpnum*100%$type['mod'];
                    Model::beginTransaction();
                    $result = Model('order')->where(['pid'=>$periodInfo['id'],'num'=>$jnum])->update(['is_right'=>1,'prize_score'=>['exp',$type['times'].'*score']]);
                    if($result){
                        $inScore=Model('order')->where(['pid'=>$periodInfo['id']])->sum('score');
                        $outScore=Model('order')->where(['pid'=>$periodInfo['id'],'is_right'=>1])->sum('prize_score');
                        $data['dpnum']=$dpnum;
                        $data['jnum']=$jnum;
                        $data['inscore']=$inScore;
                        $data['outscore']=$outScore;
                        $data['pstatus']=periodClass::status_wait;
                        $result = periodClass::I()->where(['id'=>$period_info['id']])->update($data);
                        if($result){
                            Model::commit();
                        }else{
                            Model::rollback();
                        }
                    }else{
                        Model::rollback();
                    }
                }
            }
        }        
    }
}
