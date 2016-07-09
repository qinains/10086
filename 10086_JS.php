<?php
// 江苏移动浦发提单
require_once('./function.php');

$account = '13913142399';
$amount  = '100';

// 提交表单
$useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36';
$postdata = 'reqUrl=copyOfNetPay&busiNum=WSCZYL&bankType=SPDB&mobile='.$account.'&amount='.$amount.'&activityNum=NONE&userPayCard=0&payCardNum=&fPayType=fbd';
$httpret  = curlResponse('http://service.js.10086.cn/actionDispatcher.do', 1, $postdata, '', false, '', $useragent);
$postdata = getFormData($httpret['content'], false, 'GBK');

// 获取提交浦发数据
$httpret = curlResponse('https://ipos.10086.cn/ips/cmpayService', 1, $postdata);
$result  = getFormData($httpret['content'], true);
die(outputXML($result));
