<?php
// 黑龙江移动浦发提单
require_once('function.php');

$account = '13936542429';
$amount  = 1;

// 生成预缴费订单
$httpret = curlResponse('http://www.hl.10086.cn/pay/payment/doPaymentFee?phone_no='.$account.'&targetFee='.$amount.'&pay_way=bankpay&order_id=&bankAbbr=SPDB');
$httpret = curlResponse(cutstr($httpret['content'], 'data', 'json'));
$results = getFormData($httpret['content'], true);

die(outputXML($results));