<?php

defined('InShopNC') or exit('Access Invalid!');

class periodControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('index');
	}
	public function indexOp(){
        $pnum=intval($_GET['pnum']);
        $where=[];
        if($pnum>=100){
            $where['pnum']=$pnum;
        }
        $list = Model('period')->where($where)->order('id desc')->page(20)->select();        
        $page=pagecmd('obj');
        Tpl::output('_page',$page->show());
	}
    
    public function openPrizeOp(){
        if(IS_POST){
            $periodID=intval($_POST['id']);
            $periodInfo=periodClass::I()->getOne($periodID);
            $type = typeClass::I()->getOne($periodInfo['type_id'],false);
            if($periodInfo['pstatus']==periodClass::status_online){
                $dpnum=floatval($_POST['dpnum']);
                $jnum=$dpnum*100%$type['mod'];
                Model::beginTransaction();
                $result = Model('order')->where(['pid'=>$periodInfo['id'],'num'=>$jnum])->update(['is_right'=>1,'prize_score'=>['exp',$type['times'].'*score']]);
                if($result){
                    $inScore=Model('order')->where(['pid'=>$periodInfo['id']])->sum('score');
                    $outScore=Model('order')->where(['pid'=>$periodInfo['id'],'is_right'=>1])->sum('prize_score');
                    $data['dpnum']=$dpnum;
                    $data['jnum']=$jnum;
                    $data['inscore']=$inScore;
                    $data['outscore']=$outScore;
                    $data['pstatus']=periodClass::status_wait;
                    $result = periodClass::I()->where(['id'=>$period_info['id']])->update($data);
                    if($result){
                        Model::commit();
                        showMessage('³É¹¦');
                    }else{
                        Model::rollback();
                        showMessage('Ê§°Ü');
                    }
                }else{
                    Model::rollback();
                    showMessage('Ê§°Ü');
                }                
            }elseif($periodInfo['pstatus']==periodClass::status_wait){
                Model::beginTransaction();
                $result = Model('order')->where(['pid'=>$periodInfo['id'],'num'=>$periodInfo['jnum']])->update(['is_right'=>1,'prize_score'=>['exp',$type['times'].'*score']]);
                if($result){
                    $inScore=Model('order')->where(['pid'=>$periodInfo['id']])->sum('score');
                    $outScore=Model('order')->where(['pid'=>$periodInfo['id'],'is_right'=>1])->sum('prize_score');                    
                    $data['inscore']=$inScore;
                    $data['outscore']=$outScore;
                    $result = periodClass::I()->where(['id'=>$period_info['id']])->update($data);
                    if($result){
                        Model::commit();
                        showMessage('³É¹¦');
                    }else{
                        Model::rollback();
                        showMessage('Ê§°Ü');
                    }
                }else{
                    Model::rollback();
                    showMessage('Ê§°Ü');
                } 
            }
        }else{
        }
    }
}
