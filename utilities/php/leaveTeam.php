<?php


if (isset($_POST['teamToLeave']) && isset($_POST['eventToLeave'])) {
	include('../../utilities/php/Team.php');

	// echo 'alert(\'Im still working on joining teams - Michael\')';
	// exit;

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	
	$conn = new mysqli($_SESSION["dbhost"], $_SESSION["dbuser"], $_SESSION["dbpass"], $_SESSION["dbname"]);
	$user = $_SESSION["user"];

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	if(!($query = $conn->prepare("SELECT member1, member2, member3, member4, teamName FROM Team WHERE teamName = ? AND Event = ? AND (Member1 = ? OR Member2 = ? OR Member3 = ? OR Member4 = ?)"))){
		echo "prepare failed";
		echo $conn->error;
	}
	$query->bind_param("ssssss", $_POST['teamToLeave'], $_POST['eventToLeave'], $user, $user, $user, $user);
	$member1 = '';
	$member2 = '';
	$member3 = '';
	$member4 = '';

	$memberToRemove = '';
	if (!$query->execute()) {
	    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
	}else{
		$query->bind_result($member1, $member2, $member3, $member4, $team);
		$query->fetch();

		if($team != null){
			if($member1 == $user){
				$member1 = '';
			}else if($member2 == $user){
				$member2 = '';

			}else if($member3 == $user){
				$member3 = '';

			}else if($member4 == $user){
				$member4 = '';
			}
			while($query->fetch()){}



		}else{
			echo 'toastr.error(\'You cannot leave this team because you are not on it\');';
			exit;
		}
	}

	if ($member1 == '' && $member2 == '' && $member3 == '' && $member4 == ''){
		//delete the team

		if(!($deleteQuery = $conn->prepare("DELETE FROM Team WHERE Event = ? AND teamName = ?"))){
			echo "window.location.replace('../error2')";
			exit;
		}
		$deleteQuery->bind_param("ss", $_POST['eventToLeave'], $_POST['teamToLeave']);

		if (!$deleteQuery->execute()) {
		    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
		    exit;
		}else{
			echo "toastr.success(\"you have left and removed " . $_POST['teamToLeave'] . "!\");";	
			exit;	
		}
		


	}else{
		$memberArray = array();
		if($member1 != ''){
			array_push($memberArray, $member1);
		}

		if($member2 != ''){
			array_push($memberArray, $member2);
		}

		if($member3 != ''){
			array_push($memberArray, $member3);
		}

		if($member4 != ''){
			array_push($memberArray, $member4);
		}

		$numberOfMembers = count($memberArray);

		$i = 0;
		$blank = '';
		while ($i < 4 - $numberOfMembers){
			array_push($memberArray, $blank);
			$i = $i + 1;
		}

		if(!($updateQuery = $conn->prepare("UPDATE Team SET Member1 = ?, Member2 = ?, Member3 = ?, Member4 = ? WHERE Event = ? AND teamName = ?"))){
			echo "window.location.replace('../error2')";
			exit;
		}
		$updateQuery->bind_param("ssssss", $memberArray[0], $memberArray[1], $memberArray[2], $memberArray[3], $_POST['eventToLeave'], $_POST['teamToLeave']);

		if (!$updateQuery->execute()) {
		    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
		    exit;
		}else{
			echo "toastr.success(\"you have left " . $_POST['teamToLeave'] . "!\");";	
			exit;	
		}
	}


}else{
	echo "window.location.replace('../error')";
	exit;
}

?>