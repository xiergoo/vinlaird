<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3><?php echo $lang['nc_saler'];?></h3>
            <?php echo $output['top_link'];?>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form id="saler" name="salerForm" method="post" action="<?php echo $output['action'] ?>">
        <?php Security::getToken(); ?>
        <input type="hidden" name="form_submit" value="ok" />
        <input type="hidden" name="saler_id" value="<?php echo $output['saler_info']['saler_id'];?>" />
        <table class="table tb-type2">
            <tbody>
                <tr class="noborder">
                    <td colspan="2" class="required">
                        <label class="gc_name validation">销售商名称:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php echo $output['saler_info']['saler_realname'];?>" name="saler_realname" id="saler_realname" class="txt"></td>
                    <td class="vatop tips">销售商名称，用于理解区分销售商，如：姓名</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required">
                        <label class="gc_name validation">销售商用户名:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" <?php if($output['saler_info']['saler_id']>0){ echo 'readonly'; } ?> value="<?php echo $output['saler_info']['saler_name'];?>" name="saler_name" id="saler_name" class="txt"></td>
                    <td class="vatop tips">销售商用户名，用于系统登录，最好用英文，不能重复，不能修改</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required">
                        <label class="gc_name validation">密码:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="" name="saler_password" id="saler_password" class="txt" placeholder="修改其他信息时不要填写"></td>
                    <td class="vatop tips">与用户名对应，用于登录</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required">
                        <label class="gc_name validation">销售商等级:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <select name="saler_level"><option value="">请选择</option>
                            <option value="1" <?php if($output['saler_info']['saler_level']==1){ echo 'selected'; } ?>>普通销售商</option>
                            <option value="2" <?php if($output['saler_info']['saler_level']==2){ echo 'selected'; } ?>>VIP销售商</option></select>
                    <td class="vatop tips">销售商等级，不同的等级对应不同的押金和折扣</td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required">
                        <label class="gc_name validation">押金:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input type="text" value="<?php echo $output['saler_info']['cash_pledge'];?>" name="cash_pledge" id="cash_pledge" class="txt"></td>
                    <td class="vatop tips">押金金额，单位为元</td>
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
            if ($("#saler").valid()) {
                $("#saler").submit();
            }
        });
    });
</script>
