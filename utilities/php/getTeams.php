<?php

	include('../../utilities/php/Team.php');
	include('../../htdocs/hiddenScript.php');
	include('../../utilities/php/databaseQueryHelper.php');
	include('../../utilities/php/getTeamsDA.php');


	main();
	

	function main(){
		$conn = connectToDatabase();

		$user = '';
		if(isset($_SESSION["user"])){ $user = $_SESSION["user"]; }

		$userArray = queryAllUsers($conn);
		$numberOfMembersArray = queryNumberOfMembersForEvents($conn);
		$restrictedEventArray = queryRestrictedEventsForUser($conn, $user);

		

		$query = prepareQuery($conn, "SELECT teamName, Event, Member1, Member2, Member3, Member4, walkUpSong FROM Team");
		if (attemptQuery($conn, $query)){
			//query succeeded
			$query->bind_result($name, $event, $member1, $member2, $member3, $member4, $walkUpSong);
			
			$eventArray = array();

			while($query->fetch()){

				$team = new Team($name, $event, null, $member1, $member2, $member3, $member4, $walkUpSong);
				setMemberDisplayNames($userArray, $team);

				setIsJoinable($user, $numberOfMembersArray, $team, $event, $restrictedEventArray);
				setIsLeavable($user, $numberOfMembersArray, $team, $event, $restrictedEventArray);
				if(!array_key_exists($event, $eventArray)){
					$eventArray[$event] = array();
				}
				array_push($eventArray[$event], $team);
			}

			echo json_encode($eventArray);
			
		}

		return false;
	}


	// ****************** FUNCTIONS ************************

 

?>