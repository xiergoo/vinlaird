<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class baseClass extends Model{
    public function __construct(){
        if(!$this->table_name){
            exit("Table Name Error");
        }
        if(!$this->fields || !is_array($this->fields) ){
            exit("Fields Error");
        }
        parent::__construct($this->table);
    }    
    private static $i=null;
    public static function I(){        
        $class = get_called_class();        
        if(self::$i[$class]===null){
            self::$i[$class]=new $class;
        }
        return self::$i[$class];
    }
        
    public function getOne($where,$cache=true){
        $data=null;
        if($where){
            $key=md5(serialize($where));
            if($cache){
                $data=$this->cache($key);
            }
            if(!$data){
                if(is_numeric($where)){
                    $where=[$this->get_pk()=>intval($where)];
                }    
                $data=$this->where($where)->find();
                if($data){
                    $this->cache($key,$data,86400);
                }
            }
            return $data;
        }
    }
        
    public function lists($where=[],$order='',$page_size=20){     
        if(!$order){
            $order=$this->get_pk().' desc';
        }
        $map=[];
        if(is_array($where) && count($where)){
            foreach ($this->getFields() as $field){
                if(isset($where[$field]) && $where[$field]){
                    $map[$field]=$where[$field];
                }
            }
        }elseif(is_string($where)){
            $map=$where;
        }
        $result=$this->where($map)->order($order)->page($page_size)->select();
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
