<?php
// 辽宁移动浦发提单
require_once('function.php');

$account = '13804171600';
$amount = 2;

// 获取Cookie值
$httpret = curlResponse('http://www.ln.10086.cn/busicenter/onlinePayment/OnlinePaymentMenuAction/initBusi.menu?_menuId=1050101&_menuId=1050101&action=reModify', 1, 'divId=main');
$cookies = getCookies($httpret['header']);

// 提交表单,生成预缴费订单,选择浦发网银
$postdata = 'phoneNo0='.$account.'&queryPhone=%B2%E9%D1%AF%B3%E4%D6%B5%BA%C5%C2%EB&payAmount0='.$amount.'&payType=0';
$httpret = curlResponse('http://www.ln.10086.cn/busicenter/onlinePayment/OnlinePaymentMenuAction/payOrder.upmenu?_menuId=1050101', 1, $postdata, $cookies);
$postdata = getFormData(cutstr($httpret['content'], '<form id="paymentForm" action="" method="post">', '</form>'), true);
$postdata['banks'] = 'SPDB';
$httpret = curlResponse('http://www.ln.10086.cn/busicenter/onlinePayment/OnlinePaymentMenuAction/payTrade.menu?_menuId=1050101', 1, http_build_query($postdata), $cookies);

// 提交浦发手支网关
$postdata = json_decode($httpret['content'], true);
$postdata['type'] = $postdata['typeNew'];
$httpret = curlResponse('https://ipos.10086.cn/ips/APITrans2', 1, http_build_query($postdata));
$httpret = curlResponse('https://ipos.10086.cn/ips/cmpayService', 1, getFormData($httpret['content'], false, 'GB2312'));
$results = getFormData($httpret['content'], true);
die(outputXML($results));