<?php


include('../../htdocs/hiddenScript.php');
include('../../htdocs/encodePassword.php');
include('../../utilities/php/databaseQueryHelper.php');

attemptToLogin();

function attemptToLogin(){
	if (isset($_POST['username']) && isset($_POST['password'])) {

		$usernameAttempt = $_POST['username'];
		$passwordAttempt = $_POST['password'];
		$encodedPassword = encodePassword($passwordAttempt);

		$conn = connectToDatabase();

		$query = prepareQuery($conn, "SELECT username, admin FROM User WHERE username=? AND password=?");
		$query->bind_param("ss", $usernameAttempt, $encodedPassword);
		if (attemptQuery($conn, $query)){
			$query->bind_result($user, $admin);
			$query->fetch();
			if($user == $usernameAttempt){
				setUserTokenAndSessionVariables($user);
				echo "document.location.reload();";
	   			exit;
			}else{
				echo "toastr.error('Your username and password are incorrect');";
				exit;
			}
			
		}

	}
}

function setUserTokenAndSessionVariables($user){
	$_SESSION["user"] = $user;
	include('../../htdocs/assignSecurityToken.php');
}


?>
