<?php
// 湖南移动浦发提单
require_once('function.php');
header('Content-type: text/plain;');

$account = '13908423604';
$amount  = 1;

// 提交表单
$httpret = curlResponse('https://www.hn.10086.cn/service/fee/payment/bankPay.jsp');
$postdata = getFormData($httpret['content'], true);
$postdata['bankAbbr'] = 'SPDB';
$postdata['BANK_ID'] = 'SPDB';
$postdata['mobileInfo'] = $account.'|'.bcmul("$amount", '1.00', 2). '|'.$amount.',';
$postdata = http_build_query($postdata);
$cookie = getCookies($httpret['header']);

// 浦发网银支付
$httpret = curlResponse('https://www.hn.10086.cn/service/fee/payment/bankPayCmpay.jsp', 1, $postdata, $cookie);
$postdata = getFormData($httpret['content']);
$httpret = curlResponse('https://ipos.10086.cn/ips/APITrans2', 1, $postdata);
$postdata = getFormData($httpret['content'], false, 'GBK');
$httpret = curlResponse('https://ipos.10086.cn/ips/cmpayService', 1, $postdata);
$results = getFormData($httpret['content'], true);
die(outputXML($results));