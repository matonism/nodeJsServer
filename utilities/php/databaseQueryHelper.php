<?php



	function connectToDatabase(){
		$conn = new mysqli($_SESSION["dbhost"], $_SESSION["dbuser"], $_SESSION["dbpass"], $_SESSION["dbname"]);

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		return $conn;
	}

	function prepareQuery($conn, $queryString){
		if(!($query = $conn->prepare($queryString))){
		    die("<error> prepare failed: " . $conn->error . "<error>");
		}else{
			return $query;
		}
	}

	function attemptQuery($conn, $query){
		if (!$query->execute()) {
		    die("<error> query failed: (" . $conn->errno . ") " . $conn->error . "<error>");
		}else{
			return true;
		}
	}


	function queryAllUsers($conn){
		$userQuery = prepareQuery($conn, "SELECT firstName, lastName, username FROM User");

		if (attemptQuery($conn, $userQuery)){
			$userQuery->bind_result($firstName, $lastName, $username);

			$userArray = array();
			while($userQuery->fetch()){
				if(!array_key_exists($username, $userArray)){
					$userArray[$username] = array();
					array_push($userArray[$username], $firstName . ' ' . $lastName);
				}
			}

			return $userArray;
		}
		return null;
	}

	function teamExists($conn, $event, $teamName){
		$query = prepareQuery($conn, "SELECT event, teamName FROM Team WHERE event=? AND teamName=?");
		$query->bind_param("ss", $event, $teamName);

		if (attemptQuery($conn, $query)){
			$query->bind_result($eventReturned, $teamNameReturned);
			$query->fetch();

			if($eventReturned != null){
				return true;
			}else{
				return false;
			}
		}
	}

	function finishQuery($query){
		while($query->fetch()){}
	}

	function showErrorPage(){
		echo "window.location.replace('../error')";
		exit;
	}

?>