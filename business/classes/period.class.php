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
    const socre_min=100;
    const socre_max=1000000;
    
    protected $table_name='period';
    protected $fields=['id','type_id','pno','jtime','pstatus','dpnum','jnum','inscore','outscore','ctime'];
    
    public function listsing(){
        $typeCacheKey='listsingtype';
        $listType = $this->cache($typeCacheKey);
        if(!$listType){
            $listType = typeClass::I()->lists(['enable'=>typeClass::status_enable]);
            $this->cache($typeCacheKey,$listType);
        }
        foreach ($listType as $type)
        {
        	$period = $this->getOne(['type_id'=>$type['id'],'jtime'=>['gt',dapanClass::beforeTime()]]);
            if(!$period){
                $this->newPeroid($type['id']);
            }
        }
        $where['jtime']=['between',[dapanClass::beforeTime()+1,dapanClass::afterTime()]];
        $where['pstatus']=self::status_online;
        return parent::lists($where);
    }
    
    public function newPeroid($typeID){
        $typeClass = typeClass::I();
        $typeInfo = $typeClass->getOne($typeID,false);
        if($typeInfo['id'] && $typeInfo['enable']==typeClass::status_enable){
            $where['type_id']=$typeID;
            $where['jtime']=['between',[dapanClass::beforeTime()+1,dapanClass::afterTime()]];
            $where['pstatus']=self::status_online;
            $curPeroid = $this->getOne($where,false);
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
                return $this->insert($data);
            }            
        }
        return false;
    }
}
?>
