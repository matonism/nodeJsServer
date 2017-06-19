<?php

	session_start();
if(!isset($_SESSION["token"])){
	echo "
		window.location.href='/login';
	";
	exit;
}
// echo $_SESSION["token"];
$hasTokenAccess = false;
include("../../htdocs/verifyToken.php");

if(!$hasTokenAccess){
	echo "
		alert('Your session has ended. Please log in again" . $_SESSION["token"] . "');
		window.location.href='/login';
	";
	exit;
}

echo "success123:";
echo $_SESSION["token"];


?>