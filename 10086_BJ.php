<?php
// 北京移动浦发提单
require_once('function.php');

$account = '13401001234';
$amount  = 100;

$httpret = curlResponse('http://epay.bj.chinamobile.com/paymentAction.do?method=pageInit');
$token = cutstr($httpret['content'], 'name="org.apache.struts.taglib.html.TOKEN" value="', '"></div>');
$cookies = getCookies($httpret['header']);
$vcode = autoRecognition('http://epay.bj.chinamobile.com/internetFee_new/jsp/public/autheCode.jsp?_cache=1430188787391', '1004', $cookies);
$postdata = 'org.apache.struts.taglib.html.TOKEN='.$token.'&method=btnGoPayReCharge&sort=&key=&commonPay='.$amount.'&billMoney=&pay_type=&interval_zz=10572&interval_balance=480&payPhone='.$account.'&queryPhone=%B2%E9%D1%AF%B3%E4%D6%B5%BA%C5%C2%EB&otherMoney=&imgCode='.$vcode['vcode'];
$httpret = curlResponse('http://epay.bj.chinamobile.com/paymentAction.do', 1, $postdata, $cookies);
$postdata = getFormData($httpret['content'], true);
$postdata['nextMethod'] = 'btnGoPay';
$postdata['pay_bank_id'] = '100901;SPDB';
$httpret = curlResponse('http://epay.bj.chinamobile.com/paymentAction2.do', 1, http_build_query($postdata), null, false, 'http://epay.bj.chinamobile.com/paymentAction.do');
$httpret = curlResponse('https://ipos.10086.cn/ips/cmpayService', 1, getFormData($httpret['content'], false, 'GBK'));
die(outputXML(getFormData($httpret['content'], true)));

