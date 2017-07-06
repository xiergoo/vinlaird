<?php
/**
 * 工厂管理
 */

defined('InShopNC') or exit('Access Invalid!');
class factoryControl extends SystemControl{
    const EXPORT_SIZE = 5000;
    public function __construct() {
        parent::__construct ();
    }
    private $links = array(
		array('url'=>'act=factory&op=factory','lang'=>'nc_factory_manage'),
		array('url'=>'act=factory&op=add','lang'=>'nc_add'),
	);
    /**
     * 工厂管理
     */
    public function factoryOp() {
        $factory_list = Model('factory')->order('factory_sort desc,factory_id desc')->limit(100)->select();
        Tpl::output('factory_list', $factory_list); 
		Tpl::output('top_link',$this->sublink($this->links,'factory'));
        Tpl::showpage('factory.index');
    }
    
    public function addOp(){
		Tpl::output('top_link',$this->sublink($this->links,'add'));
        $this->save();
    }
    
    public function editOp(){
        $factory_id=intval($_REQUEST['factory_id']);
        if($factory_id>0){
            Tpl::output('top_link',$this->sublink(array_merge($this->links,[array('url'=>'act=factory&op=edit','lang'=>'nc_edit'),]),'edit'));
            $this->save($factory_id);
        }else{
            showMessage('参数错误','','html','error',1);
        }
    }
    private function save($factory_id=0){
        if(chksubmit(true)){
            $result = Logic('factory')->save_form_data($factory_id);
            showMessage(($factory_id>0?'编辑':'新增').($result?'成功':'失败'),urlAdmin('factory','factory'));
        }else{
            if($factory_id>0){
                $factory_info = Model('factory')->where(['factory_id'=>$factory_id])->find();
                Tpl::output('factory_info',$factory_info);
                Tpl::output('action',urlAdmin('factory','edit'));
            }else{
                Tpl::output('action',urlAdmin('factory','add'));
            }
            $goods_list = Model('goods')->order('goods_sort desc,goods_id desc')->limit(100)->select();
            Tpl::output('goods_list',$goods_list);
            Tpl::showpage('factory.save');
        }
    }
    
    public function listOp(){
        $factory_order_list = Model('factory_order')->order('fo_id desc')->page(20)->select();
    }
    
    public function orderOp(){
        if(chksubmit(true)){
            
        }else{
            $factory_id = intval($_GET['factory_id']);
            if($factory_id>0){
                $factory_info = Model('factory')->where(['factory_id'=>$factory_id])->find();
                if($factory_info['factory_id']<=0){
                    showMessage('无效的工厂ID','','','error');
                }
                if($factory_info['factory_status']!=1){
                    showMessage('该工厂未启用，请先弃用后再下定单','','','error');
                }
                Tpl::output('factory_id',$factory_id);
            }            
            $factory_list = Model('factory')->order('factory_sort desc,factory_id desc')->limit(100)->select();            
            Tpl::output('top_link',$this->sublink(array_merge($this->links,[array('url'=>'act=factory&op=order','lang'=>'nc_factory_order'),]),'order'));
            Tpl::output('factory_list', $factory_list); 
            Tpl::showpage('factory.order');
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
}
