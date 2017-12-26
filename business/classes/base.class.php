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
    
    /**
     * Summary of getEntity
     * @return baseEntity
     */
    public function getEntity(){
        static $entity=null;
        if($entity===null){
            $entity=new baseEntity();
        }
        return $entity;
    }
    
    public function find($where,$cache=true){
        $data=null;
        if($where){
            $key=md5(serialize($where));
            if($cache){
                $data=$this->cache($key);
            }
            if(!$data){
                $entity=$this->getEntity();
                if(is_numeric($where)){
                    $where=[$entity->get_pk()=>intval($where)];
                }    
                $data=$entity->where($where)->find();
                if($data){
                    $this->cache($key,$data,86400);
                }
            }
            return $data;
        }
    }
        
    public function lists($where=[],$order='',$page_size=20){
        $entity = $this->getEntity();        
        if(!$order){
            $order=$entity->get_pk().' desc';
        }
        $map=[];
        if(is_array($where) && count($where)){
            foreach ($entity->getFields() as $field){
                if(isset($where[$field]) && $where[$field]){
                    $map[$field]=$where[$field];
                }
            }
        }elseif(is_string($where)){
            $map=$where;
        }
        $result=$entity->where($map)->order($order)->page($page_size)->select();
        return $result;
    }
    
    /**
     * 此缓存只存单条数据
     * @param mixed $subkey 
     * @param mixed $value 
     * @return mixed
     */
    protected function cache($subkey,$value='',$expired=300){
        $data=null;
        $class = get_called_class();
        $key=$class.$subkey;
        if($value===''){
            $data=rcache($key);
        }elseif($value===null){
            dcache($key);
        }else{
            $expired=max(1,$expired);
            $expired=min(864000,$expired);
            wcache($key,$value,'',$expired);
        } 
        return $data;
    }
    
}
?>
