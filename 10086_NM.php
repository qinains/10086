<?php
// 内蒙移动浦发提单
require_once('function.php');

$account = '15247306868';
$amount  = 100;

// 填写号码与金额
$postdata = '_menuId=1050111&divId=main&phoneNo='.$account.'&amount='.$amount.'&sltPromoProdId=';
$httpret = curlResponse('http://www.nm.10086.cn/busicenter/onlinePaymentNm/OnlinePaymentMenuAction/initBusiPayOrder.menu', 1, $postdata);
$cookies = getCookies($httpret['header']);

// 选择浦发网银
$postdata = '_menuId=1050111&phoneNo='.$account.'&amount='.$amount.'&smsAuthCode=&easypayBank=&cmpayAccount=&banksRadio=SPDB';
$httpret = curlResponse('http://www.nm.10086.cn/busicenter/onlinePaymentNm/OnlinePaymentMenuAction/payTrade.menu?_menuId=1050111', 1, $postdata, $cookies);

// 提交至手支网关
$httpret = curlResponse(cutstr($httpret['content'], 'requestUrl', 'json'));
$results = getFormData($httpret['content'], true);
die(outputXML($results));