<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>参与记录</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="email=no" name="format-detection">
    <link href="/static/css/weui.min.css" rel="stylesheet" />
    <style>
        html, body {
            background: #f4f4f4;
        }

        .weui-cells {
            font-size: 15px;
        }

        .head {
            text-align: center;
            height: 55px;
            line-height: 55px;
            box-shadow: 0 1px 1px 1px #e4e4e4;
            background: #fff;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            width: 100%;
        }

            .head .return {
                position: absolute;
                left: 0;
                top: 0;
                width: 55px;
                height: 55px;
            }

                .head .return:after {
                    content: " ";
                    display: inline-block;
                    height: 13px;
                    width: 13px;
                    border-width: 2px 2px 0 0;
                    border-color: #C8C8CD;
                    border-style: solid;
                    -webkit-transform: matrix(0.71, 0.71, -0.71, 0.71, 0, 0);
                    transform: matrix(0.71, 0.71, -0.71, 0.71, 0, 0);
                    position: absolute;
                    transform: rotate(225deg);
                    left: 16px;
                    top: 14px;
                }

            .head .operation {
                position: absolute;
                right: 0;
                top: 0;
                width: 60px;
                height: 55px;
                color: #00d26d;
            }

        .personal .tx {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }

        .personal .weui-input {
            color: #999;
        }
    </style>
</head>
<body>
    <div>
        <div class="head"><a class="return" href="?act=user&op=index"></a>参与记录</div>
        <div class="weui-cells" style="margin-top: 50px">
            <div class="weui-cell">
                <div class="weui-cell__bd">期号</div>
                <div class="weui-cell__bd">号码</div>
                <div class="weui-cell__bd">消费积分</div>
                <div class="weui-cell__ft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;购买时间</div>
            </div>
            <?php foreach ($output['list'] as $li)
                  {
            ?>
            <div class="weui-cell">
                <div class="weui-cell__bd">第<?php echo $li['pno']; ?>期</div>
                <div class="weui-cell__bd"><?php echo $li['num']; ?></div>
                <div class="weui-cell__bd"><?php echo $li['score']; ?></div>
                <div class="weui-cell__ft"><?php echo date('Y-m-d H:i',$li['ctime']); ?></div>
            </div>
            <?php
                  }
            ?>
        </div>
    </div>
</body>
<script src="/static/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    $(function () {
        var winH = $(window).height(); //页面可视区域高度  
        var pagetotal = parseInt('<?php echo $output['page_total'] ?>');
        var curpage = 2;
        var tpage = 0;
        $(window).scroll(function () {
            if (curpage > pagetotal) {
                return false;
            }
            if (tpage == curpage) {
                return false;
            }
            var pageH = $(document.body).height();
            var scrollT = $(window).scrollTop(); //滚动条top  
            if (pageH <= winH + scrollT) {
                tpage = curpage;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo url('user','score') ?>',
                    data: { 'formhash': '<?php echo Security::getTokenValue(); ?>', 'curpage': curpage },
                    dataType: 'json',
                    success: function (result) {
                        if (result.state == 0) {
                            var list = result.data;
                            curpage++;
                        }
                    }
                });
            }
            return false;
        });
    });
</script>
</html>
