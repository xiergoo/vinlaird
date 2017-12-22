<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class baseEntity extends Model{
    function __construct(){
        if(!$this->table_name){
            exit("Table Name Error");
        }
        if(!$this->fields || !is_array($this->fields) ){
            exit("Fields Error");
        }
        parent::__construct($this->table);
    }
}
?>
