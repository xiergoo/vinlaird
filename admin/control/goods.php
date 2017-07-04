<?php
/**
 * 商品栏目管理
 *
 *
 *
 *
 */

defined('InShopNC') or exit('Access Invalid!');
class goodsControl extends SystemControl{
    const EXPORT_SIZE = 5000;
    public function __construct() {
        parent::__construct ();
        Language::read('goods');
    }
    private $links = array(
		array('url'=>'act=goods&op=goods','lang'=>'nc_goods_manage'),
		array('url'=>'act=goods&op=add','lang'=>'nc_add'),
	);
    /**
     * 商品管理
     */
    public function goodsOp() {
        $goods_list = Model('goods')->order('goods_sort desc,goods_id desc')->limit(100)->select();        
        Tpl::output('goods_list', $goods_list);
        //Tpl::output('page', $model_goods->showpage(2));        
		Tpl::output('top_link',$this->sublink($this->links,'goods'));
        Tpl::showpage('goods.index');
    }
    
    public function addOp(){
		Tpl::output('top_link',$this->sublink($this->links,'add'));
        $this->save();
    }
    
    public function editOp(){
        $goods_id=intval($_REQUEST['goods_id']);
        if($goods_id>0){
            Tpl::output('top_link',$this->sublink(array_merge($this->links,[array('url'=>'act=goods&op=edit','lang'=>'nc_edit'),]),'edit'));
            $this->save($goods_id);
        }else{
            showMessage('参数错误','','html','error',1);
        }
    }
    private function save($goods_id=0){
        if(chksubmit(true)){            
            $result = Logic('goods')->save_form_data($goods_id);
            showMessage(($goods_id>0?'编辑':'新增').($result?'成功':'失败'),urlAdmin('goods','goods'));
        }else{
            if($goods_id>0){
                $goods_info = Model('goods')->where(['goods_id'=>$goods_id])->find();
                Tpl::output('goods_info',$goods_info);
                Tpl::output('action',urlAdmin('goods','edit'));
            }else{
                Tpl::output('action',urlAdmin('goods','add'));
            }
            Tpl::showpage('goods.save');
        }
    }
    
}
