<?php

    class User {
		public $firstname;
		public $lastname;
		public $username;
		public $password;
		public $admin;
		public $loginLocation;
		public $token;


	    // Assigning the values
	    public function __construct($firstname, $lastname, $username, $password, $admin, $loginLocation, $token) {
			$this->token = $token;
			$this->firstname = $firstname;
			$this->lastname = $lastname;
			$this->username = $username;
			$this->password = $password;
			$this->admin = $admin;
			$this->loginLocation = $loginLocation;
			$this->token = $token;

	    }
	}

?>