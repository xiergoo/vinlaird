<?php

defined('InShopNC') or exit('Access Invalid!');

class periodControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('index');
	}
	public function indexOp(){
		
	}
}
