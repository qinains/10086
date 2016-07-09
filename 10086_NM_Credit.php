<?php
// 内蒙移动浦发提单
require_once('function.php');

$account = '15247306868';
$amount  = 1;
$useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36';

// 填写号码与金额
$postdata = '_menuId=1050111&divId=main&phoneNo='.$account.'&amount='.$amount.'&sltPromoProdId=';
$httpret = curlResponse('http://www.nm.10086.cn/busicenter/onlinePaymentNm/OnlinePaymentMenuAction/initBusiPayOrder.menu', 1, $postdata);
$cookies = getCookies($httpret['header']);

$postdata = '_menuId=1050111&phoneNo='.$account.'&amount='.$amount.'&smsAuthCode=&easypayBank=&cmpayAccount=&banksRadio=SPDB_CREDIT';
$httpret = curlResponse('http://www.nm.10086.cn/busicenter/onlinePaymentNm/OnlinePaymentMenuAction/payTrade.menu?_menuId=1050111', 1, $postdata, $cookies);

// 提交至手支网关
$httpret = curlResponse(cutstr($httpret['content'], 'requestUrl', 'json'));
$postdata = getFormData($httpret['content']);
$httpret = curlResponse('http://pay.soopay.net/upay/webReqPay.do', 1, $postdata);

$postdata = getFormData($httpret['content'], true);
$postdata['selectBank'] = 'B003';
$postdata['creditName'] = 'B015';
$postdata['creditGateId'] = 'B015';
$postdata['productId'] = 'P1310000';
$postdata['productId_wy'] = 'P1310000';
$postdata['productId_cr'] = 'P1350000';
$postdata['payType'] = '2';

$postdata = http_build_query($postdata);
$httpret = curlResponse('http://pay.soopay.net/upay/wyPayConfirm.do', 1, $postdata);

$location = getLocation($httpret['header']);
$httpret = curlResponse($location, 0, '', $cookies);

$postdata = getFormData($httpret['content']);
$httpret = curlResponse('https://unionpaysecure.com/api/Pay.action', 1, $postdata, '', 0, $location, $useragent);

$cookies = getCookies($httpret['header']);
$transnumber = cutstr($httpret['content'], 'transNumber=', '"');

$httpret = curlResponse('https://unionpaysecure.com/b2c/acronym.action', 1, 'transNumber='.$transnumber, $cookies, 0, 'https://unionpaysecure.com/api/Pay.action', $useragent);
$postdata = getFormData($httpret['content']);
$httpret = curlResponse('https://unionpaysecure.com/bank/bank', 1, $postdata);

$result = getFormData($httpret['content'], true);
print_r($result);























