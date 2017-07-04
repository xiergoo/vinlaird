INSERT INTO `vl_admin` (`admin_id`,`admin_name`,`admin_password`,`admin_login_time`,`admin_login_num`,`admin_is_super`,`admin_gid`) VALUES('1','admin','96e79218965eb72c92a549dd5a330112','1499130420','19','1',NULL);
INSERT INTO `vl_admin` (`admin_id`,`admin_name`,`admin_password`,`admin_login_time`,`admin_login_num`,`admin_is_super`,`admin_gid`) VALUES('2','admin2','96e79218965eb72c92a549dd5a330112','0','0','0',NULL);
INSERT INTO `vl_admin` (`admin_id`,`admin_name`,`admin_password`,`admin_login_time`,`admin_login_num`,`admin_is_super`,`admin_gid`) VALUES('3','admin3','96e79218965eb72c92a549dd5a330112','0','0','0',NULL);

INSERT INTO `vl_admin_log` (`id`,`content`,`createtime`,`admin_name`,`admin_id`,`ip`,`url`) VALUES('1','','1493197571','admin','1','127.0.0.1','login&login');
INSERT INTO `vl_admin_log` (`id`,`content`,`createtime`,`admin_name`,`admin_id`,`ip`,`url`) VALUES('2','','1493255378','admin','1','127.0.0.1','login&login');
INSERT INTO `vl_admin_log` (`id`,`content`,`createtime`,`admin_name`,`admin_id`,`ip`,`url`) VALUES('3','','1493275464','admin','1','127.0.0.1','login&login');
INSERT INTO `vl_admin_log` (`id`,`content`,`createtime`,`admin_name`,`admin_id`,`ip`,`url`) VALUES('4','清理缓存','1493278120','admin','1','127.0.0.1','cache&clear');

INSERT INTO `vl_gadmin` (`gid`,`gname`,`limits`) VALUES('0','1组','NjlORkV1NDiOdbPzaXUSE5vr840GGzuLMLtnS8dGqJgX6uaCPIosP8dGGJwrY_SyHy9vscJqWelgWqNfYeldHjRsMX5Zmm8wc0yxmWx1bM8rnChflS2f3qhgWj2nMzlgHC1x7cAxm2MyLk3umOogWa5en6uYGHEoGSA');

