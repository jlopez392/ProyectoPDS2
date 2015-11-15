var user;
var last;


function getCurrentUser(){
	var geting = $.get( "./api/?", {
		action: "getCurrentUser"
	});

	geting.done(function( data ) {
		user = data;
	});
}


function printRooms(){
	$.getJSON("./api/?action=getRooms&userId="+user, function( data ) {
		$.each(data, function( index, value ) {
			$("#roomsTable tbody").append(
				"<tr> \
					<td><small>"+index+"</small></td> \
			  		<td><small>"+value["zone"]+"</small></td> \
			  		<td><small>"+value["price"]+"</small></td> \
			  		<td><button id="+index+" class='requestButton btn'>Solicitar</btn></td> \
		  		</tr>"
			);
			
			if (value["requested"] == 1)
				$("#"+index).addClass("alredyRequested");

		});
	});
}

function printBedrooms(){
	$.getJSON("./api/?action=getBedrooms&userId="+user, function( data ) {
		$.each(data, function( index, value ) {
			$("#roomsTable tbody").append(
				"<tr> \
					<td><small>"+index+"</small></td> \
			  		<td><small>"+value["zone"]+"</small></td> \
			  		<td><small>"+value["price"]+"</small></td> \
			  		<td><button id="+index+" class='requestButton btn'>Solicitar</btn></td> \
		  		</tr>"
			);

			if (value["requested"] == 1)
				$("#"+index).addClass("alredyRequested");

		});
	});
}


function printTableHead(){

	id = (last == "room")?"idSalon":"idHabitacion"; 
	$("#roomsTable thead").empty();
	$("#roomsTable thead").append(
		"	<td><strong><small>"+id+"</small></strong></td> \
			<td><strong><small>Zona</small></strong></td> \
			<td><strong><small>Precio</small></strong></td> \
			<td><strong><small>Solicitar</small></strong></td> "
	);
	$("#roomsTable tbody").empty();

}


$(document).ready(function(){

	getCurrentUser();


	$("#lookForRoomsButton").click(function(){

		last = "room";
		printTableHead();
		printRooms();

	});


	$("#lookForBedroomsButton").click(function(){

		last = "bedroom";
		printTableHead();
		printBedrooms();

	});


	$("#roomsTable").on("click",".requestButton", function(){

		if($(this).hasClass("alredyRequested")){
			alert("Alredy Requested");
			return 0;
		}	

		actionToGet = (last == "room")?"addRoomRequest":"addBedroomRequest";
		idToGet = $(this).attr("id");

		var geting = $.get( "./api/?", {
			action: actionToGet, 
			idToRequest: idToGet,
			userId: user
		});

		geting.done(function( data ) {
			alert("Se ha realizado la solicitud");
			idButtonToClick = (last == 'room')? "#lookForRoomsButton":"#lookForBedroomsButton";
			$(idButtonToClick).click();
		});

	});


	$("#exitButton").click(function(){
		$.get( "./api/?", {
			action: "closeSession"
		});

		alert("Nos vemos...");
		$(location).attr('href',"");
	});


});