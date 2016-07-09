<?php
// 陕西移动浦发提单
require_once('function.php');

$account = '13509101234';
$amount  = 100;

$httpret = curlResponse('https://service.sn.10086.cn/pay/app?service=page/BankYHKCash&listener=PayOnlineFast', 1, 'amount='.$amount.'&mobileNo='.$account, null, true);
$subvalue = cutstr($httpret['content'], '<input type="hidden" name="subValue" id="subValue" value="', '"/>');
$subId = cutstr($httpret['content'], '<input type="hidden" name="subId" id="subId" value="', '"/>');
$postdata = 'service=direct%2F1%2FBankYHKCash%2F%24Form&sp=S0&Form0=subValue%2CsubId&subValue='.$subvalue.'&subId='.$subId.'&payType=10_SPDB';
$httpret = curlResponse('https://service.sn.10086.cn/pay/app', 1, $postdata, getCookies($httpret['header']));
$postdata = getFormData(cutstr($httpret['content'], 'action="https://ipos.10086.cn/ips/cmpayService" method="get">', '</form>'), false, 'GBK');
$httpret = curlResponse('https://ipos.10086.cn/ips/cmpayService', 1, $postdata);
$results = getFormData($httpret['content'], true);
die(outputXML($results));
