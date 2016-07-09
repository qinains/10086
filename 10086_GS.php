<?php
// 甘肃移动浦发提单
require_once('function.php');

$account = '13609301234';
$amount  = 10;
$orderid = exec("\"C:\\Program Files\\nodejs\\node.exe\" C:\\workspace\\common\\RandomOrderid.js");
$orderid = date("YmdHis").''.floor(microtime()*1000).'2'.rand(10,99);
$referer = 'http://www.gs.10086.cn/service/SJZF_CZ_YHCZ.html?'.$account.'&0.99&'.$amount.'&false';
$useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36';
$postdata = '[{"dynamicURI":"/login","dynamicParameter":{"method":"payFeeByMobile","reqHandle":"other", "busiNum":"SJZF_CZ","feeTomobile":"'.$account.'","amount":"'.$amount.'","banks":"SPDB","type":"PHONE_CHARGES_GATE","orderId":"'.$orderid.'"},"dynamicDataNodeName":"testNode"}]';
$httpret = curlResponse('http://www.gs.10086.cn/gs_obsh_service/actionDispatcher.do', 1, 'jsonParam='.urlencode($postdata), null, false, $referer, $useragent);
$postdata = 'SESSIONID=' . cutstr($httpret['content'], 'testNode->resultObj->sessionId', 'json');
$httpret = curlResponse('https://ipos.10086.cn/ips/OMCGPUB2/FormTrans5.dow', 1, $postdata);
die(outputXML(getFormData($httpret['content'], true)));