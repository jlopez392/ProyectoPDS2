$(document).ready(function(){
	
	var last;

	function printRooms(){
		$.getJSON("./api/?action=getRooms", function( data ) {
			$.each(data, function( index, value ) {
				$("#roomsTable tbody").append(
					"<tr> \
						<td><small>"+index+"</small></td> \
				  		<td><small>"+value["zone"]+"</small></td> \
				  		<td><small>"+value["price"]+"</small></td> \
				  		<td><button id="+index+" class='requestButton btn'>Solicitar</btn></td> \
			  		</tr>"
				);
			});
		});
	}

	function printBedrooms(){
		$.getJSON("./api/?action=getBedrooms", function( data ) {
			bedrooms = data;
			$.each(data, function( index, value ) {
				$("#roomsTable tbody").append(
					"<tr> \
						<td><small>"+index+"</small></td> \
				  		<td><small>"+value["zone"]+"</small></td> \
				  		<td><small>"+value["price"]+"</small></td> \
				  		<td><button id="+index+" class='requestButton btn'>Solicitar</btn></td> \
			  		</tr>"
				);
			});
		});
	}

	$("#lookForRoomsButton").click(function(){
		last = "room"
		$("#roomsTable thead").empty();
		$("#roomsTable thead").append(
			"	<td><strong><small>Id</small></strong></td> \
				<td><strong><small>Zona</small></strong></td> \
				<td><strong><small>Precio</small></strong></td> \
				<td><strong><small>Solicitar</small></strong></td> "
		);
		$("#roomsTable tbody").empty();
		printRooms();
	});

	$("#lookForBedroomsButton").click(function(){
		last = "bedroom"
		$("#roomsTable thead").empty();
		$("#roomsTable thead").append(
			"	<td><strong><small>Id</small></strong></td> \
				<td><strong><small>Zona</small></strong></td> \
				<td><strong><small>Precio</small></strong></td> \
				<td><strong><small>Solicitar</small></strong></td> "
		);
		$("#roomsTable tbody").empty();
		printBedrooms();
	});

	$("#roomsTable").on("click",".requestButton", function(){

		actionToGet = (last == "room")?"addRoomRequest":"addBedroomRequest";
		idToGet = $(this).attr("id");

		var geting = $.get( "./api/?", {
			action: actionToGet, 
			idToRequest: idToGet
		});

		geting.done(function( data ) {
			alert(data)
		});

	});

	$("#exitButton").click(function(){
		var geting = $.get( "./api/?", {
			action: "closeSession"
		});

		alert("Nos vemos...");
		$(location).attr('href',"");

	});


});

