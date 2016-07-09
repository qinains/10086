<?php
// 河南移动浦发提单
require_once('function.php');

$account = '13839492048';
$amount  = 1;
$payfee  = exec("\"C:\\Program Files\\nodejs\\node.exe\" C:\\workspace\\common\\HeN.js ".$amount);

// 提交表单选择浦发网银， 获取提单参数
$postdata = 'SvcNum='.$account.'&payCount='.$amount.'&payFee='.$payfee.'&presentFee=';
$httpret = curlResponse('http://service.ha.10086.cn/service/pay/bank-card-pay!payConfirm.action?menuCode=1022', 1, $postdata);
$postdata.= '&md5payCount=' . cutstr($httpret['content'],'md5payCount" type="hidden" value="', '" >') . '&payType=MP&bankCode=SPDB';
$httpret = curlResponse('http://service.ha.10086.cn/service/pay/bank-card-mobile-pay!submit.action?menuCode=1022', 1, $postdata, null, false, 'http://service.ha.10086.cn/service/pay/bank-card-pay!payConfirm.action?menuCode=1022');
$postdata = getFormData($httpret['content']);

// 提交至手支网关
$httpret = curlResponse('https://ipos.10086.cn/ips/cmpayService', 1, $postdata);
$results = getFormData($httpret['content'], true);

die(outputXML($results));
