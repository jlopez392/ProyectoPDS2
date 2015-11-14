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

function printRoomRequest(){
	$.getJSON("./api/?action=getRoomsRequests&ownerId="+owner, function( data ) {
		$.each(data, function( index, value ) {
			advancePayment=(value["advancePayment"]!=0)?"Si":"No";
			$("#requestsTable tbody").append(
				"<tr> \
					<td><small>"+index+"</button></td> \
					<td><button class='selectButton btn'>"+value["idRoom"]+"</button></td> \
			  		<td><button class='showUserButton btn'>"+value["user"]+"</button></td> \
			  		<td><small>"+advancePayment+"</small></td> \
			  		<td><button id="+index+" class='confirmButton btn'>Confirmar</btn></td> \
		  		</tr>"
			);
			$(".selectButton").addClass(value["category"]);
		});
	});
}

function printBedroomRequest(){
	$.getJSON("./api/?action=getBedroomsRequests&ownerId="+owner, function( data ) {
		$.each(data, function( index, value ) {
			advancePayment=(value["advancePayment"]!=0)?"Si":"No";
			$("#requestsTable tbody").append(
				"<tr> \
					<td><small>"+index+"</button></td> \
					<td><button class='selectButton btn'>"+value["idBedroom"]+"</button></td> \
			  		<td><button class='showUserButton btn'>"+value["user"]+"</button></td> \
			  		<td><small>"+advancePayment+"</small></td> \
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

function printTableHead(){
	id = (last == "room")?"idSalon":"idHabitacion"; 
	$("#requestsTable thead").empty();
	$("#requestsTable thead").append(
		"	<td><strong><small>IdRequest</small></strong></td> \
			<td><strong><small>"+id+"</small></strong></td> \
			<td><strong><small>Usuario</small></strong></td> \
			<td><strong><small>Pago adelantado</small></strong></td> \
			<td><strong><small>Confirmar</small></strong></td> "
	);
	$("#requestsTable tbody").empty();
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
	generatedStringToAppend += "</ul";
	$("#rightPanel").append(generatedStringToAppend);
}

$(document).ready(function(){

	getCurrentUser();

	$("#buttonRequestManagement").attr("disabled", true);

	$("#buttonABM").click(function(){
		$(location).attr('href',"roomManagement.php");
	});

	$("#roomRequestButton").click(function(){
		last = "room";
		printTableHead();
		printRoomRequest();
	});

	$("#bedroomRequestButton").click(function(){
		last = "bedroom";
		printTableHead();
		printBedroomRequest();
	});


	$("#requestsTable").on("click",".selectButton", function(){
		id = $(this).text(); 
		category = $(this).hasClass("bedroom")? "bedroom": "room";
		
		url = "./api/?action=";
		url += (category == "room")? "getRoom":"getBedroom";
		url += "&id="+id;

		$.getJSON(url , function( data ) {
			appendIntoRightPanel({
				"id": id,
				"Category": category,
				"Zone": data[id]["zone"],
				"Price": data[id]["price"]
				});
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
			alert("Solicitud confirmada");
		});

		(last == "room")? $("#roomRequestButton").click() : $("#bedroomRequestButton").click();

	});

	$("#requestsTable").on("click",".showUserButton", function(){
		username = $(this).text() 
		url = "./api/?action=getUser&username="+username;
		
		$.getJSON(url, function(data) {
			appendIntoRightPanel({
				"Username": username,
				"Name": data[username]["name"],
				"Last name": data[username]["lastname"],
				"Phone Number": data[username]["numberPhone"]
				});	
		});

	});


	$("#requestsTable").on("click",".showRequestDetailsButton", function(){
		$("#rightPanel").empty();
		idRequest = $(this).text() 
		$.getJSON("./api/?action=getConfirmedRequests&ownerId="+owner, function(data) {
			requestFound = data.hasOwnProperty(idRequest);
			if (requestFound){
				advancePayment = (data[idRequest]["advancePayment"]!=0)?"Si":"No";
				$("#rightPanel").append(
			
"<ul class='list-group'> \
	<li class='list-group-item'><span class='input-group-addon'>id solicitud:</span> "+idRequest+"</li> \
	<li class='list-group-item'><span class='input-group-addon'>id salon o habitacion: </span>"+data[idRequest]["id"]+"</li> \
	<li class='list-group-item'><span class='input-group-addon'>Usuario: </span>"+data[idRequest]["user"]+"</li> \
	<li class='list-group-item'><span class='input-group-addon'>Pago adelantado: </span>"+advancePayment+"</li> \
</ul>" 
				);
			}
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
