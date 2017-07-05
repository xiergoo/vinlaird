<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3><?php echo $lang['nc_factory'];?></h3>
            <?php echo $output['top_link'];?>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form id="factory" name="factoryForm" method="post" action="<?php echo $output['action'] ?>">
        <?php Security::getToken(); ?>
        <input type="hidden" name="form_submit" value="ok" />
        <input type="hidden" name="factory_id" value="<?php echo $output['factory_info']['factory_id'];?>" />
        <table class="table tb-type2">
            <tbody>
                <tr class="noborder">
                    <td colspan="2" class="required">
                        <label class="validation" for="factory_name">工厂名称:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php echo $output['factory_info']['factory_name'];?>" name="factory_name" id="factory_name" class="txt"></td>
                    <td class="vatop tips">工厂名称</td>
                </tr>
                <tr>
                    <td colspan="2" class="required">
                        <label for="factory_sort"><?php echo $lang['nc_sort'];?>:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php if(isset($output['factory_info']['factory_sort'])){echo $output['factory_info']['factory_sort'];}else{ echo '1000';} ?>" name="factory_sort" id="factory_sort" class="txt"></td>
                    <td class="vatop tips">更新排序，越大越靠前，默认1000</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label for="factory_mark">备注:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <textarea name="factory_mark" style="width:400px;height:100px;"><?php if(isset($output['factory_info']['factory_mark'])){echo $output['factory_info']['factory_mark'];} ?></textarea>
                        </td>
                    <td class="vatop tips">可以不填写</td>
                </tr>
                <?php if (!empty($output['goods_list']) && is_array($output['goods_list'])) { ?>
                <tr>
                    <td colspan="2" class="required">
                        <label>关联商品:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <ul class="nofloat w830">
                            <?php $f_goods=[]; if(isset($output['factory_info']['factory_goods'])){ $f_goods=explode(',',$output['factory_info']['factory_goods']); }  ?>
                            <?php foreach ($output['goods_list'] as $k => $v) {?>
                            <li class="left w18pre">
                                <label>
                                    <input type="checkbox" name="factory_goods[]" value="<?php echo $v['goods_id'] ?>" <?php if(in_array($v['goods_id'],$f_goods)){ echo 'checked'; } ?> >
                                    &nbsp;<?php echo $v['goods_name'] ?></label>
                            </li>
                            <?php } ?>
                    </td>
                    <td class="vatop tips">该工厂生产的商品</td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="2" class="required">
                        <label>是否启用:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform onoff">
                        <label for="factory_status1" class="cb-enable <?php if($output['factory_info']['factory_status']){ ?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
                        <label for="factory_status0" class="cb-disable <?php if(!$output['factory_info']['factory_status']){ ?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
                        <input id="factory_status1" name="factory_status" <?php if($output['factory_info']['factory_status']){ ?>checked="checked"<?php }?> value="1" type="radio">
                        <input id="factory_status0" name="factory_status" <?php if(!$output['factory_info']['factory_status']){ ?>checked="checked"<?php }?> value="0" type="radio">
                    </td>
                    <td class="vatop tips">是否可以订货，启用后可以订货</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="tfoot">
                    <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
<script>
    $(document).ready(function () {
        //按钮先执行验证再提交表单
        $("#submitBtn").click(function () {
            if ($("#factory").valid()) {
                $("#factory").submit();
            }
        });
    });
</script>
