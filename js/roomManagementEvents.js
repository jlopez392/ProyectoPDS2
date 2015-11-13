$(document).ready(function(){
	
	var rooms;
	var bedrooms;
	var last;

	$("#buttonABM").attr("disabled", true);


	$("#buttonRequestManagement").click(function(){
		$(location).attr('href',"requestManagement.html");
	});

	function printRooms(){
		$.getJSON("./api/?action=getRooms", function( data ) {
			rooms = data;
			last = "room"
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
		$.getJSON("./api/?action=getBedrooms", function( data ) {
			bedrooms = data;
			last = "Bedroom"
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
		item = (rooms[$(this).text()])? rooms : bedrooms;
		$("#rightPanel").empty();
		$("#rightPanel").append(
			"<ul class='list-group'> \
			<li class='list-group-item'><strong>Categoria:</strong> "+$(this).text()+"</li> \
			<li class='list-group-item'><strong>Id: </strong>"+$(this).text()+"</li> \
			<li class='list-group-item'><strong>Zona: </strong>"+item[$(this).text()]['zone']+"</li> \
			<li class='list-group-item'><strong>Precio: </strong>"+item[$(this).text()]['price']+"</li> \
			</ul>" 

			);
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
					<span class="input-group-addon" id="sizing-addon2"">Categoria</span> \
  					<select class="form-control" id="categoryField"> \
    					<option>Habitacion</option> \
    					<option>Salon</option> \
    				</select> \
			</div> \
			<br><div class="input-group"> \
  				<span class="input-group-addon" id="sizing-addon2"">Zona</span> \
  				<input id="zoneField" type="text" class="form-control" aria-describedby="sizing-addon2"> \
  			</div> \
  			<br><div class="input-group"> \
  				<span class="input-group-addon" id="sizing-addon2"">Precio</span> \
  				<input id="priceField" type="text" class="form-control" aria-describedby="sizing-addon2"> \
  			</div> \
  			<br><br><button id="addRoomOrBedroomButton" class="btn btn-default">Cargar datos</button>' 
  		);
	})
	
	/*Hacer un post a la api que se encarga de guardar los datos*/
	$("#rightPanel").on("click","#addRoomOrBedroomButton", function(){
		
		category = $("#categoryField").val();
		zoneToSend = $("#zoneField").val();
		priceToSend = $("#priceField").val();

		actionToGet = 	(category == "Salon")? "addRoom":
						(category == "Habitacion")? "addBedroom": false;

		var geting = $.get( "./api/?", {
			action: actionToGet, 
			zone:zoneToSend, 
			price:priceToSend
		});

		geting.done(function( data ) {
			alert(data)
		});
	
	});


}); 
