<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>猜大盘</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="email=no" name="format-detection">
    <link href="/static/css/weui.min.css" rel="stylesheet" />
</head>
    <?php $peroid = $output['period'] ?>
<body>
    <div class="container" id="container">
        <div style="background-color: #F43530; padding: 2px 0px 2px 15px; font-size: 23px">
            <b>第<?php echo $peroid['pno']; ?>期</b><span style="font-size:18px">（<?php echo date('m月d日H',$peroid['jtime']); ?>点开）</span>
        </div>
        <hr style="margin: 1px 0px 10px 0px" />
        <div style="padding-left: 10px"><?php for($i=0;$i<50;$i++){ ?><button style="margin:3px;" class="weui-btn weui-btn_mini weui-btn_plain-default btn_num" id="btn_num_<?php echo sprintf('%02d',$i); ?>" data-num="<?php echo sprintf('%02d',$i); ?>"><?php echo sprintf('%02d',$i); ?></button><?php } ?></div>
        <hr style="margin: 13px 0px 13px 0px" />
        <div>
            <label style="margin: 0px 10px 0px 10px">已选</label><span id="span_selected"></span>
        </div>
        <hr style="margin: 13px 0px 1px 0px" />
        <div style="padding-left: 13px;">
            <button class="weui-btn weui-btn_mini weui-btn_plain-primary">100</button>
            <button class="weui-btn weui-btn_mini weui-btn_plain-primary weui-btn_plain-disabled">1000</button>
            <button class="weui-btn weui-btn_mini weui-btn_plain-primary">2000</button>
            <button class="weui-btn weui-btn_mini weui-btn_plain-primary">5000</button>
            <button class="weui-btn weui-btn_mini weui-btn_plain-primary">10000</button>
        </div>
        <hr style="margin: 13px 0px 13px 0px" />
        <div style="padding-left: 13px;">
            <label style="margin: 0px 20px 0px 0px">所需积分</label><span id="span_socre"></span>
        </div>
        <hr style="margin: 13px 0px 13px 0px" />
        <div>
            <button class="weui-btn weui-btn_primary">确定</button>
        </div>
    </div>
</body>
<script src="/static/js/jquery-3.2.1.min.js"></script>
<script>
    $(function () {
        $(".btn_num").click(function () {
            var btn = $(this);
            if (btn.attr('data-hide') == 1) {
                return false;
            }
            btn.attr('data-hide', 1);
            if ($("#span_selected").children().length >= 5) {
                alert('最多5个');
                return false;
            }
            btn.addClass('weui-btn_plain-disabled');
            $("#span_selected").append('<button style="margin:3px;" class="weui-btn weui-btn_mini weui-btn_plain-default" onclick="cancel_selected(this)" data-num="' + btn.attr('data-num') + '">' + btn.attr('data-num') + '</button>');

        })

    })
    function cancel_selected(obj) {
        var btn = $(obj);
        var btn_num = $("#btn_num_" + btn.attr('data-num'));
        btn_num.attr('data-hide', 0);
        btn_num.removeClass('weui-btn_plain-disabled');
        btn.remove();
    }
</script>
</html>
