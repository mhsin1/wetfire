<?php

/** { Date & IP & HostName & UserAgent } ~ Info's **/

$date = @date("Y-m-d ~ H:i:s"); 
$ip = $_SERVER['REMOTE_ADDR'];
$hostname = gethostbyAddr($ip);
$useragent = $_SERVER['HTTP_USER_AGENT'];

/** ------------------------------------------------ **/

?>