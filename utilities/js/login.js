function checkForLogin(){
	
	$(document).ready(function(){
	  	$.ajax({
		    type: "POST",
		    url: "../utilities/php/checkIfLoggedIn.php",
		    dataType: 'text',  // what to expect back from the PHP script, if anything
	        cache: false,
	        contentType: false,
	        processData: false,
		    success: function(php_script_response){
		    	if(php_script_response != 0){
		    		document.getElementById("login-button").style.display = "none";
		    		document.getElementById("logout-button").style.display = "block";
		    		$("#username-display").html(php_script_response);
		    		attemptLogout();
		    		return 1;
		    	}else {
		    		document.getElementById("logout-button").style.display = "none";
		    		document.getElementById("login-button").style.display = "block";
		    		attemptLogin();
		    		return 0;
		    	}
		    },
		    error: function (jqXHR, exception) {
		    	attemptLogin();
		    	return 0;
		    }
	  	})
	});
}



function attemptLogout(){

	$(document).ready(function(){
	  $('.logout-action').click(function() { 
		$.ajax({
		    type: "POST",
		    url: "../utilities/php/logout.php",
		    dataType: 'text',  // what to expect back from the PHP script, if anything
	        cache: false,
	        contentType: false,
	        processData: false,
		    success: function(php_script_response){
		    	eval(php_script_response);
		    }
	  	})
		});
	});
}


function attemptLogin(){

	$(document).ready(function() {
	    $('#loginForm').submit(function(e) {
	        // Stop the regular post action
	        e.preventDefault();

	        var $form = $(this);
	        var action = $form[0].action;
	        var method = $form[0].method;
	 		var username = $('input[name="login-username"]').val();
	 		var password = $('input[name="login-password"]').val();

	 		var loginInputIdToValue = createInputIdToValueMap(username, password);
	 		helperFunctions.functions.removeInputFieldErrors(loginInputIdToValue);

	 		
	 		if(!helperFunctions.functions.invalidInputFields(loginInputIdToValue)){
				$.ajax({
		            url: action, // point to server-side PHP script 
		            data: ({
		            	username: username,
		            	password: password,
		            }),                         
		            type: method,
		            success: function(php_script_response){
		            	eval(php_script_response);
		            	
		            }
		 		});
			}
	    });
	});
}

function createInputIdToValueMap(username, password){
	var loginInputIdToValue = {};
	loginInputIdToValue["username"] = {"id":"login-username","value":username};
	loginInputIdToValue["password"] = {"id":"login-password","value":password};
	return loginInputIdToValue;
}

