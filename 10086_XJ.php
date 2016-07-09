<?php
// 新疆移动浦发提单
require_once('function.php');

$account = '13609901234';
$amount  = 100;

$httpret = curlResponse('http://www.xj.10086.cn/service/payfee/payfeeonline/PayFeeDiscount/initPage.html&&ID=2014092000003342');
$token = cutstr($httpret['content'], '<input type="hidden" name="com.ailk.ech.framework.html.TOKEN" id="com.ailk.ech.framework.html.TOKEN" value="', '" />');
$postdata = 'service=direct%2F1%2Fpayfeeonline.PayFeeDiscount%2F%24Form&sp=S0&Form0=&goodsId=2014092000003342&mobileId='.$account.'&remobileId='.$account.'&gateId=SPDB&epayId=ICBC&subAct=%C8%B7%C8%CF&payfeeCustId=&PAY_WAY=OnlineJX&preferType=FEE4&productType=0&amtDollar=100&tjPhone=&bankPayCode=ICBC&transDate=&inMondeCode=2&backUrl=&backSerUrl=&orderId=&signcode=&bankpayflag=&CHILD_GOODS_ID=2014110100001570&operHipInfo=&com.ailk.ech.framework.html.TOKEN='.$token;
$httpret = curlResponse('http://www.xj.10086.cn/app?service=page/payfeeonline.PayFeeDiscount&listener=PaySubmit&ID=2014092000003342', 1, $postdata, null, true);
$httpret = curlResponse('https://payment.chinapnr.com/pay/SpdbC2M1Trans.jsp?GateId=16', 1, getFormData($httpret['content'], false, 'GBK'), getCookies($httpret['header']));
die(outputXML(getFormData($httpret['content'], true)));