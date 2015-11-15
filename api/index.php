<?php

include ("persistentDataManager.php");

$possible_url = [
	"getCurrentUser",
	"getRooms",
    "getBedrooms",
    "getRoom",
    "getBedroom",
    "getRoomsRequests",
    "getBedroomsRequests",
    "getConfirmedRequests",
    "validateUser",
    "validateOwner",
    "closeSession",
    "getUsers",
    "getUser",
    "deleteRoom",
    "deleteBedroom",
    "confirmRoomRequest",
    "confirmBedroomRequest",
    "addRoom",
	"addBedroom",
    "addRoomRequest",
	"addBedroomRequest",
	"existsRoomRequest",
	"existsBedroomRequest"
    ];

if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
	
	$_GET["action"]();
	
} else {
	echo "<br><br><a href='./?action=getCurrentUser'> getCurrentUser IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=getRooms'> getRooms IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=getBedrooms'> getBedrooms IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=getRoom'> getRoom IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=getBedroom'> getBedroom IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=getRoomsRequests'> getRoomsRequests IMPLEMENTADOOOOOO  </a>";
	echo "<br><br><a href='./?action=getBedroomsRequests'> getBedroomsRequests  IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=getConfirmedRequests'> getConfirmedRequests IMPLEMENTADOOOOOO  </a>";
	echo "<br><br><a href='./?action=getUsers'> getUsers IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=getUser'> getUser IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=deleteRoom'> deleteRoom IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=deleteBedroom'> deleteBedroom IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=validateUser'> validateUser IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=validateOwner'> validateOwner IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=closeSession'> closeSession IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=confirmRoomRequest'> confirmRoomRequest IMPLEMENTADOOOOOO </a>";
	echo "<br><br><a href='./?action=confirmBedroomRequest'> confirmBedroomRequest IMPLEMENTADOOOOOO </a>";
	

	echo "<br><br><a href='./?action=addRoom'> addRoom</a>";
	echo "<br><br><a href='./?action=addBedroom'> addBedroom</a>";
	echo "<br><br><a href='./?action=addRoomRequest'> addRoomRequest</a>";
	echo "<br><br><a href='./?action=addBedroomRequest'> addBedroomRequest</a>";
}