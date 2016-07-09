<?php
// 安徽移动浦发提单
require_once('function.php');

if(isset($argv) && count($argv)>0) getArgument($argv[1]);
$account = $_GET['account'];
$amount  = $_GET['amount'];

// 获取密钥
$httpret = curlResponse('http://service.ah.10086.cn/common/qryRsaKey?');
$modulus = cutstr($httpret['content'], 'modulus', 'json');
$cookie = getCookies($httpret['header']);
$reqStr = exec("\"C:\\Program Files\\nodejs\\node.exe\" C:\\workspace\\common\\RSA.js ".$modulus.' '."$account@$amount");
$reqStr = urlencode($reqStr);

// 获取订单
$httpret = curlResponse('http://service.ah.10086.cn/payfee/payment/crtPayOrder?reqStr='.$reqStr.'&acctFlag=0', 0, '', $cookie);
$orderid = cutstr($httpret['content'], 'object->order_id', 'json');

// 选择浦发网银支付
$httpret = curlResponse('http://service.ah.10086.cn/payfee/payment/payAppliayOrder?orderId='.$orderid.'&payType=3&bankAbbr=SPDB&acctFlag=0');
$redirecturl = cutstr($httpret['content'], 'object->redirecturl', 'json');

// 获取浦发提单参数
$httpret = curlResponse($redirecturl);
$results = getFormData($httpret['content'], true);

die(outputXML($results));
