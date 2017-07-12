<?php
/**
 *销售商
 *
 */

defined('InShopNC') or exit('Access Invalid!');
class salerControl extends SystemControl{
    const EXPORT_SIZE = 5000;
    public function __construct() {
        parent::__construct ();
        Language::read('saler');
    }
    private $links = array(
		array('url'=>'act=saler&op=saler','lang'=>'nc_saler_manage'),
		array('url'=>'act=saler&op=add','lang'=>'nc_add'),
	);
    /**
     * 销售商管理
     */
    public function salerOp() {
        $saler_list = Model('saler')->where(['is_owner'=>1])->order('saler_id desc')->limit(100)->select();        
        Tpl::output('saler_list', $saler_list);
        //Tpl::output('page', $model_saler->showpage(2));        
		Tpl::output('top_link',$this->sublink($this->links,'saler'));
        Tpl::showpage('saler.index');
    }
    
    public function addOp(){
		Tpl::output('top_link',$this->sublink($this->links,'add'));
        $this->save();
    }
    
    public function editOp(){
        $saler_id=intval($_REQUEST['saler_id']);
        if($saler_id>0){
            Tpl::output('top_link',$this->sublink(array_merge($this->links,[array('url'=>'act=saler&op=edit','lang'=>'nc_edit'),]),'edit'));
            $this->save($saler_id);
        }else{
            showMessage('参数错误','','html','error',1);
        }
    }
    private function save($saler_id=0){
        if(chksubmit(true)){
            $result = Logic('saler')->save_form_data($this->admin_info['id'], $saler_id);
            showMessage(($saler_id>0?'编辑':'新增').($result?'成功':'失败'),urlAdmin('saler','saler'));
        }else{
            if($saler_id>0){
                $saler_info = Model('saler')->where(['saler_id'=>$saler_id])->find();
                Tpl::output('saler_info',$saler_info);
                Tpl::output('action',urlAdmin('saler','edit'));
            }else{
                Tpl::output('action',urlAdmin('saler','add'));
            }
            Tpl::showpage('saler.save');
        }
    }
    
    public function orderOp(){
        $result = Logic('saler')->list_order();
    }
}
