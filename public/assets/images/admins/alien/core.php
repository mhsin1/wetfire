<?php
error_reporting(0);
function balance($key) {

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://control.msg91.com/api/balance.php?authkey='.$key.'&type=4',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
));

$response = curl_exec($curl);
curl_close($curl);
if ($response == '0') {
  echo "0";
} else {
  echo $response;
}

}

function send($sender, $msg, $nmra, $key) {

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.msg91.com/api/sendhttp.php?route=4&sender='.$sender.'&message='.$msg.'&country=0&mobiles='.$nmra.'&authkey='.$key,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "utf-8",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
));
$response = curl_exec($curl);
curl_close($curl);

if (balance($key) == '0' ) {
  echo "stop";
  exit();
}else{


  echo "ok";
}
}