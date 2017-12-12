<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class typeClass{    
    private function __construct(){}    
    private static $i=null;
    public static function I(){
        if(self::$i===null){
            self::$i=new self;
        }
        return self::$i;
    }
    
    public function getTypeInfo($id,$cache=true){
        $typeInfo=null;
        if($id>0){
            if($cache){
                $typeInfo=$this->cache($id);
            }
            if(!$typeInfo){
                $typeEntity=new typeEntity($id);
                $typeInfo=$typeEntity->toArr();
                if($typeInfo){
                    $this->cache($id,$typeInfo);
                }
            }
            return $typeInfo;
        }
    }
    
    public function cache($id,$value=''){
        $typeInfo=null;
        if($id>0){
            $key='business_type_getTypeInfo_'.$id;
            if($value===''){
                $typeInfo=rcache($key);
            }elseif($value===null){
                dcache($key);
            }else{
                wcache($key,$value,'',864000);
            }            
        }
        return $typeInfo;
    }
}
?>
