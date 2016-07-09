<?php
// 贵州移动浦发提单
require_once('function.php');

$account = '13508501234';
$amount  = 100;

$httpret = curlResponse('http://www.gz.10086.cn/upp/web/payfee/payTheFee/PayTheFeeAction?tag_id=TAG001&action=initPage');
$postdata = 'action=initPageToDirectPage&UP_CHANNEL=E003&UP_PROMOTION_TYPE=DISCOUNT&UP_PAYMENTMSG=serviceNum%3A'.$account.'%2Cpay%3A'.bcmul($amount, '0.99', 2).'%2CphonePayMoney%3A'.$amount.'&random_form='.cutstr($httpret['content'],'random_form" value=', '   />');
$cookies = getCookies($httpret['header']);
$httpret = curlResponse('http://www.gz.10086.cn/upp/web/rediretOrder/RediretOrderToPayFeeAction', 1, $postdata, $cookies);
$httpret = curlResponse('http://www.gz.10086.cn/upp/web/rediretOrder/RediretOrderAction?payType=1&action=submitOrderProcess&UP_ORGANIZATION_ID=SPDB_MOBILE', 0, null, $cookies);
$httpret = curlResponse('https://ipos.10086.cn/ips/cmpayService', 1, getFormData($httpret['content'], false, 'GBK'));
$results = getFormData($httpret['content'], true);
die(outputXML($results));