<?php

include ("persistentDataManager.php");

$possible_url = [
	"getRooms",
    "getBedrooms",
    "getRoomsRequests",
    "getBedroomsRequests",
    "getConfirmedRequests",
    "validateUser",
    "getUsers",
    "deleteRoom",
    "deleteBedroom",
    "confirmRoomRequest",
    "confirmBedroomRequest",
    "addRoom",
	"addBedroom",
    "addRoomRequest",
	"addBedroomRequest"
    ];

function getRoomsRequests(){
    echo '{
	"roomRequest1":{
		"idRoom":"room1",
		"user": "user1",
		"advancePayment": "100"
	},
	"roomRequest2":{
		"idRoom":"room2",
		"user": "user2",
		"advancePayment": "100"
	},
	"roomRequest3":{
		"idRoom":"room3",
		"user": "user3",
		"advancePayment": "100"
	},
	"roomRequest4":{
		"idRoom":"room4",
		"user": "user4",
		"advancePayment": "100"
	},
	"roomRequest5":{
		"idRoom":"room5",
		"user": "user5",
		"advancePayment": "100"
	}
}';
}

function getBedroomsRequests(){
    echo '{
	"bedroomRequest1":{
		"idBedroom":"bedroom1",
		"user": "user1",
		"advancePayment": "100"
	},
	"bedroomRequest2":{
		"idBedroom":"bedroom2",
		"user": "user2",
		"advancePayment": "100"
	},
	"bedroomRequest3":{
		"idBedroom":"bedroom3",
		"user": "user3",
		"advancePayment": "100"
	},
	"bedroomRequest4":{
		"idBedroom":"bedroom4",
		"user": "user4",
		"advancePayment": "100"
	},
	"bedroomRequest5":{
		"idBedroom":"bedroom5",
		"user": "user5",
		"advancePayment": "100"
	}
}';
}

function getConfirmedRequests(){
	echo '{
	"bedroomRequest11":{
		"id":"bedroom1",
		"user": "user1",
		"advancePayment": "100"
	},
	"bedroomRequest22":{
		"id":"bedroom2",
		"user": "user2",
		"advancePayment": "100"
	},
	"roomRequest33":{
		"id":"bedroom3",
		"user": "user3",
		"advancePayment": "100"
	},
	"roomRequest45":{
		"id":"bedroom4",
		"user": "user4",
		"advancePayment": "100"
	},
	"bedroomRequest75":{
		"id":"bedroom5",
		"user": "user5",
		"advancePayment": "100"
	}
}';
}

function validateUser(){

	if (isset($_GET["username"]) && isset($_GET["password"])){
		echo $_GET["username"];
		echo $_GET["password"];
	}	
}

function deleteRoom(){
	if (isset($_GET["idToDelete"])){
   		echo "Se ha borrado con exito ";
   		echo $_GET["idToDelete"];
   		
	}
}

function deleteBedroom(){
	if (isset($_GET["idToDelete"])){
		echo "Se ha borrado con exito ";
   		echo $_GET["idToDelete"];
	}
}

function confirmRoomRequest(){
	if (isset($_GET["idToConfirm"])){
		echo "Se ha confirmado la solicitud de reserva de el salon ";
    	echo $_GET["idToConfirm"];
	}
}

function confirmBedroomRequest(){
	if (isset($_GET["idToConfirm"])){
		echo "Se ha confirmado la solicitud de reserva de la habitacion ";
		echo $_GET["idToConfirm"];
	}
}

function addRoom() {
	if (isset($_GET["zone"]) and isset($_GET["price"])){
		echo "Se ha cargado el salon.\n";
		echo "Zona: ".$_GET['zone']."\n";
		echo "Precio: ".$_GET["price"]."\n";
	}
}

function addBedroom() {
	if (isset($_GET["zone"]) and isset($_GET["price"])){
		echo "Se ha cargado la habitacion\n";
		echo "Zona: ".$_GET['zone']."\n";
		echo "Precio: ".$_GET["price"]."\n";
	}
}

function addRoomRequest() {
	if (isset($_GET["idToRequest"])){
		echo "Se ha asentado la solicitud del salon ";
		echo $_GET["idToRequest"];
	}
}

function addBedroomRequest() {
	if (isset($_GET["idToRequest"])){
		echo "Se ha asentado la solicitud de la habitacion ";
		echo $_GET["idToRequest"];
	}
}

if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url)) {

    $_GET["action"]();

} else {
	echo "<br><br><a href='./?action=getRooms'> getRooms </a>";
	echo "<br><br><a href='./?action=getBedrooms'> getBedrooms </a>";
	echo "<br><br><a href='./?action=getRoomsRequests'> getRoomsRequests </a>";
	echo "<br><br><a href='./?action=getBedroomsRequests'> getBedroomsRequests </a>";
	echo "<br><br><a href='./?action=getConfirmedRequests'> getConfirmedRequests </a>";
	echo "<br><br><a href='./?action=validateUser'> validateUser</a>";
	echo "<br><br><a href='./?action=getUsers'> getUsers </a>";
	echo "<br><br><a href='./?action=deleteRoom'> deleteRoom</a>";
	echo "<br><br><a href='./?action=deleteBedroom'> deleteBedroom</a>";
	echo "<br><br><a href='./?action=confirmRoomRequest'> confirmRoomRequest</a>";
	echo "<br><br><a href='./?action=confirmBedroomRequest'> confirmBedroomRequest</a>";
	echo "<br><br><a href='./?action=addRoom'> addRoom</a>";
	echo "<br><br><a href='./?action=addBedroom'> addBedroom</a>";
	echo "<br><br><a href='./?action=addRoomRequest'> addRoomRequest</a>";
	echo "<br><br><a href='./?action=addBedroomRequest'> addBedroomRequest</a>";
}