<?php
// 天津移动浦发提单
require_once('function.php');

$account = '13502001234';
$amount  = 50;

$httpret = curlResponse('http://service.tj.10086.cn/app?service=page/payfeeonlinenew.PayFeeIndex&listener=initPage');
$cookies = getCookies($httpret['header']);
$postdata = 'service=direct%2F1%2Fpayfeeonlinenew.PayFeeIndex%2F%24BankPayFee.%24Form&sp=S1&Form1=&ORDER_OBJECT='.$account.'&PAY_FEE='.$amount.'&ACTIVITY_FEE=0.99&ACTIVITY_ID=1&CHNL_CODE=E003&HOME_PHONE=%CC%EC%BD%F2%CA%D0%D2%C6%B6%AF&ORDER_CODE=';
$httpret = curlResponse('http://service.tj.10086.cn/app', 1, $postdata, $cookies);
$httpret = curlResponse('http://service.tj.10086.cn/app?service=ajaxDirect/1/payfeeonlinenew.PayFeeWay/payfeeonlinenew.PayFeeWay/javascript/PayFeeWayPart&pagename=payfeeonlinenew.PayFeeWay&eventname=bankPayMoney&&BANK=SPDB&partids=PayFeeWayPart&ajaxSubmitType=post&ajax_randomcode=0.7776209523435682', 0, null, $cookies);
$httpret = curlResponse(cutstr($httpret['content'], '"url":"', '","X_RESULTCODE"'));

die(outputXML(getFormData($httpret['content'], true)));
