<?php

/*Funcion que realiza la conexión a la base de datos.*/
function connectDatabase() {
	$localhost = ['localhost', 'PDS2ProyectDB', 'root', 'abcd'];
   	$link = mysql_connect($localhost[0], $localhost[2], $localhost[3])
                or die('Coneccion fallida: ' . mysql_error());
	 		mysql_select_db($localhost[1])
                or die('No se pudo seleccionar la base de datos');
}

/*Funcion que devuelve el id del usuario actual*/
function getCurrentUser(){
    session_start();
    echo $_SESSION['username'];
}

/*Funcion que devuelve un json con todas los salones disponibles.
    Funciona de dos maneras.
    Si no se le pasa parametros devuelve todas los salones disponibles.
    Si se le pasa el id del owner, se devuelve todas los salones disponibles
    correspondientes a ese owner.
*/
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

/*Funcion que devuelve un json con todas las habitaciones disponibles.
    Funciona de dos maneras.
    Si no se le pasa parametros devuelve todas las habitaciones disponibles.
    Si se le pasa el id del owner, se devuelve todas las habitaciones disponibles
    correspondientes a ese owner.
*/
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

/*Funcion que devuelve un json con unicamente el salon correspondiente al id pasado por parametro*/
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

/*Funcion que devuelve un json con unicamente la habitacion correspondiente al id pasado por parametro*/
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

/*Funcion que devuelve un json con la lista de todos los usuarios de la base de datos.SOLO DATOS PUBLICOS*/
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

/*Funcion que devuelve un json con el usuario solicitado de la base de datos.SOLO DATOS PUBLICOS*/
function getUser() {
    $username = (isset($_GET["username"]))? $_GET["username"] : exit();
    connectDatabase();        
    $query = sprintf("SELECT username, name, lastname, numberPhone FROM user WHERE username='$username'");
    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result))
        $value[$row['username']] = [
            "name" => $row['name'],
            "lastname" => $row['lastname'],
            "numberPhone" => $row['numberPhone']];
        
    echo json_encode($value);
        
}

/*Funcion que devuelve todas las solicitudes de reserva de salones en un json. Se le debe pasar por parametro
el id del owner, para realizar el filtro.*/
function getRoomsRequests() {
    connectDatabase();        

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

/*Funcion que devuelve todas las solicitudes de reserva de habitaciones en un json. Se le debe pasar por parametro
el id del owner, para realizar el filtro.*/
function getBedroomsRequests() {
    connectDatabase();        

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


/*Funcion que devuelve todas las solicitudes de reserva confirmadas. Se le debe pasar por parametro
el id del owner, para realizar el filtro.*/
function getConfirmedRequests() {
    connectDatabase();        
    

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


/*Funcion de borra un salon. Necesita que se le pase el id del objeto a borrar*/
function deleteRoom(){
	isset($_GET["idToDelete"])? $id = $_GET["idToDelete"]: exit(); 
	
	connectDatabase();        
    $query = sprintf("DELETE FROM room WHERE roomId = $id");
    $result = mysql_query($query);
    
    echo "Se ha borrado con exito el elemento";
}


/*Funcion que borra una habitacion. Necesita que se le pase el id del objeto a borrar*/
function deleteBedroom(){
	isset($_GET["idToDelete"])? $id = $_GET["idToDelete"]: exit("Parameter is missing"); 
	
	connectDatabase();        
    $query = sprintf("DELETE FROM bedroom WHERE bedroomId = $id");
    mysql_query($query);
    
    echo "Se ha borrado con exito el elemento";
}


/*Funcion que recibe usuario y clave, y los compara en la base de datos para ver si son validos.*/
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

/*Funcion que recibe usuario y clave de un owner, y los compara en la base de datos para ver si son validos.*/
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

/*Funcion que cierra la sesion*/
function closeSession(){
    session_start();
    $_SESSION['active'] = 0;
}


//Falta eliminar demás solicitudes sobre la misma habitacion

/*Funcion que confirma solicitudes de salon*/
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

/*Funcion que confirma solicitudes de habitacion*/
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

function addRoom() {
    if ( !isset($_GET["zone"]) || !isset($_GET["price"]) || !isset($_GET["ownerId"]) )
        exit(0);
        
    $zone = $_GET['zone'];
    $price = $_GET["price"];
    $ownerId = $_GET["ownerId"];

    connectDatabase();        
    $query = sprintf("  INSERT INTO room (`roomId`, `zone`, `price`, `ownerId`, `available`) 
                        VALUES (NULL, '$zone', '$price', '$ownerId', '1')");

    mysql_query($query);
}

function addBedroom() {
    if ( !isset($_GET["zone"]) || !isset($_GET["price"]) || !isset($_GET["ownerId"]) )
        exit(0);
        
    $zone = $_GET['zone'];
    $price = $_GET["price"];
    $ownerId = $_GET["ownerId"];

    connectDatabase();        
    $query = sprintf("  INSERT INTO bedroom (`bedroomId`, `zone`, `price`, `ownerId`, `available`) 
                        VALUES (NULL, '$zone', '$price', '$ownerId', '1')");

    mysql_query($query);
}


function addRoomRequest() {
    if ( !isset($_GET["idToRequest"]) || !isset($_GET["userId"]) )
        exit(0);
    
    $roomId = $_GET["idToRequest"];
    $userId = $_GET["userId"];

    if ( isset($_GET["advancePayment"]) )
        echo "\nPago adelantado: ".$_GET["advancePayment"];


    connectDatabase();        
    $query = sprintf(
        "   INSERT INTO roomRequest (`roomRequestId`, `roomId`, `userId`, `advancePayment`, `isConfirmed`) 
            VALUES (NULL, '$roomId', '$userId', '0', '0');");

    mysql_query($query);

}

function addBedroomRequest() {
    if ( !isset($_GET["idToRequest"]) || !isset($_GET["userId"]) )
        exit(0);
    
    $bedroomId = $_GET["idToRequest"];
    $userId = $_GET["userId"];

    if ( isset($_GET["advancePayment"]) )
        echo "\nPago adelantado: ".$_GET["advancePayment"];


    connectDatabase();        
    $query = sprintf(
        "   INSERT INTO bedroomRequest (`bedroomRequestId`, `bedroomId`, `userId`, `advancePayment`, `isConfirmed`) 
            VALUES (NULL, '$bedroomId', '$userId', '0', '0');");

    mysql_query($query);

}

function existsRoomRequest(){
    if ( !isset($_GET["roomId"]) || !isset($_GET["userId"]) )
        exit(0);

    $roomId = $_GET["roomId"];
    $userId = $_GET["userId"];


    connectDatabase();        
    $query = "  SELECT *
                FROM roomRequest
                WHERE roomId = $roomId AND userId = '$userId'";

    $result = mysql_query($query);

    echo ($row = mysql_fetch_assoc($result))? 1: 0;
}

function existsBedroomRequest(){
    if ( !isset($_GET["bedroomId"]) || !isset($_GET["userId"]) )
        exit(0);

    $bedroomId = $_GET["bedroomId"];
    $userId = $_GET["userId"];


    connectDatabase();        
    $query = "  SELECT *
                FROM bedroomRequest
                WHERE bedroomId = $bedroomId AND userId = '$userId'";

    $result = mysql_query($query);

    echo ($row = mysql_fetch_assoc($result))? 1: 0;
}
