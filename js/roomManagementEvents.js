$(document).ready(function(){
	
	var owner;
	var rooms;
	var bedrooms;
	var last;

	$("#buttonABM").attr("disabled", true);


	$("#buttonRequestManagement").click(function(){
		$(location).attr('href',"requestManagement.php");
	});


	function getCurrentUser(){
		var geting = $.get( "./api/?", { 
			action: "getCurrentUser"
		});
		geting.done(function( data ) {
			owner = data;
		});
	}

	getCurrentUser();

	function printRooms(){
		$.getJSON("./api/?action=getRooms&ownerId="+owner, function( data ) {
			rooms = data;
			last = "room";
			$.each(data, function( index, value ) {
				$("#roomsTable tbody").append(
					"<tr> \
						<td><button class='selectButton btn'>"+index+"</button></td> \
				  		<td><small>"+value["zone"]+"</small></td> \
				  		<td><small>"+value["price"]+"</small></td> \
				  		<td><button id="+index+" class='deleteButton btn'>Borrar</btn></td> \
			  		</tr>"
				);
			});
		});
	}

	function printBedrooms(){
		$.getJSON("./api/?action=getBedrooms&ownerId="+owner, function( data ) {
			bedrooms = data;
			last = "bedroom";
			$.each(data, function( index, value ) {
				$("#roomsTable tbody").append(
					"<tr> \
						<td><button class='selectButton btn'>"+index+"</button></td> \
				  		<td><small>"+value["zone"]+"</small></td> \
				  		<td><small>"+value["price"]+"</small></td> \
				  		<td><button id="+index+" class='deleteButton btn'>Borrar</btn></td> \
			  		</tr>"
				);
			});
		});
	}

	$("#roomButton").click(function(){
		$("#roomsTable thead").empty();
		$("#roomsTable thead").append(
			"	<td><strong><small>Id Salon</small></strong></td> \
				<td><strong><small>Zona</small></strong></td> \
				<td><strong><small>Precio</small></strong></td> \
				<td><strong><small>Borrar</small></strong></td> "
		);
		$("#roomsTable tbody").empty();
		printRooms();
	});

	$("#bedroomButton").click(function(){
		$("#roomsTable thead").empty();
		$("#roomsTable thead").append(
			"	<td><strong><small>Id Habitacion</small></strong></td> \
				<td><strong><small>Zona</small></strong></td> \
				<td><strong><small>Precio</small></strong></td> \
				<td><strong><small>Borrar</small></strong></td> "
		);
		$("#roomsTable tbody").empty();
		printBedrooms();
	});

	$("#roomsTable").on("click",".selectButton", function(){
		$("#rightPanel").empty();
		
		category = last;
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

	$("#roomsTable").on("click",".deleteButton", function(){

		actionToGet = (last == "room")?"deleteRoom":"deleteBedroom";
		idToGet = $(this).attr("id");

		var geting = $.get( "./api/?", {
			action: actionToGet, 
			idToDelete: idToGet
		});

		geting.done(function( data ) {
			alert(data);
			(last == "room")? $("#roomButton").click() : $("#bedroomButton").click();
		});


	});

	$("#addButton").click(function(){
		$("#roomsTable thead").empty();
		$("#roomsTable tbody").empty();

		$("#rightPanel").empty();
		$("#rightPanel").append(
			'<div class="input-group"> \
					<span class="input-group-addon" id="sizing-addon2">Categoria</span> \
  					<select class="form-control" id="categoryField"> \
    					<option>Habitacion</option> \
    					<option>Salon</option> \
    				</select> \
			</div> \
			<br><div class="input-group"> \
  				<span class="input-group-addon" id="sizing-addon2">Zona</span> \
  				<input id="zoneField" type="text" class="form-control" aria-describedby="sizing-addon2"> \
  			</div> \
  			<br><div class="input-group"> \
  				<span class="input-group-addon" id="sizing-addon2">Precio</span> \
  				<input id="priceField" type="text" class="form-control" aria-describedby="sizing-addon2"> \
  			</div> \
  			<br><br><button id="addRoomOrBedroomButton" class="btn btn-default">Cargar datos</button>' 
  		);
	})
	
	/*Hacer un post a la api que se encarga de guardar los datos*/
	$("#rightPanel").on("click","#addRoomOrBedroomButton", function(){
		
		//Desactivo boton para evitar doble envio
		$("#buttonABM").attr("disabled", true);


		category = $("#categoryField").val();
		zoneToSend = $("#zoneField").val();
		priceToSend = $("#priceField").val();

		actionToGet = 	(category == "Salon")? "addRoom":
						(category == "Habitacion")? "addBedroom": false;

		var geting = $.get( "./api/?", {
			action: actionToGet, 
			zone:zoneToSend, 
			price:priceToSend,
			ownerId:owner
		});

		geting.done(function( data ) {
			alert("Cargada exitosamente");
		});
	
		//Reactivo nuevamente
		$("#buttonABM").attr("disabled", false);

	});

	$("#exitButton").click(function(){
		var geting = $.get( "./api/?", {
			action: "closeSession"
		});

		alert("Nos vemos...");
		$(location).attr('href',"");

	});



}); 
