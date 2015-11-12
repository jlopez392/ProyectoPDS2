<?php

function connectDatabase() {
	$localhost = ['localhost', 'PDS2ProyectDB', 'root', 'a1b2c3jaflg'];
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
