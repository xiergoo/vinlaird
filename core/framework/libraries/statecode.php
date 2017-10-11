<?php
defined('InShopNC') or exit('Access Invalid!');
class statecode{

    const SUCCESS       = '0';
    const ERROR       = '1';
    const TOKENERR = '9999';
    const PARAMSERR = '9998';
    const UNLOGIN = '9997';
    
    const LOGIC_ORDER_UID = '8001';
    const LOGIC_ORDER_LIMIT='8002';
    const LOGIC_ORDER_PID='8003';
    const LOGIC_ORDER_PNOTEXIST='8004';
    const LOGIC_ORDER_POVER='8005';
    const LOGIC_ORDER_POVER2='8006';
    const LOGIC_ORDER_SCORE='8007';
    const LOGIC_ORDER_NOSCORE='8008';
    const LOGIC_ORDER_SCOREERR='8009';
    const LOGIC_ORDER_ORDERERR='8010';
    
    const LOGIC_SOCRE_UID='8101';
    const LOGIC_SOCRE_LIMIT='8102';
    const LOGIC_SOCRE_VALUE='8103';
    const LOGIC_SOCRE_ORDER='8104';
    const LOGIC_SOCRE_UID2='8105';
    const LOGIC_SOCRE_COUNT='8106';
    
    const LOGIC_USER_OPENID='8201';
    const LOGIC_USER_EXIST='8202';
    public static function msg($state){
        $msg='';
        switch ($state)
        {
            #region
            case self::ERROR: $msg='错误'; break;
            case self::SUCCESS: $msg='成功'; break;
            case self::UNLOGIN: $msg='请先登录'; break;
            case self::TOKENERR: $msg='无效的请求，请刷新后再试'; break;
            case self::PARAMSERR: $msg='参数错误，请刷新后再试'; break;
            case self::LOGIC_ORDER_UID: $msg='无效的用户id'; break;
            case self::LOGIC_ORDER_LIMIT: $msg='无效的操作'; break;
            case self::LOGIC_ORDER_PID: $msg='无效的pid'; break;
            case self::LOGIC_ORDER_PNOTEXIST: $msg='本期不存在'; break;
            case self::LOGIC_ORDER_POVER: $msg='本期购买已结束'; break;
            case self::LOGIC_ORDER_POVER2: $msg='本期购买已结束，即将揭晓'; break;
            case self::LOGIC_ORDER_SCORE: $msg='无效的积分数量'; break;
            case self::LOGIC_ORDER_NOSCORE: $msg='积分不足'; break;
            case self::LOGIC_ORDER_SCOREERR: $msg='积分数量有误'; break;
            case self::LOGIC_ORDER_ORDERERR: $msg='订单插入失败'; break;

            case self::LOGIC_SOCRE_UID: $msg='无效的用户id'; break;
            case self::LOGIC_SOCRE_LIMIT: $msg='无效的操作'; break;
            case self::LOGIC_SOCRE_VALUE: $msg='无效的积分值'; break;
            case self::LOGIC_SOCRE_ORDER: $msg='无效的订单ID'; break;
            case self::LOGIC_SOCRE_UID2: $msg='无效的赠出用户id'; break;
            case self::LOGIC_SOCRE_COUNT: $msg='至少赠送10000积分'; break;
            #endregion
            case self::LOGIC_USER_OPENID: $msg='无效的openid'; break;
            case self::LOGIC_USER_EXIST: $msg='用户已存在'; break;

        }
        
        return $msg;
    }
}