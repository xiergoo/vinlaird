<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class userEntity extends baseEntity{
    protected $table='user';
    protected $fields=['id','openid','nickname','headimgurl','gender','subscribe','subscribetime','ivt_uid','limits','mobile','addtime'];   
}
?>