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
    <div>
        <div style="text-align: center; background-color: #999999; padding: 10px 0px 10px 18px; font-size: 23px">
            往期揭晓
        </div>
        <div class="weui-cells" style="margin-top: 0px">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <p><b>期数</b></p>
                </div>
                <div class="weui-cell__bd">
                    <p><b>上证指数/结果</b></p>
                </div>
                <div class="weui-cell__ft"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日　期</b></div>
            </div>
            <?php foreach ($output['list'] as $li)
                  {
            ?>
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <p>第<?php echo $li['pno']; ?>期</p>
                    </div>
                    <div class="weui-cell__bd">
                        <p><?php if($li['jnum']<10) $li['jnum']='0'.$li['jnum']; if($li['dpnum']<1){$li['dpnum']=$li['jnum']='-';} echo $li['dpnum'].'/'.$li['jnum']; ?></p>
                    </div>
                    <div class="weui-cell__ft"><?php echo date('Y-m-d',$li['jtime']); ?></div>
                </div>
            <?php
                  }
            ?>
        </div>
            
        <div class="weui-tabbar" style="position:fixed;bottom:0px;">
            <a href="?act=index&op=index" class="weui-tabbar__item">
                <span style="display: inline-block; position: relative;">
                    <img src="/static/img/ico_h.png" alt="" class="weui-tabbar__icon">
                </span>
                <p class="weui-tabbar__label">首页</p>
            </a>
            <a href="javascript:;" class="weui-tabbar__item weui-bar__item_on">
                <span style="display: inline-block; position: relative;">
                    <img src="/static/img/ico_l_f.png" alt="" class="weui-tabbar__icon">
                </span>
                <p class="weui-tabbar__label">往期</p>
            </a>
            <a href="?act=user&op=index" class="weui-tabbar__item">
                <img src="/static/img/ico_u.png" alt="" class="weui-tabbar__icon">
                <p class="weui-tabbar__label">我</p>
            </a>
        </div>
    </div>
</body>
</html>
