<?php
include('gateway.php');
$CSGW = new P3\SDK\Gateway;
$key = 'J5eumB2w9rHX3eW3';


// Request
$req = array(
    /*'rtName' => 'PZRecurringTest - ' . uniqid(),//Name for recurring transaction agreement
    'rtDescription' => 'Lorem ipsum dolar amet',//Description  for recurring transaction agreement
    'rtPolicyRef' => 'recurring',
    'rtCycleDuration' => 1,
    'rtCycleDurationUnit' => 'day',
    'rtCycleCount' => 5,
    'rtSequenceCount' => 6,
    'rtInitialDate' => '2019-09-01 09:30:00',*/
    'merchantID' => '116994',
    'action' => 'SALE',
    'type' => 1,
    'countryCode' => 826,
    'currencyCode' => 826,
    'amount' => $_POST['Amount'],
    'cardNumber' => $_POST['CardNumber'],
    'cardExpiryMonth' => 12,
    'cardExpiryYear' => 15,
    'cardCVV' => $_POST['CVV'],
    'customerName' => 'Test Customer',
    'customerEmail' => 'test@testcustomer.com',
    'customerAddress' => '16 Test Street',
    'customerPostCode' => 'TE15 5ST',
    'orderRef' => 'Test purchase - ' .uniqid(),
    'transactionUnique' => (isset($_REQUEST['transactionUnique']) ?
    $_REQUEST['transactionUnique'] : uniqid()),
    'threeDSMD' => (isset($_REQUEST['MD']) ? $_REQUEST['MD'] : null),
    'threeDSPaRes' => (isset($_REQUEST['PaRes']) ? $_REQUEST['PaRes'] : null),
    'threeDSPaReq' => (isset($_REQUEST['PaReq']) ? $_REQUEST['PaReq'] : null)
    );

$res = $CSGW->directRequest($req);

// Check the response code
if ($res['responseCode'] == 65802) {
// Send details to 3D Secure ACS and the return here to repeat request
$pageUrl =  'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
echo "
<p>Your transaction requires 3D Secure Authentication</p>
<form action=\"" . htmlentities($res['threeDSACSURL']) . "\"method=\"post\">
<input type=\"hidden\" name=\"MD\" value=\"" . htmlentities($res['threeDSMD']) . "\">
<input type=\"hidden\" name=\"PaReq\" value=\"" . htmlentities($res['threeDSPaReq']) .
"\">
<input type=\"hidden\" name=\"TermUrl\" value=\"" . htmlentities($pageUrl) . "\">
<input type=\"submit\" value=\"Continue\">
</form>
";
} else if ($res['responseCode'] === 0) {
echo "<p>Thank you for your payment.". htmlentities($res['responseMessage']). "</p>";
} else {
echo "<p>Failed to take payment: " . htmlentities($res['responseMessage']) .
"</p>";
}


echo('<br><hr><br><h3>var_dump of $res object</h3>');

var_dump($res);