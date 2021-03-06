<?php
		session_start();
		if ($_SESSION['active'] != 1 || $_SESSION['type'] != "owner")
    		header("Location:../");

?>

<html>
<head>
	
	<script type="text/javascript" src="js/jquery-2.1.4.js"></script>
	<script type="text/javascript" src="js/roomManagementEvents.js"></script>
	<link rel=StyleSheet href="css/template.css" type="text/css">
	<link rel=StyleSheet href="css/roomManagementStyles.css" type="text/css">
	<link rel=StyleSheet href="css/bootstrap.css" type="text/css">
   
</head>

<body>
	
	<div id="header" class="page-header">
		<div id="headerLeftSide">
		<p><strong>Usuario: </strong><?=$_SESSION['username']?></p>
		<p><strong>Categoria: </strong><?=$_SESSION['type']?></p>
		</div>
		<div id="headerRightSide">
		<a id="exitButton" href="" class="btn"><h4>Salir</h4></a>
		</div>
	</div>

	<div id "navigationBar" class="btn-group btn-group-justified" role="group" aria-label="...">
  		<div class="btn-group" role="group">
   			<button id="buttonABM" type="button" class="btn btn-default">Alta/Baja/Modificacion</button>
		</div>
		<div class="btn-group" role="group">
  			<button id="buttonRequestManagement" type="button" class="btn btn-default">Administrar Solicitudes</button>
		</div>
	</div>

	<div id = "leftContainer">

		<div id ="leftPanel">
		
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
				<div class="btn-group" role="group">
					<button id="roomButton" type="button" class="btn btn-default">Salones a disposicion</button>
				</div>
				<div class="btn-group" role="group">
					<button id="bedroomButton" type="button" class="btn btn-default">Habitaciones a disposicion</button>
				</div>
				<div class="btn-group" role="group">
					<button id="addButton" type="button" class="btn btn-default">Agregar nueva</button>
				</div>
			</div>

			<div class="panel panel-default">
			  	<table id = "roomsTable"class="table">
			  		<thead id = "roomsTableHead">
			  		</thead>
			  		<tbody>
			  		</tbody>
			  	</table>
			</div>

		</div>
	
	</div>

	<div id="rightContainer">
		<div id = "rightPanel">
		</div>
	</div>

	<div id="footer">
		<p>Proyecto para PDS2</p>
	</div>

</body>	


</html>
