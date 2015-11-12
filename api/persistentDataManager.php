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

    while ($row_errs = mysql_fetch_assoc($result))
        $value[$row_errs['roomId']] = [
         	"zone" => $row_errs['zone'],
            "price" => $row_errs['price'],
            "ownerId" => $row_errs['ownerId']];
        
    echo json_encode($value);
        
}

function getBedrooms() {
    connectDatabase();        
    $query = sprintf("SELECT * FROM bedroom WHERE available = 1");
    $result = mysql_query($query);

    while ($row_errs = mysql_fetch_assoc($result))
        $value[$row_errs['bedroomId']] = [
         	"zone" => $row_errs['zone'],
            "price" => $row_errs['price'],
            "ownerId" => $row_errs['ownerId']];
        
    echo json_encode($value);
        
}

function getUsers() {
    connectDatabase();        
    $query = sprintf("SELECT username, name, lastname, numberPhone FROM user");
    $result = mysql_query($query);

    while ($row_errs = mysql_fetch_assoc($result))
        $value[$row_errs['username']] = [
    	   	"name" => $row_errs['name'],
        	"lastname" => $row_errs['lastname'],
            "numberPhone" => $row_errs['numberPhone']];
        
    echo json_encode($value);
        
}

function getRoomsRequests() {
    connectDatabase();        
    $query = sprintf("	SELECT roomRequestId, roomId, userId, advancePayment 
    					FROM roomRequest
    					wHERE isConfirmed = 0");
    $result = mysql_query($query);

    while ($row_errs = mysql_fetch_assoc($result))
        $value[$row_errs['roomRequestId']] = [
    	   	"idRoom" => $row_errs['roomId'],
        	"user" => $row_errs['userId'],
            "advancePayment" => $row_errs['advancePayment']];
        
    echo json_encode($value);
        
}

function getBedroomsRequests() {
    connectDatabase();        
    $query = sprintf("	SELECT bedroomRequestId, bedroomId, userId, advancePayment 
    					FROM bedroomRequest
    					wHERE isConfirmed = 0");
    $result = mysql_query($query);

    while ($row_errs = mysql_fetch_assoc($result))
        $value[$row_errs['bedroomRequestId']] = [
    	   	"idBedroom" => $row_errs['bedroomId'],
        	"user" => $row_errs['userId'],
            "advancePayment" => $row_errs['advancePayment']];
        
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

    while ($row_errs = mysql_fetch_assoc($result1))
        $value[$row_errs['bedroomRequestId']] = [
    	   	"id" => $row_errs['bedroomId'],
        	"user" => $row_errs['userId'],
            "advancePayment" => $row_errs['advancePayment']];
	
	while ($row_errs = mysql_fetch_assoc($result2))
        $value[$row_errs['roomRequestId']] = [
    	   	"id" => $row_errs['roomId'],
        	"user" => $row_errs['userId'],
            "advancePayment" => $row_errs['advancePayment']];
        
    echo json_encode($value);

        
}
