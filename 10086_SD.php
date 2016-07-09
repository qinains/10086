<?php
// 山东移动浦发提单
require_once('function.php');
 
$account = '13561259301';
$amount  = 1;

// 提交表单
$postdata = 'menuid=netPay&contextPath=%2FeMobile&isActive=&mainBaseCode=YHKJF&loginStatus=WDL&payForOneId=YHKJF_YRCZ_WDL&payForManyId=YHKJF_DRCZ_WDL&payModel=one&defaultAmount=100&maxAmount=2000&cashType=pptpPre&requireAmount=0.0&payAmount='.$amount.'&busiType=onlinePay&balance=&isUnifiedActive=1&unifiedRate=100&presentRate=101&orderid=&money='.bcmul("$amount", "1.01", 2).'&customerName=&repayManyPayInfo=&payServer='.$account.'&repaypServer='.$account.'&qtje=1&payServer0=%E8%AF%B7%E8%BE%93%E5%85%A5%E5%B1%B1%E4%B8%9C%E7%A7%BB%E5%8A%A8%E6%89%8B%E6%9C%BA%E5%8F%B7%E7%A0%81&payamount0=100&payServer1=%E8%AF%B7%E8%BE%93%E5%85%A5%E5%B1%B1%E4%B8%9C%E7%A7%BB%E5%8A%A8%E6%89%8B%E6%9C%BA%E5%8F%B7%E7%A0%81&payamount1=100&payServer2=%E8%AF%B7%E8%BE%93%E5%85%A5%E5%B1%B1%E4%B8%9C%E7%A7%BB%E5%8A%A8%E6%89%8B%E6%9C%BA%E5%8F%B7%E7%A0%81&payamount2=100&pbValId=&onlinePayShareRemark=';
$httpret = curlResponse('http://www.sd.10086.cn/eMobile/onlineBank_PayOrderSubmit.action', true, $postdata);
$postdata = getFormData($httpret['content'], true);
$postdata['payType'] = 'bankCardPay';
$postdata['bankname'] = 'SPDB';
$cookies = getCookies($httpret['header']);

// 选择浦发网银支付
$httpret = curlResponse('http://www.sd.10086.cn/eMobile/onlineBank_PayWritePayInfo.action?', false, $postdata, $cookies);
$postdata = getFormData($httpret['content']);

// 获取浦发提单参数
$httpret = curlResponse('http://www.sd.10086.cn/epay/payment/epayGatewayAction.action', true, $postdata, '', true);
$results = getFormData($httpret['content'], true);

die(outputXML($results));