$(document).ready(function(){


	$(".loginButton").click(function(){

		userToSend = $("#usernameField").val();
		passwordToSend = $("#passwordField").val();
		
		isUser = $(this).val() == "user";
		actionToGet = isUser ?"validateUser": "validateOwner";

		var geting = $.get( "./api/?", {
			action: actionToGet, 
			username: userToSend,
			password: passwordToSend
		});

		geting.done(function( data ) {
			if (data == 1){
				urlToRedirect = isUser? "userView.php":"roomManagement.php";
				alert("Wellcome");
				$(location).attr('href',urlToRedirect);
			}
			
			alert("Wrong user or password");
		});

	});


});
