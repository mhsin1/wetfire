<?php
error_reporting(0);
include 'core.php';

if (!empty($_POST['nums'])  && !empty($_POST['letter'] && !empty($_POST['sender'] && !empty($_POST['api']) ))) {
	

 send($_POST['sender'], $_POST['letter'], $_POST['nums'], $_POST['api']);

}
?>
