<?php
// 云南移动浦发提单
require_once('function.php');
header('Content-type: text/plain;');
$account = '13508701234';
$amount  = 100;

$httpret = curlResponse('http://www.yn.10086.cn/service/app?service=ajaxDirect/1/payonline.BankPayNewEC/payonline.BankPayNewEC/javascript/&pagename=payonline.BankPayNewEC&eventname=checkCusts&pay_number='.$account.'&subSysCode=E003&LOGIN_LOG_ID=null&partids=&ajaxSubmitType=get&ajax_randomcode=0.16933951992541552');
$postdata = 'service=direct%2F1%2Fpayonline.BankPayNewEC%2F%24Form&sp=S0&Form0=user_status%2CmenuId%2CbrandCode%2CSERIALNUMBER_HOME%2CAMOUNT_HOME%2C%24FormConditional%2CpageName%2CpageName2%2CisLogin%2CloginType%2CisNewNetCustomer%2CisNewNetFirst%2CisNeedSSOVertify%2CSERIALNUMBER%2CPhonePay%2CpayMoneyMore%2CpayMoneyTenpay%2Camount_1&menuId=11282241&brandCode=ZZZZ&%24FormConditional=F&pageName=payonline.BankPayNewEC&pageName2=payonline.BankPayNewEC&isNewNetCustomer=false&isNeedSSOVertify=true&amount_1=100&self=0&others=0.99&SERIALNUMBER='.$account.'&qtje=0&bankCode=SPDB&CHOOSEBANKTYPE=SPDB&PhonePay=&zerorecharge=B&AMOUNT='.$amount;
$httpret = curlResponse('http://www.yn.10086.cn/service/app?wade_randomcode=0.009496071143075824', 1, $postdata, getCookies($httpret['header']), true);
$results = getFormData($httpret['content'], true);
die(outputXML($results));