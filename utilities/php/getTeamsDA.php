<?php



	function queryNumberOfMembersForEvents($conn){
		$eventQuery = prepareQuery($conn, "SELECT Name, Description, numberOfMembers FROM Event");

		$numberOfMembersArray = array();
		if(attemptQuery($conn, $eventQuery)){
			$eventQuery->bind_result($eventName, $eventDescription, $numberOfMembers);

			while($eventQuery->fetch()){
				if(!array_key_exists($eventName, $numberOfMembersArray)){
					$numberOfMembersArray[$eventName] = array();
				}
				array_push($numberOfMembersArray[$eventName], $numberOfMembers);
			}

		}
		return $numberOfMembersArray;
	}

	function queryRestrictedEventsForUser($conn, $user){
		$restrictedEventArray = array();

		if($user != ''){

			$query = prepareQuery($conn, "SELECT event, teamName FROM Team WHERE (Member1 = ? OR Member2 = ? OR Member3 = ? OR Member4 = ?)");
			$query->bind_param("ssss", $user, $user, $user, $user);
			
			if(attemptQuery($conn, $query)){

				$query->bind_result($eventReturned2, $teamNameReturend2);
				while($query->fetch()){
					if(!array_key_exists($eventReturned2, $restrictedEventArray)){
						array_push($restrictedEventArray, $eventReturned2);
					}
				}
			}

		}

		return $restrictedEventArray;

	}

	function setMemberDisplayNames($userArray, $team){
    	if($team->member1 != null){
    		$team->setMemberDisplayName($userArray[$team->member1], 1);
    	}

    	if($team->member2 != null){
			$team->setMemberDisplayName($userArray[$team->member2], 2);
    	}

    	if($team->member3 != null){
			$team->setMemberDisplayName($userArray[$team->member3], 3);
    	}

    	if($team->member4 != null){
			$team->setMemberDisplayName($userArray[$team->member4], 4);
    	} 


    }

    function setIsJoinable($user, $numberOfMembersArray, $team, $event, $restrictedEventArray){
    	if($user != ''){
			$isJoinable = true;

			if(allTeamSlotsAreFilled($team, $numberOfMembersArray,  $event) || in_array($event, $restrictedEventArray)){
				$isJoinable = false;
			}
			$team->setJoinable($isJoinable);
		}
    }

	function setIsLeavable($user, $numberOfMembersArray, $team, $event, $restrictedEventArray){
    	if($user != ''){
			$isLeavable = false;
			if(userIsAlreadyOnTeam($user, $team)) {
				$isLeavable = true;
			}
			$team->setLeavable($isLeavable);
		}
	}

    function allTeamSlotsAreFilled($team, $numberOfMembersArray, $event){
    	if($team->member1 != '' && $team->member2 != '' && $numberOfMembersArray[$event][0] == 2){
			return true;
		}else if($team->member1 != '' && $team->member2 != '' && $team->member3 != '' && $team->member4 != '' && $numberOfMembersArray[$event][0] == 4) {
			return true;
		}else{
			return false;
		}
    }

    function userIsAlreadyOnTeam($user, $team){
		return ($team->member1 == $user || $team->member2 == $user || $team->member3 == $user || $team->member4 == $user);
    }

?>