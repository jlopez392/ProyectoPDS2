<?php

function connectDatabase() {
	$localhost = ['localhost', 'PDS2ProyectDB', 'root', 'abcd'];
   	$link = mysql_connect($localhost[0], $localhost[2], $localhost[3])
                or die('Coneccion fallida: ' . mysql_error());
	 		mysql_select_db($localhost[1])
                or die('No se pudo seleccionar la base de datos');
}

function getRooms() {
	connectDatabase();        
    $query = sprintf("SELECT * FROM room WHERE available = 1");
    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result))
        $value[$row['roomId']] = [
         	"zone" => $row['zone'],
            "price" => $row['price'],
            "ownerId" => $row['ownerId']];
        
    echo json_encode($value);
        
}

function getBedrooms() {
    connectDatabase();        
    $query = sprintf("SELECT * FROM bedroom WHERE available = 1");
    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result))
        $value[$row['bedroomId']] = [
         	"zone" => $row['zone'],
            "price" => $row['price'],
            "ownerId" => $row['ownerId']];
        
    echo json_encode($value);
        
}

function getRoom() {
	$id = (isset($_GET["id"]))? $_GET["id"] : exit();
    connectDatabase();        
    $query = sprintf("SELECT * FROM room WHERE roomId = '$id'");
    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result))
        $value[$row['roomId']] = [
         	"zone" => $row['zone'],
            "price" => $row['price'],
            "ownerId" => $row['ownerId']];
        
    echo json_encode($value);
        
}

function getBedroom() {
	$id = (isset($_GET["id"]))? $_GET["id"] : exit();
    connectDatabase();        
    $query = sprintf("SELECT * FROM bedroom WHERE bedroomId = '$id'");
    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result))
        $value[$row['bedroomId']] = [
         	"zone" => $row['zone'],
            "price" => $row['price'],
            "ownerId" => $row['ownerId']];
        
    echo json_encode($value);
        
}


function getUsers() {
    connectDatabase();        
    $query = sprintf("SELECT username, name, lastname, numberPhone FROM user");
    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result))
        $value[$row['username']] = [
    	   	"name" => $row['name'],
        	"lastname" => $row['lastname'],
            "numberPhone" => $row['numberPhone']];
        
    echo json_encode($value);
        
}

function getRoomsRequests() {
    connectDatabase();        
    $query = sprintf("	SELECT roomRequestId, roomId, userId, advancePayment 
    					FROM roomRequest
    					wHERE isConfirmed = 0");
    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result))
        $value[$row['roomRequestId']] = [
    	   	"idRoom" => $row['roomId'],
        	"user" => $row['userId'],
            "advancePayment" => $row['advancePayment'],
            "category" => "room"];
        
    echo json_encode($value);
        
}

function getBedroomsRequests() {
    connectDatabase();        
    $query = sprintf("	SELECT bedroomRequestId, bedroomId, userId, advancePayment 
    					FROM bedroomRequest
    					wHERE isConfirmed = 0");
    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result))
        $value[$row['bedroomRequestId']] = [
    	   	"idBedroom" => $row['bedroomId'],
        	"user" => $row['userId'],
            "advancePayment" => $row['advancePayment'],
            "category" => "bedroom"];
        
    echo json_encode($value);
        
}

function getConfirmedRequests() {
    connectDatabase();        
    
    $query1 = sprintf("	SELECT bedroomRequestId, bedroomId, userId, advancePayment 
    					FROM bedroomRequest
    					wHERE isConfirmed = 1");

    $query2 = sprintf("	SELECT roomRequestId, roomId, userId, advancePayment 
    					FROM roomRequest
    					wHERE isConfirmed = 1");

    $result1 = mysql_query($query1);
    $result2 = mysql_query($query2);

    while ($row = mysql_fetch_assoc($result1))
        $value[$row['bedroomRequestId']] = [
    	   	"id" => $row['bedroomId'],
        	"user" => $row['userId'],
            "advancePayment" => $row['advancePayment'],
            "category" => "bedroom"];
	
	while ($row = mysql_fetch_assoc($result2))
        $value[$row['roomRequestId']] = [
    	   	"id" => $row['roomId'],
        	"user" => $row['userId'],
            "advancePayment" => $row['advancePayment'],
            "category" => "room"];
        
    echo json_encode($value);
        
}

function deleteRoom(){
	isset($_GET["idToDelete"])? $id = $_GET["idToDelete"]: exit(); 
	
	connectDatabase();        
    $query = sprintf("DELETE FROM room WHERE roomId = $id");
    $result = mysql_query($query);
    
    echo "Se ha borrado con exito el elemento";
}

function deleteBedroom(){
	isset($_GET["idToDelete"])? $id = $_GET["idToDelete"]: exit("Parameter is missing"); 
	
	connectDatabase();        
    $query = sprintf("DELETE FROM bedroom WHERE bedroomId = $id");
    mysql_query($query);
    
    echo "Se ha borrado con exito el elemento";
}

function validateUser(){

	if ( !(isset($_GET["username"]) && isset($_GET["password"])) )
		exit("Son necesarios username y password");

	$username = $_GET["username"];
	$password = $_GET["password"];

	connectDatabase();        
    $query = sprintf("	SELECT username, password 
    					FROM user 
    					wHERE username = '$username' AND password = $password");

    $result = mysql_query($query);

    echo ($row = mysql_fetch_assoc($result))? 1: 0;

}


//Falta eliminar demás solicitudes sobre la misma habitacion
function confirmRoomRequest(){
	isset($_GET["idToConfirm"])? $id = $_GET["idToConfirm"]: exit("Parameter is missing");

	connectDatabase();        
    $query = sprintf("UPDATE roomRequest SET isConfirmed = 1 WHERE roomRequestId ='$id'");
    mysql_query($query);
    $query = sprintf("	UPDATE room 
						SET available = 0 
						WHERE roomId in (
							SELECT roomId 
							FROM roomRequest 
							WHERE roomRequestId = $id
						)");

    mysql_query($query);

    echo "Se ha confirmado la solicitud de reserva del salon";

}

function confirmBedroomRequest(){
	isset($_GET["idToConfirm"])? $id = $_GET["idToConfirm"]: exit("Parameter is missing");

	connectDatabase();        
    $query = sprintf("UPDATE bedroomRequest SET isConfirmed = 1 WHERE bedroomRequestId ='$id'");
    mysql_query($query);
    $query = sprintf("	UPDATE bedroom 
						SET available = 0 
						WHERE bedroomId in (
							SELECT bedroomId 
							FROM bedroomRequest 
							WHERE bedroomRequestId = $id
						)");

    mysql_query($query);

    echo "Se ha confirmado la solicitud de reserva de la habitacion";

}

/*
//UPDATE `PDS2ProyectDB`.`bedroom` SET `available` = '0' WHERE `bedroom`.`bedroomId` =1;
//UPDATE `PDS2ProyectDB`.`roomRequest` SET `isConfirmed` = '1' WHERE `roomRequest`.`roomRequestId` =99;
function confirmBedroomRequest(){
	if (isset($_GET["idToConfirm"])){
		echo "Se ha confirmado la solicitud de reserva de la habitacion ";
		echo $_GET["idToConfirm"];
	}
}*/