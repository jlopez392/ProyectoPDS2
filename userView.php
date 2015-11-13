<?php
		session_start();
		if ($_SESSION['active'] != 1 || $_SESSION['type'] != "user")
    		header("Location:homePage.html");

?>

<html>
<head>
	
	<script type="text/javascript" src="js/jquery-2.1.4.js"></script>
	<script type="text/javascript" src="js/userViewEvents.js"></script>
	<link rel=StyleSheet href="css/template.css" type="text/css">
	<link rel=StyleSheet href="css/bootstrap.css" type="text/css">
  	<link rel=StyleSheet href="css/userViewStyles.css" type="text/css">
	
 
</head>

<body>

	<div id="header" class="page-header">
		<div id="headerLeftSide">
		<p><strong>Usuario: </strong><?=$_SESSION['username']?></p>
		<p><strong>Categoria: </strong><?=$_SESSION['type']?></p>
		</div>
		<div id="headerRightSide">
		<a id="exitButton" class="btn"><h4>Salir</h4></a>
		</div>
	</div>

	<div id = "leftContainer">
		<div id ="leftPanel">
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
				<div class="btn-group" role="group">
					<button id="lookForRoomsButton" type="button" class="btn btn-default">Buscar Salones</button>
				</div>
				<div class="btn-group" role="group">
					<button id="lookForBedroomsButton" type="button" class="btn btn-default">Buscar Habitaciones</button>
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
            <p><strong>Parametros de Busqueda</strong></p>
            <br><div class="input-group">
  				<span class="input-group-addon">Zona</span>
  				<input type="text" class="form-control">
  			</div> 
  			<br><div class="input-group">
  				<span class="input-group-addon">Precio Minimo</span>
  				<input type="text" class="form-control">
  			</div>
  			<br><div class="input-group">
  				<span class="input-group-addon">Precio Maximo</span>
  				<input type="text" class="form-control">
  			</div>
  			<br><div class="input-group">
  				<span class="input-group-addon">Nombre</span>
  				<input type="text" class="form-control">
  			</div>
		</div>
	</div>

	<div id="footer">
		<p>Proyecto para PDS2</p>
	</div>

</body>	


</html>
