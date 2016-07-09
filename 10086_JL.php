<?php
// 吉林移动浦发提单
require_once('function.php');
$account = '18804446610';
$amount = 1;

// 提交表单
$httpret = curlResponse('http://www.jl.10086.cn/service/pay/bankpay.do?action=bank.pay.sub&paytype=one&omid=0&timer=0&mobiles='.$account.'&payMoneys='.$amount);
parse_str(getLocation($httpret['header']), $query);
$httpret = curlResponse('http://www.jl.10086.cn/service/pay/bankpay.do?action=to.pay&paytype=1&omid='.$query['omid'].'&timer='.$query['timer'].'&banks=B_SPDB');

// 手支浦发网银
$httpret = curlResponse('https://ipos.10086.cn/ips/OMCGPUB2/FormTrans5.dow', 1, getFormData($httpret['content']));
$results = getFormData($httpret['content'], true);
die(outputXML($results));