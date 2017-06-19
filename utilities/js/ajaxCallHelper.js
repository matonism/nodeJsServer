	

var ajaxCallHelper = (function(ajaxCallHelper){

	ajaxCallHelper.functions = {
		handleResponseScript : handleResponseScript
	}



	return ajaxCallHelper;

	function handleResponseScript(response){
		if(shouldEvalResponse(response)){
			if(response.includes('<eval>')){
				response = response.replace('<eval>', '');
				response = response.replace('</eval>', '');
			}
			eval(response);
			return null;
		}else if(shouldThrowError()){
			document.getElementsByTagName("BODY")[0].innerHTML = getErrorPageString();
			console.log('error: ' + response);
			return null;
		}else{
			return handleResponseScript;
		}
	}

	function shouldEvalResponse(response){
		if(typeof response == "string"){
			return (
				response.includes('toastr.') || response.includes('console.') || response.includes('window.') || response.includes('location.') || response.includes('<eval>')
			);
		}else{
			return false;
		}
	}
	function shouldThrowError(response){
		if(typeof response == "string"){
			return (
				response.includes('<error>.') || response.includes('<warning>')
			);
		}else{
			return false;
		}
	}


	function getErrorPageString(){
		"<div class=\"triangle\"></div><div class=\"triangle-title-text\">Ultimate <br/>Summer <br/>Party</div><div class=\"container-fluid\"><div class=\"row title-bar-row\"><div class=\"title-bar\"><div class=\"col-xs-12 col-md-12 quick-link-bar\"><div class=\"row\"><div class=\"login-button\" id=\"login-button\"><div class=\"dropdown dropdown-style\"><a class=\"dropdown-toggle dropdown-login-toggle-style\" href=\"#\" data-toggle=\"dropdown\">Log In <strong class=\"caret\"></strong></a><div class=\"dropdown-menu dropdown-login-menu-style\"><form action=\"../utilities/php/login.php\" id=\"loginForm\" method=\"post\" accept-charset=\"UTF-8\"><input type=\"username\" class=\"form-control dropdown-username-style\" id=\"login-username\"name=\"login-username\" aria-describedby=\"usernameHelp\" placeholder=\"Username\"><input type=\"password\" class=\"form-control dropdown-password-style\" id=\"login-password\" name=\"login-password\" placeholder=\"Password\"><input class=\"btn btn-primary dropdown-login-button\" type=\"submit\" name=\"commit\" value=\"Sign In\"/><a href=\"../createAccount\">Create an account</a></form></div></div></div><div class=\"logout-button\" id=\"logout-button\"><div class=\"dropdown dropdown-style\"><a class=\"dropdown-toggle dropdown-logout-toggle-style\" href=\"#\" data-toggle=\"dropdown\"> <div class=\"dropdown-logout-text\">Account <strong class=\"caret\"></strong></div></a><div class=\"dropdown-menu dropdown-logout-menu-style\"><div id=\"username-display\" class=\"dropdown-username-display\">username</div><div class=\"centered-text\"><a class=\"dropdown-item logout-action\" href=\"#\">Log Out</a></div></div></div></div><a href=\"../teams\"><div class=\"quick-link-button\">Teams</div></a><a href=\"../events\"><div class=\"quick-link-button\">Events</div></a><a href=\"../\"><div class=\"quick-link-button\">About</div></a></div></div></div></div><br/><br/><br/><br/><br/><div class=\"row\"><div class=\"col-xs-4 col-xs-offset-2\" style=\"text-align: right;\"><br/><br/><br/><br/><br/><div class=\"attraction-description\">Something went wrong.  Please refresh the page or return to the home page</div><br/><div><a href=\"../\"><span class=\"create-team-button\"> Return to Home Page</span></a></div></div><div class=\"col-xs-4\" style=\"text-align: left;\"><img src=\"../images/error.jpg\" height=\"300px\"/></div></div><br/><br/><br/><br/><br/><div class=\"row\"><div class=\"footer\"><div class=\"footer-container\"><div class=\"row footer-top-border\"></div><div class=\"row footer-inner-container\"><div class=\"col-xs-12\"><div class=\"footer-header\">Ultimate Summer Party&trade; 2017</div><div class=\"footer-content\">Rich Matonis | 216-633-2334 • Mike Matonis | 216-406-8704 <br/>ultimatesummerpartyseries@gmail.com</div></div></div></div></div></div></div><script>resizeFunctions.functions.initialActions();checkForLogin();</script>";
	}



})(ajaxCallHelper || []);