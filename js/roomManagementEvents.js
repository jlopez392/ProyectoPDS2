var owner;
var last;


function getCurrentUser(){
	var geting = $.get( "./api/?", { 
		action: "getCurrentUser"
	});

	geting.done(function( data ) {
		owner = data;
	});
}


function printRooms(){
	$.getJSON("./api/?action=getRooms&ownerId="+owner, function( data ) {
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


function printTableHead(){
	id = (last == "room")?"idSalon":"idHabitacion"; 
	$("#roomsTable thead").empty();
	$("#roomsTable thead").append(
		"	<td><strong><small>"+id+"</small></strong></td> \
			<td><strong><small>Zona</small></strong></td> \
			<td><strong><small>Precio</small></strong></td> \
			<td><strong><small>Borrar</small></strong></td> "
	);
	$("#roomsTable tbody").empty();
}


function appendIntoRightPanel(values){
	$("#rightPanel").empty();
	generatedStringToAppend = "<ul class='list-group'>";
	$.each(values, function( index, value ) {
		generatedStringToAppend += "<li class='list-group-item'>";
		generatedStringToAppend += "<span class='input-group-addon'>"+index+"</span>"; 
		generatedStringToAppend += value;
		generatedStringToAppend += "</li>";
	});
	generatedStringToAppend += "</ul>";
	$("#rightPanel").append(generatedStringToAppend);
}

$(document).ready(function(){
	
	getCurrentUser();

	$("#buttonABM").attr("disabled", true);


	$("#buttonRequestManagement").click(function(){
		$(location).attr('href',"requestManagement.php");
	});

	
	$("#roomButton").click(function(){
		last = "room";
		printTableHead();
		printRooms();
	});


	$("#bedroomButton").click(function(){
		last = "bedroom";
		printTableHead();
		printBedrooms();
	});


	$("#roomsTable").on("click",".selectButton", function(){
		id = $(this).text(); 
		
		url = "./api/?action=";
		url += (last == "room")? "getRoom":"getBedroom";
		url += "&id="+id;

		$.getJSON(url , function( data ) {
			appendIntoRightPanel({
				"id": id,
				"Category": last,
				"Zone": data[id]["zone"],
				"Price": data[id]["price"]
			});
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