INSERT INTO `vl_mail_msg_temlates` (`name`,`title`,`code`,`content`) VALUES('<strong>[用户]</strong>身份验证通知','账户安全认证 - {$site_name}','authenticate','【{$site_name}】您于{$send_time}提交账户安全验证，验证码是：{$verify_code}。.');
INSERT INTO `vl_mail_msg_temlates` (`name`,`title`,`code`,`content`) VALUES('<strong>[用户]</strong>邮箱验证通知','邮箱验证通知 - {$site_name}','bind_email','<p>您好！</p>
<p>请在24小时内点击以下链接完成邮箱验证</p>
<p><a href="{$verify_url}" target="_blank">马上验证</a></p>
<p>如果您不能点击上面链接，还可以将以下链接复制到浏览器地址栏中访问</p>
<p>{$verify_url}</p>');
INSERT INTO `vl_mail_msg_temlates` (`name`,`title`,`code`,`content`) VALUES('<strong>[用户]</strong>手机验证通知','手机验证通知 - {$site_name}','modify_mobile','【{$site_name}】您于{$send_time}绑定手机号，验证码是：{$verify_code}。');
INSERT INTO `vl_mail_msg_temlates` (`name`,`title`,`code`,`content`) VALUES('<strong>[用户]</strong>重置密码通知','重置密码通知 - {$site_name}','reset_pwd','<p>您好！</p>
<p>您刚才在{$site_name}重置了密码，新密码为：{$new_password}。</p>
<p>请尽快登录 <a href="{$site_url}" target="_blank">{$site_url}</a> 修改密码。</p>');
INSERT INTO `vl_mail_msg_temlates` (`name`,`title`,`code`,`content`) VALUES('<strong>[用户]</strong>自提通知','用户自提通知 - {$site_name}','send_pickup_code','【{$site_name}】您的订单已到达自提点，请上门取货！提货时请提供手机号/订单号/运单号及提货码：{$pickup_code}。');
INSERT INTO `vl_mail_msg_temlates` (`name`,`title`,`code`,`content`) VALUES('<strong>[用户]</strong>虚拟兑换码通知','虚拟兑换码通知 - {$site_name}','send_vr_code','【{$site_name}】您的虚拟兑换码是：{$vr_code}。');

INSERT INTO `vl_member_msg_tpl` (`mmt_code`,`mmt_name`,`mmt_message_switch`,`mmt_message_content`,`mmt_short_switch`,`mmt_short_content`,`mmt_mail_switch`,`mmt_mail_subject`,`mmt_mail_content`) VALUES('arrival_notice','到货通知提醒','1','您关注的商品 “{$goods_name}” 已经到货。<a href="{$goods_url}" target="_blank">点击查看商品</a>','0','【{$site_name}】您关注的商品 “{$goods_name}” 已经到货。','0','{$site_name}提醒：您关注的商品  “{$goods_name}” 已经到货。','<p>
	{$site_name}提醒：
</p>
<p>
	您关注的商品 “{$goods_name}” 已经到货。
</p>
<p>
	<a href="{$goods_url}" target="_blank">点击查看商品</a> 
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p style="text-align:right;">
	{$site_name}
</p>
<p style="text-align:right;">
	{$mail_send_time}
</p>');
INSERT INTO `vl_member_msg_tpl` (`mmt_code`,`mmt_name`,`mmt_message_switch`,`mmt_message_content`,`mmt_short_switch`,`mmt_short_content`,`mmt_mail_switch`,`mmt_mail_subject`,`mmt_mail_content`) VALUES('consult_goods_reply','商品咨询回复提醒','1','您关于商品 “{$goods_name}”的咨询，商家已经回复。<a href="{$consult_url}" target="_blank">点击查看回复</a>','0','【{$site_name}】您关于商品 “{$goods_name}” 的咨询，商家已经回复。','0','{$site_name}提醒：您关于商品 “{$goods_name}”的咨询，商家已经回复。','<p>
	{$site_name}提醒：
</p>
<p>
	您关注的商品“{$goods_name}” 已经到货。
</p>
<p>
	<a href="{$consult_url}" target="_blank">点击查看回复</a> 
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p style="text-align:right;">
	{$site_name}
</p>
<p style="text-align:right;">
	{$mail_send_time}
</p>
<br />
<div class="firebugResetStyles firebugBlockBackgroundColor">
	<div style="background-color:transparent ! important;" class="firebugResetStyles">
	</div>
</div>');
INSERT INTO `vl_member_msg_tpl` (`mmt_code`,`mmt_name`,`mmt_message_switch`,`mmt_message_content`,`mmt_short_switch`,`mmt_short_content`,`mmt_mail_switch`,`mmt_mail_subject`,`mmt_mail_content`) VALUES('consult_mall_reply','平台客服回复提醒','1','您的平台客服咨询已经回复。<a href="{$consult_url}" target="_blank">点击查看回复</a>','0','【{$site_name}】您的平台客服咨询已经回复。','0','{$site_name}提醒：您的平台客服咨询已经回复。','<p>
	{$site_name}提醒：
</p>
<p>
	您的平台客服咨询已经回复。
</p>
<p>
	<a href="{$consult_url}" target="_blank">点击查看回复</a> 
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p style="text-align:right;">
	{$site_name}
</p>
<p style="text-align:right;">
	{$mail_send_time}
</p>');
INSERT INTO `vl_member_msg_tpl` (`mmt_code`,`mmt_name`,`mmt_message_switch`,`mmt_message_content`,`mmt_short_switch`,`mmt_short_content`,`mmt_mail_switch`,`mmt_mail_subject`,`mmt_mail_content`) VALUES('order_deliver_success','商品出库提醒','1','您的订单已经出库。<a href="{$order_url}" target="_blank">点击查看订单</a>','0','【{$site_name}】您的订单已经出库。订单编号 {$order_sn}。','0','{$site_name}提醒：您的订单已经出库。订单编号 {$order_sn}。','<p>
	{$site_name}提醒：
</p>
<p>
	您的订单已经出库。订单编号 {$order_sn}。<br />
<a href="{$order_url}" target="_blank">点击查看订单</a>
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p style="text-align:right;">
	{$site_name}
</p>
<p style="text-align:right;">
	{$mail_send_time}
</p>
<br />');
INSERT INTO `vl_member_msg_tpl` (`mmt_code`,`mmt_name`,`mmt_message_switch`,`mmt_message_content`,`mmt_short_switch`,`mmt_short_content`,`mmt_mail_switch`,`mmt_mail_subject`,`mmt_mail_content`) VALUES('order_payment_success','付款成功提醒','1','关于订单：{$order_sn}的款项已经收到，请留意出库通知。<a href="{$order_url}" target="_blank">点击查看订单详情</a>','0','【{$site_name}】{$order_sn}的款项已经收到，请留意出库通知。','0','{$site_name}提醒：{$order_sn}的款项已经收到，请留意出库通知。','<p>
	{$site_name}提醒：
</p>
<p>
	{$order_sn}的款项已经收到，请留意出库通知。
</p>
<p>
	<a href="{$order_url}" target="_blank">点击查看订单详情</a>
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p style="text-align:right;">
	{$site_name}
</p>
<p style="text-align:right;">
	{$mail_send_time}
</p>
<br />');
INSERT INTO `vl_member_msg_tpl` (`mmt_code`,`mmt_name`,`mmt_message_switch`,`mmt_message_content`,`mmt_short_switch`,`mmt_short_content`,`mmt_mail_switch`,`mmt_mail_subject`,`mmt_mail_content`) VALUES('predeposit_change','余额变动提醒','1','你的账户于 {$time} 账户资金有变化，描述：{$desc}，可用金额变化 ：{$av_amount}元，冻结金额变化：{$freeze_amount}元。<a href="{$pd_url}" target="_blank">点击查看余额</a>','0','【{$site_name}】你的账户于 {$time} 账户资金有变化，描述：{$desc}，可用金额变化： {$av_amount}元，冻结金额变化：{$freeze_amount}元。','0','{$site_name}提醒：你的账户于 {$time} 账户资金有变化，描述：{$desc}，可用金额变化： {$av_amount}元，冻结金额变化：{$freeze_amount}元。','<p>
	{$site_name}提醒：
</p>
<p>
	你的账户于 {$time} 账户资金有变化，描述：{$desc}，可用金额变化：{$av_amount}元，冻结金额变化：{$freeze_amount}元。
</p>
<p>
	<a href="{$pd_url}" target="_blank">点击查看余额</a> 
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p style="text-align:right;">
	{$site_name}
</p>
<p style="text-align:right;">
	{$mail_send_time}
</p>');
INSERT INTO `vl_member_msg_tpl` (`mmt_code`,`mmt_name`,`mmt_message_switch`,`mmt_message_content`,`mmt_short_switch`,`mmt_short_content`,`mmt_mail_switch`,`mmt_mail_subject`,`mmt_mail_content`) VALUES('recharge_card_balance_change','充值卡余额变动提醒','1','你的账户于 {$time} 充值卡余额有变化，描述：{$description}，可用充值卡余额变化 ：{$available_amount}元，冻结充值卡余额变化：{$freeze_amount}元。<a href="{$url}" target="_blank">点击查看充值卡余额</a>','0','【{$site_name}】你的账户于 {$time} 充值卡余额有变化，描述：{$description}，可用充值卡余额变化： {$available_amount}元，冻结充值卡余额变化：{$freeze_amount}元。','0','{$site_name}提醒：你的账户于 {$time} 充值卡余额有变化，描述：{$description}，可用充值卡余额变化： {$available_amount}元，冻结充值卡余额变化：{$freeze_amount}元。','<p>
    {$site_name}提醒：
</p>
<p>
  你的账户于 {$time} 充值卡余额有变化，描述：{$description}，可用充值卡余额变化：{$available_amount}元，冻结充值卡余额变化：{$freeze_amount}元。
</p>
<p>
  <a href="{$url}" target="_blank">点击查看余额</a> 
</p>
<p>
  <br />
</p>
<p>
   <br />
</p>
<p>
   <br />
</p>
<p style="text-align:right;">
 {$site_name}
</p>
<p style="text-align:right;">
   {$mail_send_time}
</p>');
INSERT INTO `vl_member_msg_tpl` (`mmt_code`,`mmt_name`,`mmt_message_switch`,`mmt_message_content`,`mmt_short_switch`,`mmt_short_content`,`mmt_mail_switch`,`mmt_mail_subject`,`mmt_mail_content`) VALUES('refund_return_notice','退款退货提醒','1','您的退款退货单有了变化。<a href="{$refund_url}" target="_blank">点击查看</a>','0','【{$site_name}】您的退款退货单有了变化。退款退货单编号：{$refund_sn}。','0','{$site_name}提醒：您的退款退货单有了变化。','<p>
	{$site_name}提醒：
</p>
<p>
	您的退款退货单有了变化。退款退货单编号：{$refund_sn}。
</p>
<p>
	&lt;a href="{$refund_url}" target="_blank"&gt;点击查看&lt;/a&gt;
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p style="text-align:right;">
	{$site_name}
</p>
<p style="text-align:right;">
	{$mail_send_time}
</p>
<br />');
INSERT INTO `vl_member_msg_tpl` (`mmt_code`,`mmt_name`,`mmt_message_switch`,`mmt_message_content`,`mmt_short_switch`,`mmt_short_content`,`mmt_mail_switch`,`mmt_mail_subject`,`mmt_mail_content`) VALUES('voucher_use','代金券使用提醒','1','您有代金券已经使用，代金券编号：{$voucher_code}。<a href="{$voucher_url}" target="_blank">点击查看</a>','0','【{$site_name}】您有代金券已经使用，代金券编号：{$voucher_code}。','0','{$site_name}提醒：您有代金券已经使用，代金券编号：{$voucher_code}。','<p>
	{$site_name}提醒：
</p>
<p>
	您有代金券已经使用，代金券编号：{$voucher_code}。
</p>
<p>
	&lt;a href="{$voucher_url}" target="_blank"&gt;点击查看&lt;/a&gt;
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p style="text-align:right;">
	{$site_name}
</p>
<p style="text-align:right;">
	{$mail_send_time}
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>');
INSERT INTO `vl_member_msg_tpl` (`mmt_code`,`mmt_name`,`mmt_message_switch`,`mmt_message_content`,`mmt_short_switch`,`mmt_short_content`,`mmt_mail_switch`,`mmt_mail_subject`,`mmt_mail_content`) VALUES('voucher_will_expire','代金券即将到期提醒','1','您有一个代金券即将在{$indate}过期，请记得使用。<a href="{$voucher_url}" target="_blank">点击查看</a>','0','【{$site_name}】您有一个代金券即将在{$indate}过期，请记得使用。','0','{$site_name}提醒：您有一个代金券即将在{$indate}过期，请记得使用。','<p>
	{$site_name}提醒：
</p>
<p>
	您有一个代金券即将在{$indate}过期，请记得使用。
</p>
<p>
	<a href="{$voucher_url}" target="_blank">点击查看</a> 
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p style="text-align:right;">
	{$site_name}
</p>
<p style="text-align:right;">
	{$mail_send_time}
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>');
INSERT INTO `vl_member_msg_tpl` (`mmt_code`,`mmt_name`,`mmt_message_switch`,`mmt_message_content`,`mmt_short_switch`,`mmt_short_content`,`mmt_mail_switch`,`mmt_mail_subject`,`mmt_mail_content`) VALUES('vr_code_will_expire','兑换码即将到期提醒','1','您有一组兑换码即将在{$indate}过期，请记得使用。<a href="{$vr_order_url}" target="_blank">点击查看</a>','0','【{$site_name}】您有一组兑换码即将在{$indate}过期，请记得使用。','0','{$site_name}提醒：您有一组兑换码即将在{$indate}过期，请记得使用。','<p>
	{$site_name}提醒：
</p>
<p>
	您有一组兑换码即将在{$indate}过期，请记得使用。
</p>
<p>
	&lt;a href="{$vr_order_url}" target="_blank"&gt;点击查看&lt;/a&gt;
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p style="text-align:right;">
	{$site_name}
</p>
<p style="text-align:right;">
	{$mail_send_time}
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('captcha_status_goodsqa','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('captcha_status_login','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('captcha_status_register','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_contentleast','10');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_createsum','6');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_exprelease','2');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_expreleasemax','10');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_expreplied','3');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_exprepliedmax','1000');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_expreply','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_intervaltime','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_iscreate','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_istalk','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_isuse','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_joinsum','12');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_loginpic','a:4:{i:1;a:2:{s:3:"pic";s:5:"1.jpg";s:3:"url";s:22:"http://www.33hao.com/";}i:2;a:2:{s:3:"pic";s:5:"2.jpg";s:3:"url";s:22:"http://www.33hao.com/";}i:3;a:2:{s:3:"pic";s:5:"3.jpg";s:3:"url";s:22:"http://www.33hao.com/";}i:4;a:2:{s:3:"pic";s:5:"4.jpg";s:3:"url";s:22:"http://www.33hao.com/";}}');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_logo','logo.png');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_managesum','4');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_name','圈子');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_seodescription','发现精彩：圈子是买家们自己创建的私属领地，我们排斥广告分子，我们热爱真实分享！');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_seokeywords','圈子,帮派,讨论小组,购物,生活,分享,show,秀,商品,电子商务,社区,消费者社区,论坛,资讯,热门话题,朋友');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_seotitle','发现精彩 - 圈子');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('circle_wordfilter',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('closed_reason','升级中……');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('cms_attitude_flag','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('cms_comment_flag','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('cms_isuse','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('cms_logo',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('cms_seo_description','资讯,画报');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('cms_seo_keywords','资讯,画报');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('cms_seo_title','资讯频道');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('cms_submit_flag','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('cms_submit_verify_flag','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('complain_time_limit','2592000');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('consult_prompt','因厂家更改商品包装、场地、附配件等不做提前通知，且每位咨询者购买、提问时间等不同。为此，客服给到的回复仅对提问者3天内有效，其他网友仅供参考！给您带来的不变还请谅解，谢谢！');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('default_goods_image','default_goods_image.gif');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('default_store_avatar','default_store_avatar.gif');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('default_store_logo','default_store_logo.gif');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('default_user_portrait','default_user_portrait.gif');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('delivery_isuse','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('email_addr',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('email_host',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('email_id',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('email_pass',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('email_port','25');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('email_type','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('enabled_subdomain',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('exppoints_rule','a:4:{s:9:"exp_login";s:1:"5";s:12:"exp_comments";s:2:"10";s:13:"exp_orderrate";s:1:"1";s:12:"exp_ordermax";s:3:"500";}');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('flea_app_open','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('flea_hot_search','男装,手机,笔记本,古董,奢侈品');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('flea_isuse','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('flea_loginpic','a:4:{i:1;a:2:{s:3:"pic";s:5:"flea_1.jpg";s:3:"url";s:22:"http://www.33hao.com/";}i:2;a:2:{s:3:"pic";s:5:"flea_2.jpg";s:3:"url";s:22:"http://www.33hao.com/";}i:3;a:2:{s:3:"pic";s:5:"flea_3.jpg";s:3:"url";s:22:"http://www.33hao.com/";}i:4;a:2:{s:3:"pic";s:5:"flea_4.jpg";s:3:"url";s:22:"http://www.33hao.com/";}i:5;a:2:{s:3:"pic";s:5:"flea_5.jpg";s:3:"url";s:22:"http://www.33hao.com/";}}');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('flea_site_description','好商城V3系统闲置市场');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('flea_site_keywords','好商城V3系统闲置市场');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('flea_site_name','好商城V3系统闲置市场');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('flea_site_title','好商城V3系统闲置市场');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('goods_verify',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('groupbuy_allow','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('groupbuy_price','10');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('groupbuy_review_day',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('guest_comment','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('hot_search','好商城V3,内衣,笔记本,手机');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('icp_number',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('image_allow_ext','gif,jpg,jpeg,bmp,png,swf');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('image_dir_type','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('image_max_filesize','1024');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('live_link1','http://www.33hao.com');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('live_link2','http://www.33hao.com');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('live_link3',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('live_link4',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('live_pic1','04525999367706292.jpg');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('live_pic2','04525999367951893.jpg');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('live_pic3',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('live_pic4',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('login_pic','a:4:{i:0;s:5:"1.jpg";i:1;s:5:"2.jpg";i:2;s:5:"3.jpg";i:3;s:5:"4.jpg";}');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('malbum_max_sum','200');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('md5_key','05e84a667f4ef7355f77bb2245b58967');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('member_grade','a:4:{i:0;a:3:{s:5:"level";i:0;s:10:"level_name";s:2:"V0";s:9:"exppoints";i:0;}i:1;a:3:{s:5:"level";i:1;s:10:"level_name";s:2:"V1";s:9:"exppoints";i:1000;}i:2;a:3:{s:5:"level";i:2;s:10:"level_name";s:2:"V2";s:9:"exppoints";i:10000;}i:3;a:3:{s:5:"level";i:3;s:10:"level_name";s:2:"V3";s:9:"exppoints";i:20000;}}');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('member_logo','user_center.png');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('microshop_goods_default_class',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('microshop_header_pic',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('microshop_isuse','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('microshop_logo',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('microshop_personal_limit','50');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('microshop_seo_description','好商城V3,微商城,随心看,个人秀,店铺街');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('microshop_seo_keywords','好商城V3,微商城,随心看,个人秀,店铺街,网上购物');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('microshop_store_banner',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('microshop_style','default');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('mobile_apk','http://v3.33hao.com/app.apk');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('mobile_apk_version','3.0.2');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('mobile_app','mb_app.png');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('mobile_host',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('mobile_host_type',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('mobile_ios','http://v3.33hao.com/app.ipa');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('mobile_isuse','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('mobile_key',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('mobile_memo',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('mobile_pwd',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('mobile_signature',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('mobile_username',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('pointprod_isuse','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('pointshop_isuse','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('points_comments','50');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('points_invite','100');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('points_isuse','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('points_login','30');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('points_ordermax','800');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('points_orderrate','20');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('points_rebate','10');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('points_reg','20');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('points_signin','5');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('promotion_allow','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('promotion_booth_goods_sum','10');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('promotion_booth_price','20');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('promotion_bundling_goods_sum','5');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('promotion_bundling_price','20');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('promotion_bundling_sum','50');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('promotion_mansong_price','20');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('promotion_voucher_buyertimes_limit','5');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('promotion_voucher_default_styleimg','default_voucher.jpg');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('promotion_voucher_price','20');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('promotion_voucher_storetimes_limit','20');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('promotion_xianshi_price','11');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('qq_appcode',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('qq_appid',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('qq_appkey',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('qq_isuse',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('seller_center_logo','seller_center_logo.png');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('share_isuse','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('share_qqweibo_appid',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('share_qqweibo_appkey',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('share_qqweibo_isuse',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('share_sinaweibo_appcode',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('share_sinaweibo_appid',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('share_sinaweibo_appkey',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('share_sinaweibo_isuse',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('sina_appcode',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('sina_isuse',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('sina_wb_akey',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('sina_wb_skey',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('site_bank_account',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('site_email','abc@33hao.com');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('site_logo','logo.png');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('site_logowx','04781087584534013.png');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('site_mobile_logo',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('site_name','vinlaird');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('site_phone','23456789,88997788');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('site_status','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('site_tel400','4008008000');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('sms_login',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('sms_password',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('sms_register',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('statistics_code','Copyright 2015 &lt;a href=&quot;#&quot; target=&quot;_blank&quot;&gt;vinlaird&lt;/a&gt; All rights reserved.');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('stat_orderpricerange',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('stat_pricerange',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('store_joinin_pic','a:2:{s:8:"show_txt";s:246:"平台提供各类专业管家服务，协助您开通店铺、运营店铺、组织营销活动及分析运营数据，悉心为您解答各类疑问，引导您按相关规则展开运营；我们将竭尽全力，为您的店铺保驾护航。";s:3:"pic";a:3:{i:1;s:18:"store_joinin_1.jpg";i:2;s:18:"store_joinin_2.jpg";i:3;s:0:"";}}');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('subdomain_edit',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('subdomain_length','3-12');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('subdomain_reserved','www');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('subdomain_times','3');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('taobao_api_isuse',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('taobao_app_key',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('taobao_secret_key',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('time_zone','Asia/Shanghai');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('voucher_allow','1');
INSERT INTO `vl_setting` (`name`,`value`) VALUES('weixin_appid',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('weixin_isuse',NULL);
INSERT INTO `vl_setting` (`name`,`value`) VALUES('weixin_secret',NULL);
