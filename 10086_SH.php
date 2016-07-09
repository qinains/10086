<?php
// 上海移动浦发提单
require_once('function.php');

$account = '13501601234';
$amount  = 50;

$postdata = 'list%5B0%5D%5Btelno%5D='.$account.'&list%5B0%5D%5BtotalFee%5D='.$amount.'&list%5B0%5D%5BnativeInfo%5D=%E4%B8%8A%E6%B5%B7%E7%A7%BB%E5%8A%A8&list%5B0%5D%5BrealFee%5D='.$amount.'&size=1&isBalance=false&billMonth=&payTelNo=&bankId=4&bankAbbr=1039&bankName=%E6%B5%A6%E4%B8%9C%E5%8F%91%E5%B1%95%E9%93%B6%E8%A1%8C&payType=3&amount='.$amount.'&cztype=CB_YHKJF';
$httpret = curlResponse('http://www.sh.10086.cn/sh/wsyyt/busi/bindbank.do?method=submitPayment', 1, $postdata);
$httpret = curlResponse(cutstr($httpret['content'], 'action=\'', '\' method=\'post\''));
die(outputXML(getFormData($httpret['content'], true)));