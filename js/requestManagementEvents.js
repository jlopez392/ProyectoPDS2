$(document).ready(function(){
	
	var last;
	
	$("#buttonRequestManagement").attr("disabled", true);


	$("#buttonABM").click(function(){
		$(location).attr('href',"roomManagement.html");
	});

	function printRoomRequest(){
		$.getJSON("./api/?action=getRoomsRequests", function( data ) {
			last = "room";
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
			});
		});
	}

	function printBedroomRequest(){
		$.getJSON("./api/?action=getBedroomsRequests", function( data ) {
			last = "bedroom";
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
			});
		});
	}

	function printConfirmedRequest(){
		$.getJSON("./api/?action=getConfirmedRequests", function( data ) {
			$.each(data, function( index, value ) {
				$("#requestsTable tbody").append(
					"<tr> \
						<td><button class='showRequestDetailsButton btn'>"+index+"</button></td> \
						<td><button class='selectButton btn'>"+value["id"]+"</button></td> \
				  		<td><button class='showUserButton btn'>"+value["user"]+"</button></td> \
			  		</tr>"
				);
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
		
		url = "./api/?action=";
		url += 	(last == "room")? "getRooms":"getBedrooms";
		id = $(this).text(); 

		$.getJSON(url , function( data ) {
			$("#rightPanel").append(
				"<p><strong>Categoria: </strong>"+last+"</p> \
				<p><strong>Id: </strong>"+id+"</p> \
				<p><strong>Zona: </strong>"+data[id]['zone']+"</p> \
				<p><strong>Precio: </strong>"+data[id]['price']+"</p>" 
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
			alert(data)
		});

	});

	$("#requestsTable").on("click",".showUserButton", function(){
		$("#rightPanel").empty();
		username = $(this).text() 
		$.getJSON("./api/?action=getUsers", function(data) {
			userFound = data.hasOwnProperty(username);
			if (userFound)
				$("#rightPanel").append(
					"<p><strong>username:</strong> "+username+"</p> \
					<p><strong>name: </strong>"+data[username]["name"]+"</p> \
					<p><strong>lastname: </strong>"+data[username]["lastname"]+"</p> \
					<p><strong>numberPhone: </strong>"+data[username]["numberPhone"]+"</p>" 
				);
		});
	});

	$("#requestsTable").on("click",".showRequestDetailsButton", function(){
		$("#rightPanel").empty();
		idRequest = $(this).text() 
		$.getJSON("./api/?action=getConfirmedRequests", function(data) {
			requestFound = data.hasOwnProperty(idRequest);
			if (requestFound)
				$("#rightPanel").append(
					"<p><strong>idRequest:</strong> "+idRequest+"</p> \
					<p><strong>id: </strong>"+data[idRequest]["id"]+"</p> \
					<p><strong>user: </strong>"+data[idRequest]["user"]+"</p> \
					<p><strong>pago adelantado: </strong>"+data[idRequest]["advancePayment"]+"</p>" 
				);
		});
	});

	$("#confirmedRequestButton").click(function(){
		$("#requestsTable thead").empty();
		$("#requestsTable thead").append(
			"	<td><strong><small>IdRequest</small></strong></td> \
				<td><strong><small>Id</small></strong></td> \
				<td><strong><small>Usuario</small></strong></td>"
		);
		$("#requestsTable tbody").empty();
		printConfirmedRequest();

	});

}); 
