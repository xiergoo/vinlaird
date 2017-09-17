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
<!--        <link href="/static/css/jquery-weui.css" rel="stylesheet" />-->
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
                    <img class="tx" src="/static/head/dh.jpg" alt="">
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    ID
                </div>
                <div class="weui-cell__price">12345</div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    姓名
                </div>
                <div class="weui-cell__price">陈小姐</div>
            </div>
            <div class="weui-cell ">
                <div class="weui-cell__bd">
                    昵称
                </div>
                <div class="weui-cell__price">Miss Chen</div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    积分
                </div>
                <div class="weui-cell__price">1000000000</div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    手机号码
                </div>
                <div class="weui-cell__price">13728936556</div>
            </div>
        </div>

        <div class="weui-cells mt5">
            <div class="weui-cell">
                <a class="weui-cell weui-cell_access" href="javascript:;" style="width:100%">
                    <div class="weui-cell__bd" >
                        <p >积分明细</p>
                    </div>
                    <div class="weui-cell__ft">
                    </div>
                </a>
            </div>
            <div class="weui-cell">
                <a class="weui-cell weui-cell_access" href="javascript:;" style="width:100%">
                    <div class="weui-cell__bd" >
                        <p >参与记录</p>
                    </div>
                    <div class="weui-cell__ft">
                    </div>
                </a>
            </div>
            <div class="weui-cell">
                <a class="weui-cell weui-cell_access" href="javascript:;" style="width:100%">
                    <div class="weui-cell__bd" >
                        <p >幸运记录</p>
                    </div>
                    <div class="weui-cell__ft">
                    </div>
                </a>
            </div>
            <div class="weui-cell">
                <a class="weui-cell weui-cell_access" href="javascript:;" style="width:100%">
                    <div class="weui-cell__bd" >
                        <p >赠送</p>
                    </div>
                    <div class="weui-cell__ft">
                    </div>
                </a>
            </div>
            <div class="weui-cell">
                <a class="weui-cell weui-cell_access" href="javascript:;" style="width:100%">
                    <div class="weui-cell__bd" >
                        <p >签到</p>
                    </div>
                    <div class="weui-cell__ft">
                    </div>
                </a>
            </div>
        </div>

    </div>




    <!--
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-weui.min.js"></script>-->

</body>
<script src="/static/js/jquery-3.2.1.min.js"></script>
</html>
