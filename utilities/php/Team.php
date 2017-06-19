<?php

    class Team {
	    // Creating some properties (variables tied to an object)
	    public $teamName; 
  	    public $event;
	    public $securityAnswer;
	    public $member1;
	    public $member2;
	    public $member3;
	    public $member4;
	    public $walkUpSong;
	    public $member1Display;
	    public $member2Display;
	    public $member3Display;
	    public $member4Display;
	    public $joinable;
	    public $leavable;



	    // Assigning the values
	    public function __construct($teamName, $event, $securityAnswer, $member1, $member2, $member3, $member4, $walkUpSong) {
			$this->teamName = $teamName;
			$this->event = $event;
			$this->securityAnswer = $securityAnswer;
			$this->member1 = $member1;
			$this->member2 = $member2;
			$this->member3 = $member3;
			$this->member4 = $member4;
			$this->walkUpSong = $walkUpSong;
			$this->member1Display = '';
	    	$this->member2Display = '';
	    	$this->member3Display = '';
	    	$this->member4Display = '';

	    }

	    public function setMemberDisplayName($name, $member){
	    	if($member == 1){
	    		$this->member1Display = $name;
	    	}else if($member == 2){
	    		$this->member2Display = $name;
	    	}else if($member == 3){
	    		$this->member3Display = $name;
	    	}else if($member == 4){
	    		$this->member4Display = $name;
	    	}
	    }

	    public function setJoinable($joinable){
	    	$this->joinable = $joinable;
	    }


	    public function setLeavable($leavable){
	    	$this->leavable = $leavable;
	    }
	}

?>