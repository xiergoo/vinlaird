<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class baseEntity{
    protected $pk='id';
    protected $table='';
    protected $fields='*';
    public $id=0;
    function __construct($id=0){
        if(!$this->table){
            exit("Table Name Error");
        }
        $this->id=intval($id);
    }   
    
    public function get(){
        $data=false;
        if($this->id>0){
            if(!$this->fields){
                $field='*';
            }elseif($this->fields){
                $field=join(',',$this->fields);
            }
            $data = Model($this->table)->field($field)->find($this->id);
        }
        return $data;
    }
    
    public function getWhere($where){
        $data=false;
        if(!$this->fields || !is_array($this->fields) ){
            exit("Fields Error");
        }
        $map=false;
        foreach ($this->fields as $field)
        {
        	if(isset($where[$field]) && $where[$field]){
                $map[$field]=$where[$field];
            }
        }
        if($map){
            $data = Model($this->table)->field(join(',',$this->fields))->where($map)->find();
        }
        return $data;
    }
    
    public function add($data){
        if(!$this->fields || !is_array($this->fields) ){
            exit("Fields Error");
        }
        $insertData=[];
        foreach ($this->fields as $field)
        {
            if(isset($data[$field]) && $this->pk!=$field){
                $insertData[$field]=$data[$field];
            }
        }
        if($insertData){
            $this->id=Model($this->table)->insert($insertData);
            return $this->id;
        }else{
            return false;
        }
    }
    
    public function update($data){
        if(!$this->fields || !is_array($this->fields) ){
            exit("Fields Error");
        }
        $updateData=[];
        foreach ($this->fields as $field)
        {
            if(isset($data[$field])){
                if($this->pk==$field){
                    if($this->id!=$data[$this->pk]){
                        exit("ID Error:{$this->id} or {$data[$this->pk]}");
                    }
                }
                $updateData[$field]=$data[$field];
            }
        }
        if($updateData){
            return Model($this->table)->where([$this->pk=>$this->id])->update($updateData);
        }else{
            return false;
        }
    }
    
    public function delete(){
        if($this->id>0){
            return Model($this->table)->where([$this->pk=>$this->id])->delete();
        }
        return false;
    }
}
?>
