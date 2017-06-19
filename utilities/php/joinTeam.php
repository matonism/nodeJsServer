<?php

main();



function main(){

	if (isset($_POST['teamPassword']) && isset($_POST['teamToJoin']) && isset($_POST['eventToJoin'])) {
		include('../../utilities/php/Team.php');
		include('../../htdocs/hiddenScript.php');
		include('../../utilities/php/databaseQueryHelper.php');
		include('../../utilities/php/getTeamsDA.php');
		
		$teamToJoin = $_POST['teamToJoin'];
		$eventToJoin = $_POST['eventToJoin'];
		$teamPassword = $_POST['teamPassword'];
		$user = $_SESSION["user"];

		$conn = connectToDatabase();
		$numberOfMembersArray = queryNumberOfMembersForEvents($conn);

		$query = prepareQuery($conn, "SELECT member1, member2, member3, member4, teamName FROM Team WHERE teamName = ? AND Event = ? AND teamPassword = ?");
		$query->bind_param("sss", $teamToJoin, $eventToJoin, $teamPassword);

		$memberToAddTo = '';
		if (attemptQuery($conn, $query)){
			$query->bind_result($member1, $member2, $member3, $member4, $team);
			$query->fetch();
			if($team != null){
				$memberToAddTo = setNewMemberNumber($member1, $member2, $member3, $member4, $numberOfMembersArray);
				finishQuery($query);
			}else{
				echo 'toastr.error(\'The Team Password is incorrect\');';
				exit;
			}
		}



		$updateQuery = prepareQuery($conn, "UPDATE Team SET Member".$memberToAddTo." = ? WHERE Event = ? AND teamName = ?");
		$updateQuery->bind_param("sss", $user, $eventToJoin, $teamToJoin);

		if (attemptQuery($conn, $updateQuery)) {
			echo "toastr.success(\"you have joined " . $_POST['teamToJoin'] . "!\");";	
			exit;	
		}

	}else{
		echo "";
		exit;
	}

}


function setNewMemberNumber($member1, $member2, $member3, $member4, $numberOfMembersArray){
	$memberToAddTo = '';
	if($member1 == '' && $numberOfMembersArray[$_POST['eventToJoin']][0] >= 1){
		$memberToAddTo = '1';
	}else if($member2 == '' && $numberOfMembersArray[$_POST['eventToJoin']][0] >= 2){
		$memberToAddTo = '2';
	}else if($member3 == '' && $numberOfMembersArray[$_POST['eventToJoin']][0] >= 3){
		$memberToAddTo = '3';
	}else if($member4 == '' && $numberOfMembersArray[$_POST['eventToJoin']][0] >= 4){
		$memberToAddTo = '4';
	}else {
		echo 'toastr.error(\'You cannot join this team because it is full\');';
		exit;
	}

	return $memberToAddTo;
}

?>