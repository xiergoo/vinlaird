<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class baseClass{    
    private function __construct(){}    
    private static $i=null;
    public static function I(){        
        $class = get_called_class();        
        if(self::$i[$class]===null){
            self::$i[$class]=new $class;
        }
        return self::$i[$class];
    }
    
    private static $e=null;
    public static function E($entity){     
        if(self::$e[$entity]===null){
            self::$e[$entity]=new $entity;
        }
        return self::$e[$entity];
    }
    
    public function get($id,$cache=true){
        $data=null;
        if($id>0){
            if($cache){
                $data=$this->cache($id);
            }
            if(!$data){
                if(!method_exists($this,'getEntity')){
                    exit(get_called_class().' method getEntity not defined');
                }
                $entity=$this->getEntity();                
                $entity->id=$id;
                $data=$entity->get();
                if($data){
                    $this->cache($id,$data);
                }
            }
            return $data;
        }
    }
    
    public function getWhere($where,$cache=true){
        $data=null;
        if($where){
            $key = md5(join('',$where));
            if($cache){
                $data=$this->cache($key);
            }
            if(!$data){
                if(!method_exists($this,'getEntity')){
                    exit(get_called_class().' method getEntity not defined');
                }
                $entity=$this->getEntity();
                $data=$entity->getWhere($where);
                if($data){
                    $this->cache($key,$data);
                }
            }
            return $data;
        }
    }
    
    /**
     * 此缓存只存单条数据
     * @param mixed $subkey 
     * @param mixed $value 
     * @return mixed
     */
    protected function cache($subkey,$value=''){
        $data=null;
        $class = get_called_class();
        $key=$class.$subkey;
        if($value===''){
            $data=rcache($key);
        }elseif($value===null){
            dcache($key);
        }else{
            wcache($key,$value,'',864000);
        } 
        return $data;
    }
}
?>
