<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class periodClass extends baseClass{
    const status_offline=0;
    const status_online=1;
    const status_wait=2;
    const status_finish=3;    
    const protected_time=120;
    const socre_min=1000;
    const socre_max=1000000;
    
    /**
     * Summary of getEntity
     * @return periodEntity
     */
    public function getEntity(){
        return baseClass::E('periodEntity');
    }
    
    public function listsing(){
        $where['jtime']=['between',[dapanClass::beforeTime()+1,dapanClass::afterTime()]];
        $where['pstatus']=self::status_online;
        return parent::lists($where);
    }
    
    public function newPeroid($typeID){
        $typeClass = typeClass::I();
        $typeInfo = $typeClass->find($typeID,false);
        if($typeInfo['id'] && $typeInfo['enable']==typeClass::status_enable){
            $where['type_id']=$typeID;
            $where['jtime']=['between',[dapanClass::beforeTime()+1,dapanClass::afterTime()]];
            $where['pstatus']=1;
            $curPeroid = $this->find($where,false);
            if(!$curPeroid){
                $beforePeriod = parent::lists(['type_id'=>$typeID],'pno desc',1);
                $data['type_id']=$typeID;
                $data['pno']=max(100,intval($beforePeriod[0]['pno'])+1);
                $data['pstatus']=self::status_online;
                $data['jtime']=dapanClass::afterTime();
                $data['dpnum']=0;
                $data['jnum']=0;
                $data['inscore']=0;
                $data['outscore']=0;
                $data['ctime']=TIMESTAMP;
                return $this->getEntity()->insert($data);
            }            
        }
        return false;
    }
}
?>
