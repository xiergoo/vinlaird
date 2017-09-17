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
        <!--F43530 E64340 CE3C39-->
        <div style="background-color: #F43530; padding: 10px 0px 10px 18px; font-size: 23px">
            <b>第<?php echo $peroid['pno']; ?>期进行中</b><span style="font-size: 18px">（<?php echo date('m月d日H',$peroid['jtime']); ?>点开）</span>
        </div>
        <hr style="margin: 1px 0px 10px 0px" />
        <div style="padding-left: 10px"><?php for($i=0;$i<50;$i++){ ?><button style="margin:3px;" class="weui-btn weui-btn_mini weui-btn_plain-default btn_num" id="btn_num_<?php echo sprintf('%02d',$i); ?>"><?php echo sprintf('%02d',$i); ?></button><?php } ?></div>
        <hr style="margin: 13px 0px 13px 0px" />
        <div>
            <label style="margin: 0px 10px 0px 10px">已选</label><span id="span_selected"></span>
        </div>
        <hr style="margin: 13px 0px 1px 0px" />
        <div style="padding-left: 13px;">
            <?php foreach ($output['times'] as $index=>$times)
                  {
            ?>
            <button class="weui-btn weui-btn_mini weui-btn_plain-primary btn_score_times<?php if ($index==1){ echo ' weui-btn_plain-disabled'; } ?>"><?php echo $times; ?></button>
            <?php
                  }
            ?>
        </div>
        <hr style="margin: 13px 0px 13px 0px" />
        <div style="padding-left: 13px;">
            <label style="margin: 0px 20px 0px 0px">所需积分</label><span id="span_socre"></span>
        </div>
        <hr style="margin: 13px 0px 13px 0px" />
        <div>
            <button class="weui-btn weui-btn_primary weui-btn_disabled btn_submit">请选号码</button>
        </div>
    </div>
    <div id="toast" style="display: none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i id="toast_icon" class="weui-icon-success weui-icon_toast"></i>
            <p id="toast_msg" class="weui-toast__content">已完成</p>
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
            if ($("#span_selected").children().length >= 5) {
                toast_msg(false, '一次最多选择5个号码');
                return false;
            }
            btn.attr('data-hide', 1);
            btn.addClass('weui-btn_plain-disabled');
            $("#span_selected").append('<button style="margin:3px;" class="weui-btn weui-btn_mini weui-btn_plain-default" onclick="cancel_selected(this)">' + btn.html() + '</button>');
            calc_socre();
        })

        $(".btn_score_times").click(function () {
            if ($(this).hasClass('weui-btn_plain-disabled')) {
                return false;
            }
            $(".btn_score_times").removeClass('weui-btn_plain-disabled');
            $(this).addClass('weui-btn_plain-disabled');
            times = parseInt($(this).text());
            calc_socre();
        })

        $(".btn_submit").click(function () {
            var btn = $(this);
            if (btn.hasClass('weui-btn_disabled')) {
                return false;
            }
            $.ajax({
                type: 'POST',
                url: '<?php echo url('index','commit') ?>',
                data: { 'pid': '<?php echo $peroid['id']; ?>', 'formhash': '<?php echo Security::getTokenValue(); ?>', 'score': score, 'times': times, 'num': num },
                dataType: 'json',
                success: function (result) {
                    if (result.state > 0) {
                        toast_msg(false, result.msg);
                    } else {
                        toast_msg(true);
                        set_default();
                    }
                }
            });
        })
    })

    function toast_msg(success,msg) {
        var $toast = $('#toast');
        if (success) {
            $("#toast_icon").attr('class','weui-icon-success-no-circle weui-icon_toast');
            $("#toast_msg").html('下单成功');
        } else {
            $("#toast_icon").attr('class', 'weui-icon-warn weui-icon_toast');
            $("#toast_msg").html(msg);
        }
        if ($toast.css('display') != 'none') return;

        $toast.fadeIn(100);
        setTimeout(function () {
            $toast.fadeOut(100);
        }, 2000);
    }
    function set_default() {
        $(".btn_num").attr('data-hide', 0);
        $(".btn_num").removeClass('weui-btn_plain-disabled');
        $("#span_selected").html('');
        $(".btn_score_times").removeClass('weui-btn_plain-disabled');
        $(".btn_score_times:eq(1)").addClass('weui-btn_plain-disabled');
        times = default_times;
        calc_socre();
    }

    function cancel_selected(obj) {
        var btn = $(obj);
        var btn_num = $("#btn_num_" + btn.html());
        btn_num.attr('data-hide', 0);
        btn_num.removeClass('weui-btn_plain-disabled');
        btn.remove();
        calc_socre();
    }
    var score = 0;
    var times = parseInt('<?php echo intval($output['times'][1]); ?>');
    var default_times = times;
    var num = '';
    function calc_socre() {
        num = '';
        score = $("#span_selected").children().length * times;
        $("#span_selected").children().each(function () {
            num += $(this).text() + ',';
        });
        $("#span_socre").html(score);
        if (score > 0) {
            $(".btn_submit").removeClass('weui-btn_disabled');
            $(".btn_submit").html('确定');
        } else {
            $(".btn_submit").addClass('weui-btn_disabled');
            $(".btn_submit").html('请选号码');
        }
    }
    calc_socre();
</script>
</html>
