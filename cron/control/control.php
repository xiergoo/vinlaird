<?php
/**
 ***/

defined('InShopNC') or exit('Access Invalid!');
class BaseControl{
    function __construct(){        
        if (PHP_SAPI !='cli'){//只能在CLI模式下执行计划任务
            if(!C('debug')){
                die;
            }
        }
        register_shutdown_function(array($this, 'destruct'));
        $this->log('#start#');
        // 判断锁
		if ($this->lock ()) {
			$this->log ( 'locked' );
			die;
		}
		// 加锁
		$this->lock ( true );
    }
    
	/**
     * 防止重复执行
     *
     * @param mixed $process_and_check        	
     * @return mixed
     */
	protected function lock($lock = null) {
		$lock_file = BASE_DATA_PATH.'/log/'.'lock_'.$_GET['act'].'_'.$_GET['op'];
		if ($lock === null) {
			return file_exists ( $lock_file );
		}
		if ($lock) {
			file_put_contents ( $lock_file, date ( 'Y-m-d H:i:s' ) );
			chmod ( $lock_file, 0777 );
		} else {
			if (file_exists ( $lock_file )) {
				unlink ( $lock_file );
			}
		}
	}
	function destruct() {
		$this->lock ( false );
        $this->log('#end#');
	}
	
	/**
     * 写日志
     *
     * @param
     *        	string | array $message
     */
	protected function log($message, $level = 'INFO',$sub_file='') {        
        if(is_object($message)){
            $message=(array)$message;
        }
        if(is_array($message)){
            $message=var_export($message,true);
        }
        if(!is_string($message)){
            $message=(string)$message;
        }
        $dir = BASE_DATA_PATH.'/log/'.MODULES.'/'.$_GET['act'].'/';
        if(!is_dir($dir)){
            mkdir($dir,0777,true);
        }
        $now = @date('Y-m-d H:i:s',time());
        $log_file = $dir.$sub_file.date('Ymd',TIMESTAMP).'.log';
        $content = "[{$now}]\r\n{$level}: {$message}\r\n";
        file_put_contents($log_file,$content, FILE_APPEND);
	}    
}
