<?php
// 浙江移动浦发提单
require_once('function.php');

$account = '13757553539';
$amount = 10;

$postdata = 'bankType=PF&index=1&gateId=1022&phoneNo='.$account.'&total='.$amount;
$httpret = curlResponse('http://service.zj.10086.cn/chinamobilepaycomponent/goPayComponentPage.do?', 1, $postdata);
$httpret = curlResponse('https://pay-web.zj.chinamobile.com/UnifiedPay', 1, getFormData($httpret['content']));
$httpret = curlResponse('https://ipos.10086.cn/ips/cmpayService', 1, getFormData($httpret['content']));
$results = getFormData($httpret['content'], true);
die(outputXML($results));