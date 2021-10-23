<?php
/**
 * Function: FormatCreditCard
 * Author : Nikhil Ben Kuruvilla
 * Date : 14th july 2010
 */
function FormatCreditCard($cc) {
    // REMOVE EXTRA DATA IF ANY
    $cc = str_replace(array('-', ' '), '', $cc);
    // GET THE CREDIT CARD LENGTH
    $cc_length = strlen($cc);
    $newCreditCard = substr($cc, -4);
    for ($i = $cc_length - 5; $i >= 0; $i--) {
        // ADDS HYPHEN HERE
        if ((($i + 1) - $cc_length) % 4 == 0) {
            $newCreditCard = ' ' . $newCreditCard;
        }
        $newCreditCard = $cc[$i] . $newCreditCard;
    }
    // RETURN THE FINAL FORMATED AND MASKED CREDIT CARD NO
    return $newCreditCard;
}

echo FormatCreditCard("4970402553334901");
?>