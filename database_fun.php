<?php

function redis_conn() {
    $redis = new Redis();
    if ($redis->connect('127.0.0.1', 6379) == false) return array('status' => false, 'msg' => $redis->getLastError());
    // if ($redis->auth($redis_pass) == false) return array('status' => false, 'msg' => $redis->getLastError());
    return array('status' => true, 'con' => $redis);
}

/* $res = fseek($file, -1, SEEK_END);
$prev_page = '';
while(($c = fgetc($file)) !== false){
	if ($prev_page && $c == "\n") break;
	$prev_page = $c . $prev_page;
	fseek($file, -2, SEEK_CUR);
}
$prev_page = intval($prev_page); */

