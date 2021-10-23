<!doctype HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CRoboto+Slab:400,700"
              rel="stylesheet">
        <link rel="icon" type="image/png" href="https://wetfire.co.uk/assets/images/favicon/favicon.ico">
        
        <link rel="apple-touch-icon" href="apple-touch-icon.html">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/xsIcon.css">
        <link rel="stylesheet" href="assets/css/isotope.css">
        <link rel="stylesheet" href="assets/css/magnific-popup.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="assets/css/animate.css">
        
        <link rel="stylesheet" href="assets/css/plugins.css"/>
        
        <link rel="stylesheet" href="assets/css/style.css">
        
        <link rel="stylesheet" href="assets/css/responsive.css"/>
    </head>
    <body>
        <?php
            include('gateway.php');
            $CSGW = new P3\SDK\Gateway;
            $key = $merchantSecret;
            
            
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
                'merchantID' => $merchantID,
                'action' => 'SALE',
                'type' => 1,
                'countryCode' => 826,
                'currencyCode' => 826,
                'amount' => ($_POST['Amount']),
                'cardNumber' => $_POST['CardNumber'],
                'cardExpiryMonth' => $_POST['exp_month'],
                'cardExpiryYear' => $_POST['exp_year'],
                'cardCVV' => $_POST['CVV'],
                'customerName' => $_POST['CardHolder'],
                'customerEmail' => $_POST['customerEmail'],
                'customerAddress' => $_POST['customerAddress'],
                'customerPostCode' => $_POST['customerPostCode'],
                'orderRef' => 'wetfire-purchase - ' .uniqid(),
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
            $pageUrl =  'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            ?>
            <section class="waypoint-tigger xs-section-padding">
        		<div class="container">
        			<div class="row">
        				<div class="col-md-12 col-lg-12" style="padding-top:15%; text-align:center">
        				    <div class="xs-text-content xs-pr-20">
            <?php
            echo "
            <p>Your transaction requires 3D Secure Authentication</p>
            <form action=\"" . htmlentities($res['threeDSACSURL']) . "\"method=\"post\">
            <input type=\"hidden\" name=\"MD\" value=\"" . htmlentities($res['threeDSMD']) . "\">
            <input type=\"hidden\" name=\"PaReq\" value=\"" . htmlentities($res['threeDSPaReq']) .
            "\">
            <input type=\"hidden\" name=\"TermUrl\" value=\"" . htmlentities($pageUrl) . "\">
            <input type=\"submit\" value=\"Continue\" class=\"btn btn-primary\">
            </form>
            ";
            ?>
                            </div>
        				</div>
        			</div>
        		</div>
        	</section>
            <?php
            } else if ($res['responseCode'] === 0) {
            ?>
            <section class="waypoint-tigger xs-section-padding">
        		<div class="container">
        			<div class="row">
        				<div class="col-md-12 col-lg-12" style="padding-top:15%; text-align:center">
        					<div class="xs-text-content xs-pr-20">
        					    <form action="https://wetfire.co.uk/checkout/payment/return-card-payment" method="post">
        					        <h2 class="color-navy-blue"><i style="background: #2cc391;color: white;padding: 1%;border-radius: 50%;" class="fa fa-check"></i> &nbsp; Transaction Successful! Thank you for your payment. </h2>
                                    <input type="hidden" name="transaction_json_response" value='<?php echo json_encode($res); ?>'><br>
                                    <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-file"></i> View Order</button>
                                </form>
        					</div>
        				</div>
        			</div>
        		</div>
        	</section>
            <?php
            } else {
            ?>
            <section class="waypoint-tigger xs-section-padding">
        		<div class="container">
        			<div class="row">
        				<div class="col-md-12 col-lg-12" style="padding-top:15%; text-align:center">
        					<div class="xs-text-content xs-pr-20">
        					    <!--<form action="http://wetfire.co.uk/checkout/payment/return-card-payment" method="post">-->
        					        <h2 class="color-navy-blue"><i style="background: #da4646;color: white;padding: 16px 20px 16px 20px; border-radius: 50%;" class="fa fa-times"></i> &nbsp; Transaction Unsuccessful! <?= htmlentities($res['responseMessage']); ?>.</h2>
                                    <input type="hidden" name="transaction_json_response" value='<?php echo json_encode($res); ?>'><br>
                                    <a href="https://wetfire.co.uk/checkout"><button type="button" class="btn btn-lg btn-success"><i class="fa fa-arrow-left"></i> Go to Checkout</button></a>
                                <!--</form>-->
        					</div>
        				</div>
        			</div>
        		</div>
        	</section>
            <?php
            }
        ?>
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/isotope.pkgd.min.js"></script>
        <script src="assets/js/jquery.magnific-popup.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/jquery.waypoints.min.js"></script>
        <script src="assets/js/jquery.countdown.min.js"></script>
        <script src="assets/js/spectragram.min.js"></script>
    </body>
</html>


<!--echo('<br><hr><br><h3>var_dump of $res object</h3>');

var_dump($res);-->