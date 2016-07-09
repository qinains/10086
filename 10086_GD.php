<?php
// 广东移动浦发提单
require_once('function.php');

$account = '13500001234';
$amount  = 99;

$postdata = 'ptype=web&last_mobile='.$account.'&mobile='.$account.'&commodity_sid=47&otherAmount='.$amount.'&atype=UNIPAY&agent_id=pc-ChinaPayUnion';
$httpret = curlResponse('http://gd.10086.cn/commodity/recharge/market/submit.jsps', 1, $postdata);
$httpret = curlResponse('http://gd.10086.cn/commodity/recharge/market/confirm.jsps', 1, $postdata, getCookies($httpret['header']));
$httpret = curlResponse('http://gd.10086.cn/epay/unitrans', 1, getFormData($httpret['content']));
$httpret = curlResponse('http://gd.10086.cn/epay-portal/charge/charge_input.action', 1, getFormData($httpret['content']));
$orderid = cutstr($httpret['content'], '<input type="hidden" name="paymentOrderID"  value="', '" id="paymentOrderID"');
$postdata = 'channelID=01&paymentOrderID='.$orderid.'&bank_type=CMPayUnion&cashierDeskType=0&bankCode=SPDB';
$httpret = curlResponse('http://gd.10086.cn/epay-portal/charge/charge-save.action', 1, $postdata);
$httpret = curlResponse('https://ipos.10086.cn/ips/cmpayService', 1, getFormData($httpret['content']));
$results = getFormData($httpret['content'], true);
die(outputXML($results));