<?php
// 宁夏移动浦发提单
require_once('function.php');

$account = '18395151234';
$amount = 30;

// 表单提交
$postdata = 'menuid=netPay&contextPath=%2Fmy&mainBaseCode=YHKJF&loginStatus=WDL&payForOneId=YHKJF_YRCZ_WDL&payForManyId=YHKJF_DRCZ_WDL&payModel=one&defaultAmount=100&maxAmount=2000&cashType=pptpPre&requireAmount=0.0&payAmount='.$amount.'&busiType=onlinePay&isUnifiedActive=1&unifiedRate=100&presentRate=101&payServer='.$account.'&repaypServer='.$account;
$httpret = curlResponse('http://nx.10086.cn/my/onlineBank_PayOrderSubmit.action', true, $postdata);
$postdata = getFormData($httpret['content'], true);
$postdata['bankname'] = 'SPDB';
$postdata['payType']  = 'bankCardPay';
$postdata['autosso']  = true;
$cookies = getCookies($httpret['header']);

// 选择浦发网银支付
$httpret = curlResponse('http://nx.10086.cn/my/onlineBank_PayWritePayInfo.action?', 1, $postdata, $cookies);
$postdata = getFormData($httpret['content']);

// 浦发手支网关提交
$httpret = curlResponse('http://www.nx.10086.cn/epay/payment/epayGatewayAction.action', 1, $postdata, '', 1);
$result  = getFormData($httpret['content'], true);
die(outputXML($result));