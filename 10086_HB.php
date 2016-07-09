<?php
// 湖北移动浦发提交
require_once('function.php');

$account = '15172086905';
$amount  = 100;

// 获取提单url, 手支提交至浦发网关
$postdata = 'payPath=recharge&payType=byBank&rechargeBeans=[{%22mobile%22:%22'.$account.'%22,%22amount%22:%22'.$amount.'%22}]&authCode=&bankCode=SPDB&rechargeType=S';
$httpret = curlResponse('http://www.hb.10086.cn/servicenew/phonepay/phonePay.action?', 1, $postdata);
$httpret = curlResponse(cutstr($httpret['content'], 'submitUrl', 'json'));
$results = getFormData($httpret['content'], true);
die(outputXML($results));