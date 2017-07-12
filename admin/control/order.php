<?php
/**
 * 订单管理
 */

defined('InShopNC') or exit('Access Invalid!');
class orderControl extends SystemControl{
    const EXPORT_SIZE = 5000;
    public function __construct() {
        parent::__construct ();
        Language::read('order');
    }
    private $links = array(
		array('url'=>'act=order&op=order','lang'=>'nc_order_manage'),
		array('url'=>'act=order&op=add','lang'=>'nc_add'),
	);
    /**
     * 订单管理
     */
    public function orderOp() {
        $order_list = Model('order')->order('order_id desc')->limit(100)->select();        
        Tpl::output('order_list', $order_list);
        //Tpl::output('page', $model_order->showpage(2));        
		Tpl::output('top_link',$this->sublink($this->links,'order'));
        Tpl::showpage('order.index');
    }
    
    public function addOp(){
		Tpl::output('top_link',$this->sublink($this->links,'add'));
        $this->save();
    }
    
    public function editOp(){
        $order_id=intval($_REQUEST['order_id']);
        if($order_id>0){
            Tpl::output('top_link',$this->sublink(array_merge($this->links,[array('url'=>'act=order&op=edit','lang'=>'nc_edit'),]),'edit'));
            $this->save($order_id);
        }else{
            showMessage('参数错误','','html','error',1);
        }
    }
    private function save($order_id=0){
        if(chksubmit(true)){
            $result = Logic('order')->save_form_data($order_id);
            showMessage(($order_id>0?'编辑':'新增').($result?'成功':'失败'),urlAdmin('order','order'));
        }else{
            if($order_id>0){
                $order_info = Model('order')->where(['order_id'=>$order_id])->find();
                Tpl::output('order_info',$order_info);
                Tpl::output('action',urlAdmin('order','edit'));
            }else{
                Tpl::output('action',urlAdmin('order','add'));
            }
            Tpl::showpage('order.save');
        }
    }
    
}
