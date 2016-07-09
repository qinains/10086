<?php


require_once('function.php');



// 登录后的Cookie
$cookies = 'CCBIBS1=JsaxGgoonpegCnwcIHpheXEoEFmgEXdUTFogmXZYbFTh5XOhTaUkI5TpHAzxqHTYGIGgsH0YiJwguX6oNEwgtHUgWK2gHnE04TfTOLP2wd';
$skey = 'oURAJ9';  // <input type=hidden  id="SKEY_SHRAD" value="Z4rdgy">

$useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36';
$url = 'https://ibsbjstar.ccb.com.cn/app/B2CMainB1L1?CCB_IBSVersion=V5&SERVLET_NAME=B2CMainB1L1&ROW_NO=3&ROW_ID=6227001215110060346&BRANCHID=310000000&SKEY='.$skey.'&USERID=341226198702033764&ACC_NO=6227001215110060346&BBANK_NAME=310000000&ACC_SIGN=6227001215110060346&FLAG_CARD=0&TXCODE=100192&&';
$httpret = curlResponse($url, 1, 'sflag=1', $cookies, false, null, $useragent);
$balance = cutstr($httpret['content'], "<script>FormatAmt('", "')</script>");
die("$balance");
