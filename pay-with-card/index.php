
<p>Enter your card details</p>
<form action="process.php" method="post">
    <input type="hidden" name="return_url" value="<?= $_GET['return_url'] ?>" id="return_url">

<label>CardNumber</label><br>
<input type="text" name="CardNumber" value="4012001037141112"><br>

<label>CVV</label><br>
<input type="text" name="CVV" value="083"><br>

<label>Amount (in minor currency, i.e. &pound;12.34 = 1234)<br>
<input id="amount" type="text" name="Amount" value="<?= $_GET['amount'] ?>"><br>

<input type="submit" value="Continue">
</form>