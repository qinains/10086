<?php
// 福建移动浦发提单
require_once('function.php');

$account = '13505001234';
$amount  = 10;

$postdata = 'mobile='.$account.'&forchangyonghaoma='.$account.'&amount='.$amount.'&banks=SPDB&resultBackUrl=%2Fservice%2Fcjzfgb%2Findex.jsp&gl_back_id=3040077000000000&homeCity=595';
$httpret = curlResponse('http://www.fj.10086.cn/service/mobilepay/payBybank.do', 1, $postdata);
$httpret = curlResponse(cutstr($httpret['content'], 'window.top.location.href="', '";'));
$results = getFormData($httpret['content'], true);
die(outputXML($results));