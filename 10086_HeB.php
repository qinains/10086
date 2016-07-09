<?php
// 河北移动浦发提单
require_once('function.php');

$account = '13931507908';
$amount  = 60;

// 提交表单
$postdata = 'bizFlag=charge&chargeFlag=false&personsChargeType=0&telnum='.$account.'&payable_amount='.$amount;
$httpret = curlResponse('http://www.he.10086.cn/service/onlinepay/onlinePayAction!showPayPage.action', true, $postdata);
$postdata = getFormData($httpret['content'], true);
$postdata['payTool'] = 'PHONEPAY';
$postdata['payChannel'] = 'PHONEPAY';
$postdata['gateId'] = 'SPDB';
$cookie = getCookies($httpret['header']);

// 获取浦发提单数据
$httpret = curlResponse('http://www.he.10086.cn/service/onlinepay/onlinePayAction!onlineCharge.action?', true, $postdata, $cookie);
$postdata = getFormData($httpret['content']);

// 手支浦发提单
$httpret = curlResponse('http://www.he.10086.cn/epay/payment/epayGatewayAction.action', true, $postdata, '', true);
$results = getFormData($httpret['content'], true);

die(outputXML($results));