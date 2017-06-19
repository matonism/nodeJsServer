<?php

	session_start();
	if(isset($_SESSION["token"])){
		$_SESSION["token"] = null;
	}

	if(isset($_SESSION["user"])){
		$_SESSION["user"] = null;
	}

	echo "document.location.reload()";


?>