<?php
defined('InShopNC') or exit('Access Invalid!');
class statecodeClass{

    const SUCCESS       = '0';
    const ERROR       = '1';
    const TOKENERR = '9999';
    const PARAMSERR = '9998';
    const UNLOGIN = '9997';
    
    const ORDER_UID = '8001';
    const ORDER_LIMIT='8002';
    const ORDER_PID='8003';
    const ORDER_PNOTEXIST='8004';
    const ORDER_SCORE='8007';
    const ORDER_NOSCORE='8008';
    const ORDER_SCOREERR='8009';
    const ORDER_ORDERERR='8010';
    
    const SOCRE_UID='8101';
    const SOCRE_LIMIT='8102';
    const SOCRE_VALUE='8103';
    const SOCRE_ORDER='8104';
    const SOCRE_UID2='8105';
    const SOCRE_COUNT='8106';
    const SOCRE_LESS='8107';
    const SOCRE_CHANGE_USER_SCORE_FAIL='8108';
    const SOCRE_INSERT_DETAIL_FAIL='8109';
    
    const USER_OPENID='8201';
    const USER_EXIST='8202';
    const USER_LOGIN_FORBIDDEN='8203';
    
    const PERIOD_ID_ERROR='8301';
    const PERIOD_NOT_EXIST='8302';
    const PERIOD_OFFLINE='8303';
    const PERIOD_NO_START='8304';
    const PERIOD_FINISHED_WILL_OPEN='8305';
    const PERIOD_FINISHED='8306';
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
            case self::ORDER_UID: $msg='无效的用户id'; break;
            case self::ORDER_LIMIT: $msg='无效的操作'; break;
            case self::ORDER_PID: $msg='无效的pid'; break;
            case self::ORDER_PNOTEXIST: $msg='本期不存在'; break;
            case self::ORDER_SCORE: $msg='无效的积分数量'; break;
            case self::ORDER_NOSCORE: $msg='积分不足'; break;
            case self::ORDER_SCOREERR: $msg='积分数量有误'; break;
            case self::ORDER_ORDERERR: $msg='订单插入失败'; break;

            case self::SOCRE_UID: $msg='无效的用户id'; break;
            case self::SOCRE_LIMIT: $msg='无效的操作'; break;
            case self::SOCRE_VALUE: $msg='无效的积分值'; break;
            case self::SOCRE_ORDER: $msg='无效的订单ID'; break;
            case self::SOCRE_UID2: $msg='无效的赠出用户id'; break;
            case self::SOCRE_COUNT: $msg='至少赠送10000积分'; break;
            case self::SOCRE_LESS: $msg='积分数量不足'; break;
            #endregion
            case self::USER_OPENID: $msg='无效的openid'; break;
            case self::USER_EXIST: $msg='用户已存在'; break;
            
            
            case self::PERIOD_FINISHED: $msg='本期购买已结束'; break;
            case self::PERIOD_FINISHED_WILL_OPEN: $msg='本期购买已结束，即将揭晓'; break;

        }
        
        return $msg;
    }
}