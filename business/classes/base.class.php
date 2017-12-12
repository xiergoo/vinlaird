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
    
    protected function cache($id,$value=''){
        $data=null;
        if($id>0){
            $class = get_called_class();
            $key=$class.$id;
            if($value===''){
                $data=rcache($key);
            }elseif($value===null){
                dcache($key);
            }else{
                wcache($key,$value,'',864000);
            }            
        }
        return $data;
    }
}
?>
