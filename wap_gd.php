<?php

require_once('function.php');
header('Content-type: text/plain;');

$httpret = curlResponse('http://wap.gd.10086.cn/nwap/recharge/recharge/recharge.jsps');
$cookies = getCookies($httpret['header']);

$account = '18818792997';

$postdata = 'mobileNum='.$account.'&priceInput=9.9&rev1=9.9%7C9.9%2B0.10&pageChannel=waprecharge';
$httpret = curlResponse('http://wap.gd.10086.cn/nwap/recharge/rechargeOrder/validate.jsps', 1, $postdata, $cookies);
$encodeMsg = cutstr($httpret['content'], 'content->encodeMsg', 'json');
$signMsg = cutstr($httpret['content'], 'content->signMsg', 'json');

$httpret = curlResponse('http://gd.10086.cn/epay/unitrans?SignMsg='.$signMsg.'&EncodeMsg='.$encodeMsg);
$postdata = getFormData($httpret['content'], true);


$httpret = curlResponse('http://gd.10086.cn/epay-portal/charge/wap-charge-input.action?format=json&jsoncallback=jQuery17202003616306465119_1432177945614&c_id=03&o_id='.$postdata['o_id'].'&cd_type=1&merchant=010100GD001&srv_id=0&p_method=CMPayWAPExpress%252CAliPayWAP&o_time='.$postdata['o_time'].'&point=0&user='.$postdata['user'].'&amount='.$postdata['amount'].'&title=WAP%25E8%2590%25A5%25E4%25B8%259A%25E5%258E%2585%25E5%2585%2585%25E5%2580%25BC%25E7%25BC%25B4%25E8%25B4%25B9&back_url=http%253A%252F%252Fgd.10086.cn%252Fepay%252Funifront&notify_url=http%253A%252F%252Fgd.10086.cn%252Fepay%252Funiback&desc=WAP%25E8%2590%25A5%25E4%25B8%259A%25E5%258E%2585%25E5%2585%2585%25E5%2580%25BC%25E7%25BC%25B4%25E8%25B4%25B9&digest='.urlencode($postdata['digest']).'&p_direct=0&_=1432177945717');

$paymentOrderID = cutstr($httpret['content'], '"paymentOrderID":"', '","reminder"');
$httpret = curlResponse('http://gd.10086.cn/epay-portal/charge/wap-charge-save.action?format=json&jsoncallback=jQuery17202003616306465119_1432177945615&channelID=03&paymentOrderID='.$paymentOrderID.'&bank_type=CMPayWAPExpress&cashierDeskType=1&_=1432177966417 ');
$sessionid = cutstr($httpret['content'], 'sessionId=', '","');

print_r($sessionid);die;