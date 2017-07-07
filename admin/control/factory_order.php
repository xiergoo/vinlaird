<?php
/**
 * 工厂订单管理
 */

defined('InShopNC') or exit('Access Invalid!');
class factory_orderControl extends SystemControl{
    const EXPORT_SIZE = 5000;
    public function __construct() {
        parent::__construct ();
    }
    private $links = array(
		array('url'=>'act=factory_order&op=factory_order','lang'=>'nc_factory_order_list'),
		array('url'=>'act=factory_order&op=add','lang'=>'nc_add'),
	);
    
    public function factory_orderOp(){
        $fo_list = Model('factory_order')->order('fo_id desc')->page(20)->select();
        if($fo_list){            
            foreach ($fo_list as $key=>$li)
            {
            	$fo_list[$key]['fo_status']=$this->get_fo_status_str($li['fo_status']);
                $fo_list[$key]['pay_status']=$li['pay_status']==1?'已支付':'未支付';
            }
            $factory_id = array_column($fo_list,'factory_id');
            $goods_id = array_column($fo_list,'goods_id');
            $factory_list = Model('factory')->field('factory_id,factory_name')->where(['factory_id'=>['in',$factory_id]])->select();
            $factory_list = array_value_to_key($factory_list,'factory_id');
            $goods_list = Model('goods')->field('goods_id,goods_name')->where(['goods_id'=>['in',$goods_id]])->select();
            $goods_list = array_value_to_key($goods_list,'goods_id');
            Tpl::output('factory_list',$factory_list);
            Tpl::output('goods_list',$goods_list);
        }
        Tpl::output('fo_list', $fo_list); 
		Tpl::output('top_link',$this->sublink($this->links,'listorder'));
        Tpl::showpage('factory_order.factory_order');
    }
    
    public function addOp(){
		Tpl::output('top_link',$this->sublink($this->links,'add'));
        $this->save();
    }
    
    public function editOp(){
        $fo_id=intval($_REQUEST['fo_id']);
        if($fo_id>0){
            Tpl::output('top_link',$this->sublink(array_merge($this->links,[array('url'=>'act=factory_order&op=edit','lang'=>'nc_edit'),]),'edit'));
            $this->save($fo_id);
        }else{
            showMessage('参数错误','','html','error',1);
        }
    }
    
    public function viewOp(){
        $fo_id=intval($_REQUEST['fo_id']);
        if($fo_id>0){
            Tpl::output('top_link',$this->sublink(array_merge($this->links,[array('url'=>'act=factory_order&op=view','lang'=>'nc_view'),]),'view'));
            Tpl::output('view',1);
            $this->save($fo_id);
        }else{
            showMessage('参数错误','','html','error',1);
        }
    }
    
    public function save($fo_id=0){
        if(chksubmit(true)){
            $result = Logic('factory_order')->save_form_data($this->admin_info['id'],$fo_id);
            showMessage(($factory_id>0?'编辑':'新增').($result?'成功':'失败'),urlAdmin('factory','listorder'));
        }else{
            $factory_id=0;
            if($fo_id>0){
                $fo_info = Model('factory_order')->where(['fo_id'=>$fo_id])->find();
                if($fo_info['factory_id']>0){
                    $factory_id=$fo_info['factory_id'];
                    $fo_info['fo_status_str']=$this->get_fo_status_str($fo_info['fo_status']);
                    Tpl::output('fo_info',$fo_info);
                }
            }else{
                $factory_id = intval($_GET['factory_id']);
            }
            
            if($factory_id>0){
                $factory_info = Model('factory')->where(['factory_id'=>$factory_id])->find();
                if($factory_info['factory_id']<=0){
                    showMessage('无效的工厂ID','','','error');
                }
                if($factory_info['factory_status']!=1){
                    showMessage('该工厂未启用，请先弃用后再下定单','','','error');
                }
                Tpl::output('factory_id',$factory_id);
                
                $goods_list = [];
                $goods_ids = explode(',',$factory_info['factory_goods']);
                if($goods_ids){
                    $goods_list = Model('goods')->where(['goods_id'=>['in',$goods_ids],'can_factory_order'=>1])->order('goods_sort desc,goods_id desc')->limit(100)->select();
                    Tpl::output('goods_list',$goods_list);
                }                
            }
            $factory_list = Model('factory')->order('factory_sort desc,factory_id desc')->limit(100)->select();
            Tpl::output('factory_list', $factory_list); 
            Tpl::showpage('factory_order.save');
        }
    }
    
    public function getfgoodsOp(){
        if(Security::checkToken()){
            $factory_id = intval($_POST['factory_id']);
            if($factory_id>0){                
                $factory_info = Model('factory')->where(['factory_id'=>$factory_id])->find();
                if($factory_info['factory_id']<=0){
                    output_json(1,'无效的工厂id');
                }
                $goods_list = [];
                $goods_ids = explode(',',$factory_info['factory_goods']);
                if($goods_ids){
                    $goods_list = Model('goods')->where(['goods_id'=>['in',$goods_ids],'can_factory_order'=>1])->order('goods_sort desc,goods_id desc')->limit(100)->select();
                }
                output_json(0,'',$goods_list);
            }else{
                output_json(1,'缺少必要参数');
            }
        }else{
            output_json(1,'页面已过期，请刷新页面后重试');
        }
    }
    
    private function get_fo_status_str($fo_status){
        $status_list = [0=>'取消',1=>'计划采购（待审核）',2=>'已审核',3=>'生产完成（已入库）'];
        if(array_key_exists($fo_status,$status_list)){
            return $status_list[$fo_status];
        }
        return '';
    }
}
