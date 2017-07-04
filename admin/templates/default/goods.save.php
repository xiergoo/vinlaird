<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3><?php echo $lang['goods_index_goods'];?></h3>
            <?php echo $output['top_link'];?>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form id="goods" name="goodsForm" method="post" action="<?php echo $output['action'] ?>">
        <?php Security::getToken(); ?>
        <input type="hidden" name="form_submit" value="ok" />
        <input type="hidden" name="goods_id" value="<?php echo $output['goods_info']['goods_id'];?>" />
        <table class="table tb-type2">
            <tbody>
                <tr class="noborder">
                    <td colspan="2" class="required">
                        <label class="gc_name validation">商品名称:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php echo $output['goods_info']['goods_name'];?>" name="goods_name" id="goods_name" class="txt"></td>
                    <td class="vatop tips">商品名称</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required">
                        <label class="gc_name validation">市场价:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php echo $output['goods_info']['goods_market_price'];?>" name="goods_market_price" id="goods_market_price" class="txt"></td>
                    <td class="vatop tips">商品市场价格，用于计算销售商折扣的基数</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required">
                        <label class="gc_name validation">成本价:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php echo $output['goods_info']['goods_buy_price'];?>" name="goods_buy_price" id="goods_buy_price" class="txt"></td>
                    <td class="vatop tips">商品生产成本，用于给工厂结算成本</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required">
                        <label class="gc_name validation">库存:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php echo $output['goods_info']['goods_stock'];?>" name="goods_stock" id="goods_stock" class="txt"></td>
                    <td class="vatop tips">实时库存，尽量不要修改</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required">
                        <label class="gc_name validation">库存预警:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php echo $output['goods_info']['stock_warning'];?>" name="stock_warning" id="stock_warning" class="txt"></td>
                    <td class="vatop tips">当实时库存小于该值，会通知相关人员</td>
                </tr>                
                <tr>
                    <td colspan="2" class="required">
                        <label for="gc_sort"><?php echo $lang['nc_sort'];?>:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php if(isset($output['goods_info']['goods_sort'])){echo $output['goods_info']['goods_sort'];}else{ echo '1000';} ?>" name="goods_sort" id="goods_sort" class="txt"></td>
                    <td class="vatop tips">更新排序，越大越靠前，默认1000</td>
                </tr>
                <?php if($output['goods_info']['sale_count']>0){ ?>
                <tr class="noborder">
                    <td colspan="2" class="required">
                        <label class="gc_name validation">总销售量:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" readonly value="<?php echo $output['goods_info']['sale_count'];?>" class="txt"></td>
                    <td class="vatop tips">历史累计总销售量</td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="2" class="required">
                        <label>是否可售:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform onoff">
                        <label for="can_order1" class="cb-enable <?php if($output['goods_info']['can_order']){ ?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
                        <label for="can_order0" class="cb-disable <?php if(!$output['goods_info']['can_order']){ ?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
                        <input id="can_order1" name="can_order" <?php if($output['goods_info']['can_order']){ ?>checked="checked"<?php }?> value="1" type="radio">
                        <input id="can_order0" name="can_order" <?php if(!$output['goods_info']['can_order']){ ?>checked="checked"<?php }?> value="0" type="radio">
                    </td>
                    <td class="vatop tips">用户是否可以购买（发货）</td>
                </tr>
                <tr>
                    <td colspan="2" class="required">
                        <label>是否可订货:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform onoff">
                        <label for="can_saler_order1" class="cb-enable <?php if($output['goods_info']['can_saler_order']){ ?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
                        <label for="can_saler_order0" class="cb-disable <?php if(!$output['goods_info']['can_saler_order']){ ?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
                        <input id="can_saler_order1" name="can_saler_order" <?php if($output['goods_info']['can_saler_order']){ ?>checked="checked"<?php }?> value="1" type="radio">
                        <input id="can_saler_order0" name="can_saler_order" <?php if(!$output['goods_info']['can_saler_order']){ ?>checked="checked"<?php }?> value="0" type="radio">
                    </td>
                    <td class="vatop tips">销售商是否可以订货</td>
                </tr>
                <tr>
                    <td colspan="2" class="required">
                        <label>是否可生产:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform onoff">
                        <label for="can_factory_order1" class="cb-enable <?php if($output['goods_info']['can_factory_order']){ ?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
                        <label for="can_factory_order0" class="cb-disable <?php if(!$output['goods_info']['can_factory_order']){ ?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
                        <input id="can_factory_order1" name="can_factory_order" <?php if($output['goods_info']['can_factory_order']){ ?>checked="checked"<?php }?> value="1" type="radio">
                        <input id="can_factory_order0" name="can_factory_order" <?php if(!$output['goods_info']['can_factory_order']){ ?>checked="checked"<?php }?> value="0" type="radio">
                    </td>
                    <td class="vatop tips">是否可以给工厂下定单</td>
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
            if ($("#goods").valid()) {
                $("#goods").submit();
            }
        });
    });
</script>
