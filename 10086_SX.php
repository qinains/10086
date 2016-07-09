<?php
// 山西移动浦发提单
require_once('function.php');

$account = '13503501235';
$amount  = 100;

$httpret = curlResponse('http://service.sx.10086.cn/enhance/payment/createPayOrderId.action?pay_way=bankPay&_=1430061014283');
$orderid = cutstr($httpret['content'], 'order_id', 'json');
$postdata = 'bankAbbr=SPDB&pay_way=bankPay&order_id='.$orderid.'&orderList%5B0%5D.phone_no='.$account.'&orderList%5B0%5D.should_fee='.$amount.'.00&orderList%5B0%5D.target_fee='.$amount.'&orderList%5B0%5D.charge_fee='.bcmul($amount, '0.99', 2);
$httpret = curlResponse('http://service.sx.10086.cn/enhance/payment/turnToPay.action', 1, $postdata);
$httpret = curlResponse('https://ipos.10086.cn/ips/cmpayService', 1, getFormData($httpret['content'], false, 'GBK'));
die(outputXML(getFormData($httpret['content'], true)));