<?php

session_start();
if(!isset($_SESSION["token"]) || !isset($_SESSION["user"])){
	echo 0;
	exit;
}else{
	$hasTokenAccess = false;
	include("../../htdocs/verifyToken.php");

	// if(!$hasTokenAccess){
	// 	echo 0;
	// 	exit;
	// }else{
		echo $_SESSION["user"];
		exit;
	// }
}


?>