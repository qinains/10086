<?php
// 重庆移动浦发提单
require_once('function.php');

$account = '15909337345';
$amount = 100;

$httpret = curlResponse('http://service.cq.10086.cn/app?service=page/operation.NewPayment&listener=initPage');
$token = cutstr($httpret['content'], 'var PAYMENT_TOKEN = \'', '\';');
$cookies = getCookies($httpret['header']);
$httpret = curlResponse('http://service.cq.10086.cn/app?service=page/bankdirectpay.BankJumpNew&TELNUM='.$account.'&PAYMENT='.$amount.'&banks=MOBILEPAY&listener=initPage&bankAbbr=SPDB&token='.$token.'&sb=false', 0, null, $cookies);
$httpret = curlResponse('https://ipos.10086.cn/ips/cmpayService', 1, getFormData($httpret['content'], false, 'GBK'), $cookies);
die(outputXML(getFormData($httpret['content'], true)));