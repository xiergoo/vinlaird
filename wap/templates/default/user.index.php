<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>用户信息</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="email=no" name="format-detection">
    <link href="/static/css/weui.min.css" rel="stylesheet" />
    <link href="/static/css/style.css" rel="stylesheet" />
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
<?php $user = $output['user'] ?>
<body>
    <div class="head">个人信息</div>
    <div class="personal f15" style="padding-top: 60px;">
        <div class="weui-cells m0">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    头像
                </div>
                <div class="">
                    <img class="tx" src="<?php echo $user['headimgurl'] ?>" alt="">
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    ID
                </div>
                <div class="weui-cell__price"><?php echo $user['id'] ?></div>
            </div>
            <div class="weui-cell ">
                <div class="weui-cell__bd">
                    昵称
                </div>
                <div class="weui-cell__price"><?php echo $user['nickname'] ?></div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    积分
                </div>
                <div class="weui-cell__price"><?php echo $output['score'] ?></div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    手机号码
                </div>
                <div class="weui-cell__price"><?php if(is_mobile($user['mobile'])){ echo substr_replace($user['mobile'],'****',3,4); } else { ?>
                    <input class="weui-input" type="tel" placeholder="输入后自动保存，不能修改">
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="weui-cells mt5">
            <div class="weui-cell">
                <a class="weui-cell weui-cell_access" href="javascript:;" style="width: 100%">
                    <div class="weui-cell__bd">
                        <p>积分明细</p>
                    </div>
                    <div class="weui-cell__ft">
                    </div>
                </a>
            </div>
            <div class="weui-cell">
                <a class="weui-cell weui-cell_access" href="javascript:;" style="width: 100%">
                    <div class="weui-cell__bd">
                        <p>参与记录</p>
                    </div>
                    <div class="weui-cell__ft">
                    </div>
                </a>
            </div>
            <div class="weui-cell">
                <a class="weui-cell weui-cell_access" href="javascript:;" style="width: 100%">
                    <div class="weui-cell__bd">
                        <p>幸运记录</p>
                    </div>
                    <div class="weui-cell__ft">
                    </div>
                </a>
            </div>
            <div class="weui-cell">
                <a class="weui-cell weui-cell_access" href="javascript:;" style="width: 100%">
                    <div class="weui-cell__bd">
                        <p>赠送</p>
                    </div>
                    <div class="weui-cell__ft">
                    </div>
                </a>
            </div>
            <div class="weui-cell">
                <a class="weui-cell weui-cell_access" href="javascript:;" style="width: 100%">
                    <div class="weui-cell__bd">
                        <p>签到</p>
                    </div>
                    <div class="weui-cell__ft">
                    </div>
                </a>
            </div>
        </div>

        <div class="weui-tabbar" style="position:fixed;bottom:0px;">
            <a href="?act=index&op=index" class="weui-tabbar__item">
                <span style="display: inline-block; position: relative;">
                    <img src="/static/img/ico_h.png" alt="" class="weui-tabbar__icon">
                </span>
                <p class="weui-tabbar__label">首页</p>
            </a>
            <a href="?act=index&op=history" class="weui-tabbar__item">
                <span style="display: inline-block; position: relative;">
                    <img src="/static/img/ico_l.png" alt="" class="weui-tabbar__icon">
                </span>
                <p class="weui-tabbar__label">往期</p>
            </a>
            <a href="javascript:;" class="weui-tabbar__item weui-bar__item_on">
                <img src="/static/img/ico_u_f.png" alt="" class="weui-tabbar__icon">
                <p class="weui-tabbar__label">我</p>
            </a>
        </div>

    </div>


</body>
<script src="/static/js/jquery-3.2.1.min.js"></script>
</html>
