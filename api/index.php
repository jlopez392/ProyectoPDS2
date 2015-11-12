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

/*
function validateUser(){

	if (isset($_GET["username"]) && isset($_GET["password"])){
		echo $_GET["username"];
		echo $_GET["password"];
	}	
}*/

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
	echo "<br><br><a href='./?action=getRooms'> getRooms IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=getBedrooms'> getBedrooms IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=getRoomsRequests'> getRoomsRequests IMPLEMENTADOOOOOO  </a>";
	echo "<br><br><a href='./?action=getBedroomsRequests'> getBedroomsRequests  IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=getConfirmedRequests'> getConfirmedRequests IMPLEMENTADOOOOOO  </a>";
	echo "<br><br><a href='./?action=getUsers'> getUsers IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=deleteRoom'> deleteRoom IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=deleteBedroom'> deleteBedroom IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=validateUser'> validateUser IMPLEMENTADOOOOOO </a>";

	echo "<br><br><a href='./?action=confirmRoomRequest'> confirmRoomRequest</a>";
	echo "<br><br><a href='./?action=confirmBedroomRequest'> confirmBedroomRequest</a>";
	echo "<br><br><a href='./?action=addRoom'> addRoom</a>";
	echo "<br><br><a href='./?action=addBedroom'> addBedroom</a>";
	echo "<br><br><a href='./?action=addRoomRequest'> addRoomRequest</a>";
	echo "<br><br><a href='./?action=addBedroomRequest'> addBedroomRequest</a>";
}