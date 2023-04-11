<?php
/////// CONEXIÓN A LA BASE DE DATOS /////////
$host = 'localhost:33065';
$basededatos = 'busqueda_ajax';
$usuario = 'root';
$contraseña = '';

$conexion = new mysqli($host, $usuario, $contraseña, $basededatos);
if ($conexion->connect_errno) {
	die("Fallo la conexion:(" . $conexion->mysqli_connect_errno() . ")" . $conexion->mysqli_connect_error());
}

//////////////// VALORES INICIALES ///////////////////////

$tabla = "";
$query = "SELECT * FROM alumnos ORDER BY id_alumno";

///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
if (isset($_POST['alumnos'])) {
	$q = $conexion->real_escape_string($_POST['alumnos']);
	$query = "SELECT * FROM alumnos WHERE 
		id_alumno LIKE '%" . $q . "%' OR
		nombre LIKE '%" . $q . "%' OR
		carrera LIKE '%" . $q . "%' OR
		grupo LIKE '%" . $q . "%' OR
		fecha_ingreso LIKE '%" . $q . "%'";
}

$buscarAlumnos = $conexion->query($query);
if ($buscarAlumnos->num_rows > 0) {
	$tabla .=
		'<table class="table">
		<tr class="bg-info">
			<td>ID ALUMNO</td>
			<td>NOMBRE</td>
			<td>CARRERA</td>
			<td>GRUPO</td>
			<td>FECHA INGRESO</td>
		</tr>';

	while ($filaAlumnos = $buscarAlumnos->fetch_assoc()) {
		$tabla .=
			'<tr>
			<td>' . $filaAlumnos['id_alumno'] . '</td>
			<td>' . $filaAlumnos['nombre'] . '</td>
			<td>' . $filaAlumnos['carrera'] . '</td>
			<td>' . $filaAlumnos['grupo'] . '</td>
			<td>' . $filaAlumnos['fecha_ingreso'] . '</td>
		 </tr>
		';
	}

	$tabla .= '</table>';
} else {
	$tabla = "No se encontraron coincidencias con sus criterios de búsqueda.";
}


echo $tabla;
