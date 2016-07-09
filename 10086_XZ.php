<?php
// 西藏移动浦发提单
require_once('function.php');

$account = '13518911122';
$amount  = 10;

$httpret = curlResponse('http://xz.10086.cn/service/fee/sjzfwyjf.jsp');
$token = cutstr($httpret['content'], '<input type="hidden" name="csrfToken" id="csrfToken" value="', '"/>');
$cookies = getCookies($httpret['header']);
$httpret = curlResponse('http://xz.10086.cn/service/app?service=ajaxService/1/fee.PayFee/fee.PayFee/javascript/&pagename=fee.PayFee&eventname=genOrdIdAndSetItToSession&SERIALNUMBER='.$account.'&ID=4055&csrfToken='.$token.'&partids=&ajaxSubmitType=post&ajax_randomcode=0.739484388846904&autoType=false', 0, null, $cookies);
$orderid = cutstr(trim($httpret['content'], '[]'), 'MOBILE_OR_BANK_PAY_ORD_ID', 'json');
$httpret = curlResponse('http://xz.10086.cn/service/app?service=page/fee.PayFee&listener=tosubmitBusi&ID=4055&bankCode=SPDB&SERIALNUMBER='.$account.'&SERIALNUMBER2='.$account.'&orderId='.$orderid.'&amount='.$amount.'&amountSign=a2f72c1bfcc11563daca1285d01e747b&csrfToken='.$token, 0, null, $cookies, true);
$results = getFormData($httpret['content'], true);
die(outputXML($results));