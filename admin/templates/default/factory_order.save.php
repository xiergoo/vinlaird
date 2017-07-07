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
        <?php $readonly=' '; $disabled=''; if($output['view']){ $readonly=' readonly '; $disabled=' disabled=disabled '; } ?>
        <input type="hidden" name="form_submit" value="ok" />
        <table class="table tb-type2">
            <tbody>
                <tr class="noborder">
                    <td colspan="2" class="required">
                        <label class="validation" for="factory_id">工厂:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <select name="factory_id" id="factory_id" <?php echo $disabled ?> >
                            <option>请选择</option>
                            <?php foreach ($output['factory_list'] as $factory) { ?>
                            <option value="<?php echo $factory['factory_id'] ?>" <?php if($factory['factory_id']==$output['factory_id']){ echo 'selected'; } ?> ><?php echo $factory['factory_name'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td class="vatop tips">请选择工厂</td>
                </tr>
                <tr>
                    <td colspan="2" class="required">
                        <label class="validation" for="goods_id">商品:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <select name="goods_id" id="goods_id" <?php echo $disabled ?>>
                            <option>请选择</option>
                            <?php foreach ($output['goods_list'] as $goods) { ?>
                            <option value="<?php echo $goods['goods_id'] ?>" <?php if($goods['goods_id']==$output['fo_info']['goods_id']){ echo 'selected'; } ?> ><?php echo $goods['goods_name'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td class="vatop tips">请先选择工厂，再选择商品</td>
                </tr>
                <tr>
                    <td colspan="2" class="required">
                        <label class="validation" for="goods_num">单位成本价:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php echo $output['fo_info']['cost_price']; ?>" id="cost_price" readonly class="txt">
                        <input type="hidden" value="<?php echo $output['fo_info']['cost_price']; ?>" name="cost_price" id="cost_price1" class="txt"></td>
                    <td class="vatop tips">单位成本价，选择商品后，自动填充</td>
                </tr>
                <tr>
                    <td colspan="2" class="required">
                        <label class="validation" for="goods_num">数量:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php echo $output['fo_info']['goods_num']; ?>" name="goods_num" id="goods_num" class="txt" onkeyup="numonly(this)" <?php echo $readonly ?>></td>
                    <td class="vatop tips">请填写数量</td>
                </tr>
                <tr>
                    <td colspan="2" class="required">
                        <label class="validation" for="pay_amount">应付金额:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php echo $output['fo_info']['pay_amount']; ?>" id="pay_amount" readonly class="txt">
                        <input type="hidden" value="<?php echo $output['fo_info']['pay_amount']; ?>" name="pay_amount" id="pay_amount1" class="txt"></td>
                    <td class="vatop tips">订单应付金额，选择工厂和商品后，自动填充</td>
                </tr>
                <?php if($output['view']){ ?>
                <tr>
                    <td colspan="2">
                        <label><b>订单状态:&nbsp;</b><?php echo $output['fo_info']['fo_status_str'] ?></label>
                        <br />
                        <br />
                        <label>
                            <b>相关信息:&nbsp;</b>
                            <?php if($output['fo_info']['fo_status']==0){
                                      echo '采购申请时间：'.date('Y-m-d H:i:s',$output['fo_info']['create_time']).' 申请人ID：'.$output['fo_info']['create_admin_id'].'<br>取消时间：'.date('Y-m-d H:i:s',$output['fo_info']['cancel_time']).' 取消操作ID：'.$output['fo_info']['cancel_admin_id'];
                                  }elseif($output['fo_info']['fo_status']==1){
                                      echo '采购申请时间：'.date('Y-m-d H:i:s',$output['fo_info']['create_time']).' 申请人ID：'.$output['fo_info']['create_admin_id'];
                                  }elseif($output['fo_info']['fo_status']==2){
                                      echo '采购申请时间：'.date('Y-m-d H:i:s',$output['fo_info']['create_time']).' 申请人ID：'.$output['fo_info']['create_admin_id'].'<br>审核时间：'.date('Y-m-d H:i:s',$output['fo_info']['check_time']).' 审核人ID：'.$output['fo_info']['create_admin_id'];
                                  }elseif($output['fo_info']['fo_status']==3){
                                      echo '采购申请时间：'.date('Y-m-d H:i:s',$output['fo_info']['create_time']).' 申请人ID：'.$output['fo_info']['create_admin_id'].'<br>审核时间：'.date('Y-m-d H:i:s',$output['fo_info']['check_time']).' 审核人ID：'.$output['fo_info']['create_admin_id'].'<br>入库时间：'.date('Y-m-d H:i:s',$output['fo_info']['finish_time']).' 入库人ID：'.$output['fo_info']['finish_admin_id'];
                                  } ?></label>

                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label><b>支付状态:&nbsp;</b><?php if($output['fo_info']['pay_status']==1){ echo '已支付，支付时间：'.date('Y-m-d H:i:s',$output['fo_info']['pay_time']); }else{ echo '未支付'; } ?></label></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr class="tfoot">
                    <td colspan="15">
                        <?php if($output['view']){ ?>
                        <a href="JavaScript:history.back();" class="btn"><span><?php echo $lang['nc_back'];?></span></a>
                        <?php }else{ ?>
                        <a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a>
                        <?php } ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    <div id="divhide" style="display: none;"></div>
</div>
<script>
    $(document).ready(function () {
        //按钮先执行验证再提交表单
        $("#submitBtn").click(function () {
            if ($("#factory").valid()) {
                $("#factory").submit();
            }
        });
        $("#factory_id").change(function () {
            $("#goods_num").val('');
            cost_price('');
            pay_amount('');
            var factory_id = $("#factory_id").val();
            if (factory_id > 0) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo urlAdmin('factory','getfgoods') ?>',
                    data: { factory_id: factory_id, formhash: '<?php echo Security::getTokenValue(); ?>' },
                    dataType: 'json',
                    success: function (result) {
                        if (result.code > 0) {
                            alert(result.message);
                            $("#goods_id").html('<option>请选择</option>');
                        } else {
                            var html = '<option>请选择</option>';
                            var info = '';
                            var data = result.data;
                            for (o in data) {
                                html += '<option value="' + data[o].goods_id + '">' + data[o].goods_name + '</option>';
                                info += '<input type="hidden" id="goods_buy_price_' + data[o].goods_id + '" value="' + data[o].goods_buy_price + '" />';
                            }
                            $("#goods_id").html(html);
                            $("#divhide").html(info);
                        }
                    }
                });
            } else {
                $("#goods_id").html('<option>请选择</option>');
            }
        });

        $("#goods_id").change(function () {
            $("#goods_num").val('');
            pay_amount('');
            var goods_id = $("#goods_id").val();
            if (goods_id > 0) {
                var buy_price = $("#goods_buy_price_" + goods_id).val();
                cost_price(buy_price);
            } else {
                cost_price('');
            }
        });

        $("#goods_num").blur(function () {
            var num = $("#goods_num").val();
            var price = $("#cost_price").val();
            if (num > 0 && price > 0) {
                pay_amount((num * price).toFixed(2));
            } else {
                pay_amount('');
            }
        });
    });

    function pay_amount(val) {
        $("#pay_amount").val(val);
        $("#pay_amount1").val(val);
    }

    function cost_price(val) {
        $("#cost_price").val(val);
        $("#cost_price1").val(val);
    }

    function numonly(obj) {
        obj.value = obj.value.replace(/[^\d]/g, ""); //清除"数字"和"."以外的字符
        obj.value = obj.value.replace(/^0/g, ""); //验证第一个字符是数字
        obj.value = obj.value.replace(/\.{2,}/g, "."); //只保留第一个, 清除多余的
        obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
        obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/, '$1$2.$3'); //只能输入两个小数
    }
</script>
