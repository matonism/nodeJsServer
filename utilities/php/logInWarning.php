<?php
	
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	if(!isset($_SESSION['user']) || !isset($_SESSION['token'])){
		echo "toastr.error('You must log in for this')";
		exit;
	}


?>