$(document).ready(function(){
	
	var last;
	var user;

	function getCurrentUser(){
		
		var geting = $.get( "./api/?", {
			action: "getCurrentUser"
		});

		geting.done(function( data ) {
			user = data;
		});
	}

	getCurrentUser();


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

					
				var geting = $.get( "./api/?", {
					action: "existsRoomRequest",
					roomId:index,
					userId:user
				});

				geting.done(function( data ) {
					if (data == 1)
						$("#"+index).addClass("alredyRequested");
				});
				
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
			
				var geting = $.get( "./api/?", {
					action: "existsBedroomRequest",
					bedroomId:index,
					userId:user
				});

				geting.done(function( data ) {
					if (data == 1)
						$("#"+index).addClass("alredyRequested");
				});
				
			});
		});
	}

	$("#lookForRoomsButton").click(function(){
		last = "room";
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
		last = "bedroom";
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
			idToRequest: idToGet,
			userId: user
		});

		geting.done(function( data ) {
			alert("Se ha realizado la solicitud");
			if (last == 'room')
				$("#lookForRoomsButton").click();
			$("#lookForBedroomsButton").click();
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

