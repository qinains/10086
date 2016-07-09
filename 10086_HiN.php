<?php
// 海南移动浦发提单
require_once('function.php');

$account = '15289755837';
$amount = 100;
$useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36';

$postdata = "payOne=true&payOnlyOneNumber=".$account."&payOnlyOneMoney=".$amount.'&isdiscnt=true';
$httpret = curlResponse('http://www.hi.10086.cn/service/payfeenew/generateOrders.do', 1, $postdata);
$cookies = getCookies($httpret['header']);
$orderid = cutstr($httpret['content'], '<input id="orderId" name="orderId" value="', '" type="hidden"/>');
$postdata = 'radio_zffs=SPDB&serialNumber='.$account.'&orderId='.$orderid.'&amount='.$amount.'&payfeemodecode=71&zhilian=1&operTypeCode=6&chaneltypeId=ITF002';
$httpret = curlResponse('http://www.hi.10086.cn/service/payfeenew/bossCreateOrder.do?', 1, $postdata, $cookies);
$httpret = curlResponse('http://www.hi.10086.cn/service/payfeenew/payOnBankNew.do', 1, $postdata, $cookies);
$postdata = getFormData($httpret['content'], false, 'GBK');
$httpret = curlResponse('https://unionpaysecure.com/api/Pay.action', 1, $postdata);
$postdata = getFormData($httpret['content'], false, 'GBK');
$httpret = curlResponse('https://cashier.95516.com/b2c/api/Pay.action', 1, $postdata, null, false, null, $useragent);
$postdata = cutstr($httpret['content'], 'action="https://cashier.95516.com/b2c/acronym.action?', '" method="post">');
$httpret = curlResponse('https://cashier.95516.com/b2c/acronym.action?',1, $postdata, getCookies($httpret['header']), false, null, $useragent);
$postdata = getFormData($httpret['content']);
$httpret = curlResponse('https://unionpaysecure.com/bank/acp', 1, $postdata);
$results = getFormData($httpret['content'], true);
die(outputXML($results));