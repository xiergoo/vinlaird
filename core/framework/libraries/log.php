<?php
/**
 * 记录日志 
 *
 * 
 */
defined('InShopNC') or exit('Access Invalid!');
class Log{

    const SQL       = 'SQL';
    const ERR       = 'ERR';
    const INFO      ='INFO';
    private static $log =   array();

    public static function info($message){
        self::record($message,self::INFO);
    }
    
    public static function record($message,$level=self::ERR) {
        if(is_object($message)){
            $message=(array)$message;
        }
        if(is_array($message)){
            $message=var_export($message,true);
        }
        if(!is_string($message)){
            $message=(string)$message;
        }
        $now = @date('Y-m-d H:i:s',time());
        switch ($level) {
            case self::SQL:
               self::$log[] = "[{$now}] {$level}: {$message}\r\n";
                break;
            case self::INFO:
            case self::ERR:
                $dir = BASE_DATA_PATH.'/log/'.MODULES.'/'.$_GET['act'].'/';
                if(!is_dir($dir)){
                    mkdir($dir,0777,true);
                }
                $log_file = $dir.date('Ymd',TIMESTAMP).'.log';
                $url = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF'];
                $url .= " ( act={$_GET['act']}&op={$_GET['op']} ) ";
                $content = "[{$now}] {$url}\r\n{$level}: {$message}\r\n";
                file_put_contents($log_file,$content, FILE_APPEND);
                break;
        }
    }

    public static function read(){
    	return self::$log;
    }
}