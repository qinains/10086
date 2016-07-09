<?php
// 广西移动浦发提单
require_once('function.php');

$account = '13507701235';
$amount = 100;

$httpret = curlResponse('http://service.gx.10086.cn/fee/czjf2.jsp');
$cookies = getCookies($httpret['header']);
$httpret = curlResponse('http://service.gx.10086.cn/ncs/acceptpayfee/AcceptPayFeeAction/initBusi.menu', 1, '_menuId=201309171921', $cookies, false, 'http://service.gx.10086.cn/fee/czjf2.jsp');
$postdata = 'pay_type=1&submitamount=50&confirmMobile='.$account.'&orderId=&userToken=&checkVefFlag=&type=bank&pay_mode=3&bank=SPDB&mobile='.$account.'&amount='.$amount.'&_menuId=201309171921&quickPayDirect=0&quickPayType=6&banks=SPDB';
$httpret = curlResponse('http://service.gx.10086.cn/ncs/acceptpayfee/AcceptPayFeeAction/doBusi.menu', 1, $postdata, $cookies, false, 'http://service.gx.10086.cn/fee/czjf2.jsp');
$httpret = curlResponse('https://ipos.10086.cn/ips/OMCGPUB2/FormTrans5.dow', 1, getFormData($httpret['content']));
die(outputXML(getFormData($httpret['content'], true)));