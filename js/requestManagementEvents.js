$(document).ready(function(){

	var owner;
	var last;

	function getCurrentOwner(){
		
		var geting = $.get( "./api/?", {
			action: "getCurrentOwner"
		});

		geting.done(function( data ) {
			owner = data;
		});
	}

	getCurrentOwner();

	$("#buttonRequestManagement").attr("disabled", true);


	$("#buttonABM").click(function(){
		$(location).attr('href',"roomManagement.php");
	});

	function printRoomRequest(){
		last = "room";
		$.getJSON("./api/?action=getRoomsRequests&ownerId="+owner, function( data ) {
			$.each(data, function( index, value ) {
				$("#requestsTable tbody").append(
					"<tr> \
						<td><small>"+index+"</button></td> \
						<td><button class='selectButton btn'>"+value["idRoom"]+"</button></td> \
				  		<td><button class='showUserButton btn'>"+value["user"]+"</button></td> \
				  		<td><small>"+value["advancePayment"]+"</small></td> \
				  		<td><button id="+index+" class='confirmButton btn'>Confirmar</btn></td> \
			  		</tr>"
				);
				$(".selectButton").addClass(value["category"]);
			});
		});
	}

	function printBedroomRequest(){
		last = "bedroom";
		$.getJSON("./api/?action=getBedroomsRequests&ownerId="+owner, function( data ) {
			$.each(data, function( index, value ) {
				$("#requestsTable tbody").append(
					"<tr> \
						<td><small>"+index+"</button></td> \
						<td><button class='selectButton btn'>"+value["idBedroom"]+"</button></td> \
				  		<td><button class='showUserButton btn'>"+value["user"]+"</button></td> \
				  		<td><small>"+value["advancePayment"]+"</small></td> \
				  		<td><button id="+index+" class='confirmButton btn'>Confirmar</btn></td> \
			  		</tr>"
				);
				$(".selectButton").addClass(value["category"]);
			});
		});
	}

	function printConfirmedRequest(){
		$.getJSON("./api/?action=getConfirmedRequests&ownerId="+owner, function( data ) {
			$.each(data, function( index, value ) {
				$("#requestsTable tbody").append(
					"<tr> \
						<td><button class='showRequestDetailsButton btn'>"+index+"</button></td> \
						<td><button class='selectButton btn'>"+value["id"]+"</button></td> \
				  		<td><button class='showUserButton btn'>"+value["user"]+"</button></td> \
			  		</tr>"
				);
				$(".selectButton").addClass(value["category"]);

			});
		});
	}

	$("#roomRequestButton").click(function(){
		$("#requestsTable thead").empty();
		$("#requestsTable thead").append(
			"	<td><strong><small>IdRequest</small></strong></td> \
				<td><strong><small>IdSalon</small></strong></td> \
				<td><strong><small>Usuario</small></strong></td> \
				<td><strong><small>Senia</small></strong></td> \
				<td><strong><small>Confirmar</small></strong></td> "
		);
		$("#requestsTable tbody").empty();
		printRoomRequest();

	});

	$("#bedroomRequestButton").click(function(){
		$("#requestsTable thead").empty();
		$("#requestsTable thead").append(
			"	<td><strong><small>IdRequest</small></strong></td> \
				<td><strong><small>IdHabitacion</small></strong></td> \
				<td><strong><small>Usuario</small></strong></td> \
				<td><strong><small>Senia</small></strong></td> \
				<td><strong><small>Confirmar</small></strong></td> "
		);
		$("#requestsTable tbody").empty();
		printBedroomRequest();

	});


	$("#requestsTable").on("click",".selectButton", function(){
		$("#rightPanel").empty();
		
		category = $(this).hasClass("bedroom")? "bedroom": "room";
		url = "./api/?action=";
		url += (category == "room")? "getRoom":"getBedroom";
		id = $(this).text(); 
		url += "&id="+id;

		$.getJSON(url , function( data ) {
			$("#rightPanel").append(
"<ul class='list-group'> \
	<li class='list-group-item'><span class='input-group-addon'>Categoria: </span>"+category+"</li> \
	<li class='list-group-item'><span class='input-group-addon'>Id: </span>"+id+"</li> \
	<li class='list-group-item'><span class='input-group-addon'>Zona: </span>"+data[id]['zone']+"</li> \
	<li class='list-group-item'><span class='input-group-addon'>Precio: </span>"+data[id]['price']+"</li> \
</ul>" 

			);
			
		});	
	});

	$("#requestsTable").on("click",".confirmButton", function(){
		
		idToSend = $(this).attr("id");
		actionToGet = 	(last == "room")? "confirmRoomRequest":"confirmBedroomRequest";

		var geting = $.get( "./api/?", {
			action: actionToGet, 
			idToConfirm: idToSend
		});

		geting.done(function( data ) {
			alert(data);
		});

		(last == "room")? $("#roomRequestButton").click() : $("#bedroomRequestButton").click();

	});

	$("#requestsTable").on("click",".showUserButton", function(){
		$("#rightPanel").empty();
		username = $(this).text() 
		$.getJSON("./api/?action=getUsers", function(data) {
			userFound = data.hasOwnProperty(username);
			if (userFound)
				$("#rightPanel").append(
"<ul class='list-group'> \
	<li class='list-group-item'><span class='input-group-addon'>Username:</span> "+username+"</li> \
	<li class='list-group-item'><span class='input-group-addon'>Name: </span>"+data[username]["name"]+"</li> \
	<li class='list-group-item'><span class='input-group-addon'>Lastname: </span>"+data[username]["lastname"]+"</li> \
	<li class='list-group-item'><span class='input-group-addon'>Number Phone: </span>"+data[username]["numberPhone"]+"</li> \
</ul>"	
				);
		});
	});


	$("#requestsTable").on("click",".showRequestDetailsButton", function(){
		$("#rightPanel").empty();
		idRequest = $(this).text() 
		$.getJSON("./api/?action=getConfirmedRequests&ownerId="+owner, function(data) {
			requestFound = data.hasOwnProperty(idRequest);
			if (requestFound)
				$("#rightPanel").append(
"<ul class='list-group'> \
	<li class='list-group-item'><span class='input-group-addon'>id solicitud:</span> "+idRequest+"</li> \
	<li class='list-group-item'><span class='input-group-addon'>id salon o habitacion: </span>"+data[idRequest]["id"]+"</li> \
	<li class='list-group-item'><span class='input-group-addon'>Usuario: </span>"+data[idRequest]["user"]+"</li> \
	<li class='list-group-item'><span class='input-group-addon'>Pago adelantado: </span>"+data[idRequest]["advancePayment"]+"</li> \
</ul>" 
				);
		});
	});

	$("#confirmedRequestButton").click(function(){
		$("#requestsTable thead").empty();
		$("#requestsTable thead").append(
			"	<td><strong><small>IdRequest</small></strong></td> \
				<td><strong><small>IdRoomOrBedroom</small></strong></td> \
				<td><strong><small>Usuario</small></strong></td>"
		);
		$("#requestsTable tbody").empty();
		printConfirmedRequest();

	});

	$("#exitButton").click(function(){
		var geting = $.get( "./api/?", {
			action: "closeSession"
		});

		alert("Nos vemos...");
		$(location).attr('href',"");

	});


}); 
