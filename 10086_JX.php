<?php
// 江西移动浦发提单
require_once('function.php');

header('Content-type: text/plain');

$account = '13870502305';
$amount = 10;

$useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36';
$httpret = curlResponse('http://service.jx.10086.cn/service/mobilePay.action?menuid=000100010001', false, null, null, false, null, $useragent);
$datas = getFormData(cutstr($httpret['content'], '<form id="onlienPay" name="onlienPay" action="/service/mobilePay!confirm.action;', '</form>'), true);
$postdata = 'keyId=queryPayNumberInfoBySocket&payNumber='.$account.'&payMoney='.$amount.'&menuid=0086993581&ordermenuid=000100010001&orderid='.$datas['payArgsPo.orderid'].'&t=63';
$httpret = curlResponse('http://service.jx.10086.cn/service/smallscrew', 1, $postdata);
$val_str = cutstr($httpret['content'], 'val', 'json');
if(strpos($val_str, 'M') !== false) die(outputXML('号码异常'));
$val_arr = explode('*', $val_str);
$info = explode('-', $val_arr[4]);

$datas['payArgsPo.region']  = $info[5];
$datas['payArgsPo.brandId'] = $info[2];
$datas['payArgsPo.cityId']  = $info[4];
$datas['payArgsPo.useCharge'] = $val_arr[2];
$datas['payArgsPo.mustCharge'] = $val_arr[3];
$datas['payArgsPo.numberState'] = $info[3];
$datas['payArgsPo.cityName']  = $info[1];
$datas['payArgsPo.showMoney'] = $val_arr[6].'元';
$datas['payArgsPo.cityMobile']= '江西'.$info[1].'移动';
$datas['payArgsPo.account']   = $val_arr[6];
$datas['payArgsPo.discountMoney'] = bcmul("$amount", '0.98', 2);
$datas['payArgsPo.payNumber'] = $account;
$datas['payArgsPo.payMoney']  = $amount;

$httpret = curlResponse('http://service.jx.10086.cn/service/mobilePay!confirm.action', 1, http_build_query($datas), null, false, null, $useragent);
$datas = getFormData(cutstr($httpret['content'], '<form id="onlienPay" name="onlienPay" action="/service/mobilePay!commit.action;', '</form>'), true);
$postdata = 'keyId=queryPayNumberProductType&payNumber='.$account.'&menuid=0086993581&ordermenuid=0086993581&orderid='.$datas['payArgsPo.orderid'].'&t=92';
$httpret = curlResponse('http://service.jx.10086.cn/service/smallscrew', 1, $postdata);
$val_str = cutstr($httpret['content'], 'val', 'json');
$val_arr = explode('*', $val_str);
$datas['payArgsPo.payType']  = 'cmpay_CyGw';
$datas['payArgsPo.bankCode'] = 'SPDB';
$datas['payArgsPo.brandId']  = $val_arr[0];
$datas['payArgsPo.numberState'] = $val_arr[1];
$datas['payArgsPo.countycode']	= $val_arr[2];

die(http_build_query($datas));

$httpret = curlResponse('http://service.jx.10086.cn/service/mobilePay!commit.action', 1, http_build_query($datas), null, true, null, $useragent);
$results = getFormData($httpret['content'], true);

die(outputXML($results));
