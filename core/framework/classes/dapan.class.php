<?php
/**
 */
defined('InShopNC') or exit('Access Invalid!');
Class dapanClass{
	public static function value(){
        try
        {
            $key='lib_dapan_value';        
            $value = 0;
            $value = rcache($key);
            if($value && $value>0){
                return $value;
            }
            $arr=[];
            $content = http_curl_get('http://hq.sinajs.cn/list=s_sh000001');
            if($content){
                $arr=explode(',',$content);
                $value=$arr[1];
            }
            $value = round($value,2);
            if($value>1000){
                wcache($key,$value);
            }
            return $value;  
        }
        catch (Exception $exception)
        {
            return 0;
        }        
    }
    
}
?>
