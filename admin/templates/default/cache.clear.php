<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['cache_cls_operate'];?></h3>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="cache_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table nobdb">
      <tbody>
        <tr>
          <td colspan="2"><table class="table nomargin">
              <tbody>
                <tr>
                  <td class="required"><input id="cls_full" name="cls_full" value="1" type="checkbox">
                    &nbsp;
                    <label for="cls_full"><?php echo $lang['cache_cls_all'];?></label></td>
                </tr>
                <tr class="noborder">
                  <td class="vatop rowform"><ul class="nofloat w830">
                      <li class="left w18pre">
                        <label>
                          <input type="checkbox" name="cache[]" value="setting" >
                          &nbsp;基础缓存</label>
                      </li>                      
                    </ul></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
//按钮先执行验证再提交表
$(function(){
	$("#submitBtn").click(function(){
		if($('input[name="cache[]"]:checked').size()>0){
			$("#cache_form").submit();
		}
	});

	$('#cls_full').click(function(){
		$('input[name="cache[]"]').attr('checked',$(this).attr('checked') == 'checked');
	});
});
</script>
