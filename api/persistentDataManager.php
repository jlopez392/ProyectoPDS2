<?php

function connectDatabase() {
	$localhost = ['localhost', 'PDS2ProyectDB', 'root', 'abcd'];
   	$link = mysql_connect($localhost[0], $localhost[2], $localhost[3])
                or die('Coneccion fallida: ' . mysql_error());
	 		mysql_select_db($localhost[1])
                or die('No se pudo seleccionar la base de datos');
}

function getCurrentOwner(){
    session_start();
    echo $_SESSION['username'];
}

function getRooms() {
	connectDatabase();        
    $query = sprintf("SELECT * FROM room WHERE available = 1");
    $query .= (isset($_GET["ownerId"]))? " AND ownerId = '".$_GET["ownerId"]."'" : "";
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
    $query .= (isset($_GET["ownerId"]))? " AND ownerId = '".$_GET["ownerId"]."'" : "";
    

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
    /*$query = sprintf("	SELECT roomRequestId, roomId, userId, advancePayment 
    					FROM roomRequest
    					wHERE isConfirmed = 0");*/

    if (isset($_GET["ownerId"])){
        $ownerId = $_GET["ownerId"];
        $query = sprintf("  SELECT rq.roomRequestId, rq.roomId, rq.userId, rq.advancePayment 
                            FROM roomRequest rq, room r
                            wHERE rq.roomId = r.roomId
                                AND rq.isConfirmed = 0
                                AND r.ownerId = '$ownerId'");
    }


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
    /*$query = sprintf("	SELECT bedroomRequestId, bedroomId, userId, advancePayment 
    					FROM bedroomRequest
    					wHERE isConfirmed = 0");*/

    if (isset($_GET["ownerId"])){
        $ownerId = $_GET["ownerId"];
        $query = sprintf("  SELECT bq.bedroomRequestId, bq.bedroomId, bq.userId, bq.advancePayment 
                            FROM bedroomRequest bq, bedroom b
                            wHERE bq.bedroomId = b.bedroomId
                                AND bq.isConfirmed = 0
                                AND b.ownerId = '$ownerId'");
    }

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
    
    /*$query1 = sprintf("	SELECT bedroomRequestId, bedroomId, userId, advancePayment 
    					FROM bedroomRequest
    					wHERE isConfirmed = 1");

    $query2 = sprintf("	SELECT roomRequestId, roomId, userId, advancePayment 
    					FROM roomRequest
    					wHERE isConfirmed = 1");*/

    if (isset($_GET["ownerId"])){
        $ownerId = $_GET["ownerId"];
        
        $query2 = sprintf(" SELECT rq.roomRequestId, rq.roomId, rq.userId, rq.advancePayment 
                            FROM roomRequest rq, room r
                            wHERE rq.roomId = r.roomId
                                AND rq.isConfirmed = 1
                                AND r.ownerId = '$ownerId'");

        $query1 = sprintf(" SELECT bq.bedroomRequestId, bq.bedroomId, bq.userId, bq.advancePayment 
                            FROM bedroomRequest bq, bedroom b
                            wHERE bq.bedroomId = b.bedroomId
                                AND bq.isConfirmed = 1
                                AND b.ownerId = '$ownerId'");
    }


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

    echo ($row = mysql_fetch_assoc($result))? 1: exit(0);

    session_start();
    $_SESSION['active'] = 1;
    $_SESSION['type'] = "user";
    $_SESSION['username'] = $username;
}

function validateOwner(){

    if ( !(isset($_GET["username"]) && isset($_GET["password"])) )
        exit("Son necesarios username y password");

    $username = $_GET["username"];
    $password = $_GET["password"];

    connectDatabase();        
    $query = sprintf("  SELECT username, password 
                        FROM owner 
                        wHERE username = '$username' AND password = $password");

    $result = mysql_query($query);

    echo ($row = mysql_fetch_assoc($result))? 1: exit(0);

    session_start();
    $_SESSION['active'] = 1;
    $_SESSION['type'] = "owner";
    $_SESSION['username'] = $username;

}


function closeSession(){
    session_start();
    $_SESSION['active'] = 0;
}


//Falta eliminar demás solicitudes sobre la misma habitacion
function confirmRoomRequest(){
	isset($_GET["idToConfirm"])? $id = $_GET["idToConfirm"]: exit("Parameter is missing");

	connectDatabase();        
    $query = sprintf("  UPDATE roomRequest rr, room r 
                        SET rr.isConfirmed = 1 , r.available = 0 
                        WHERE rr.roomRequestId = '$id' 
                            AND rr.roomId = r.roomId 
                            AND r.available = 1");
    $result = mysql_query($query);
    echo ($row = mysql_fetch_assoc($result))? 1: 0;
}

function confirmBedroomRequest(){
	isset($_GET["idToConfirm"])? $id = $_GET["idToConfirm"]: exit("Parameter is missing");

	connectDatabase();        
    $query = sprintf("  UPDATE bedroomRequest br, bedroom b 
                        SET br.isConfirmed = 1 , b.available = 0 
                        WHERE br.bedroomRequestId = '$id' 
                            AND br.bedroomId = b.bedroomId 
                            AND b.available = 1");

    $result = mysql_query($query);
    echo ($row = mysql_fetch_assoc($result))? 1: 0;
}
