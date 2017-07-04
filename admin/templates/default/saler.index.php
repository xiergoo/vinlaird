<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_saler'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>

  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php //echo $lang['saler_index_help1'];?></li>
            <li><?php //echo $lang['saler_index_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_saler">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w36">编号</th>
          <th class="w36">名称</th>
          <th class="w36">用户名</th>
          <th class="w36">级别</th>
          <th class="w36">状态</th>
          <th class="w36">押金(元)</th>
          <th class="w36">加入时间</th>
          <th class="w36 align-center"><?php echo $lang['nc_handle'];?> </th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($output['saler_list']) && is_array($output['saler_list'])) { ?>
        <?php foreach ($output['saler_list'] as $k => $v) {?>
        <tr class="hover edit">
          <td class="align-center"><?php echo $v['saler_id'];?></td>
          <td><?php echo $v['saler_realname'];?></td>
          <td><?php echo $v['saler_name']?></td>
          <td><?php echo $v['saler_level']?></td>
          <td><?php echo $v['cash_status']?></td>
          <td><?php echo $v['cash_pledge'] ?></td>
          <td><?php echo date('Y-m-d H:i',$v['create_time']) ?></td>
          <td class="align-center"><a href="<?php echo urlAdmin('saler', 'edit', array('saler_id' => $v['saler_id']));?>"><?php echo $lang['nc_edit'];?></a></td>
        </tr>
        <tr style="display:none;">
          <td colspan="20"><div class="ncsc-saler-sku ps-container"></div></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </form>
</div>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script>

<script type="text/javascript">
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
$(function(){
	//商品分类
	init_gcselect(<?php echo $output['gc_choose_json'];?>,<?php echo $output['gc_json']?>);
	/* AJAX选择品牌 */
    $("#ajax_brand").brandinit();

    $('#ncsubmit').click(function(){
        $('input[name="op"]').val('saler');$('#formSearch').submit();
    });

    // 违规下架批量处理
    $('a[nctype="lockup_batch"]').click(function(){
        str = getId();
        if (str) {
            saler_lockup(str);
        }
    });

    // ajax获取商品列表
    $('i[nctype="ajaxsalerList"]').toggle(
        function(){
            $(this).removeClass('icon-plus-sign').addClass('icon-minus-sign');
            var _parenttr = $(this).parents('tr');
            var _commonid = $(this).attr('data-comminid');
            var _div = _parenttr.next().find('.ncsc-saler-sku');
            if (_div.html() == '') {
                $.getJSON('index.php?act=saler&op=get_saler_list_ajax' , {commonid : _commonid}, function(date){
                    if (date != 'false') {
                        var _ul = $('<ul class="ncsc-saler-sku-list"></ul>');
                        $.each(date, function(i, o){
                            $('<li><div class="saler-thumb" title="商家货号：' + o.saler_serial + '"><a href="' + o.url + '" target="_blank"><image src="' + o.saler_image + '" ></a></div>' + o.saler_spec + '<div class="saler-price">价格：<em title="￥' + o.saler_price + '">￥' + o.saler_price + '</em></div><div class="saler-storage">库存：<em title="' + o.saler_storage + '">' + o.saler_storage + '</em></div><a href="' + o.url + '" target="_blank" class="ncsc-btn-mini">查看商品详情</a></li>').appendTo(_ul);
                            });
                        _ul.appendTo(_div);
                        _parenttr.next().show();
                        // 计算div的宽度
                        _div.css('width', document.body.clientWidth-54);
                        _div.perfectScrollbar();
                    }
                });
            } else {
            	_parenttr.next().show()
            }
        },
        function(){
            $(this).removeClass('icon-minus-sign').addClass('icon-plus-sign');
            $(this).parents('tr').next().hide();
        }
    );
});

// 获得选中ID
function getId() {
    var str = '';
    $('#form_saler').find('input[name="id[]"]:checked').each(function(){
        id = parseInt($(this).val());
        if (!isNaN(id)) {
            str += id + ',';
        }
    });
    if (str == '') {
        return false;
    }
    str = str.substr(0, (str.length - 1));
    return str;
}

// 商品下架
function saler_lockup(ids) {
    _uri = "<?php echo ADMIN_SITE_URL;?>/index.php?act=saler&op=saler_lockup&id=" + ids;
    CUR_DIALOG = ajax_form('saler_lockup', '违规下架理由', _uri, 350);
}
</script>
