<!DOCTYPE html>
<html>
<head>
	<title>Formulario de registro de doctores</title>
	<style>
		 
		 body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
      }
      
      h1 {
        color: #333333;
        text-align: center;
      }
      
      ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
      }
      
      li {
        margin: 10px;
      }
      
      a {
        display: block;
        padding: 10px;
        background-color: #3366cc;
        color: #ffffff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease-in-out;
      }
      
      a:hover {
        background-color: #003366;
      }

		 
		form {
			margin: 20px;
			padding: 20px;
			background-color: #f0f0f0;
			border-radius: 10px;
			box-shadow: 0px 0px 10px #888888;
			width: 400px;
		}
		label {
			display: block;
			margin-bottom: 5px;
		}
		input[type=text] {
			width: 100%;
			padding: 5px;
			margin-bottom: 10px;
			border: 1px solid #ccc;
			border-radius: 3px;
			box-sizing: border-box;
		}
		input[type=submit] {
			background-color: #4CAF50;
			color: white;
			padding: 10px;
			border: none;
			border-radius: 3px;
			cursor: pointer;
			font-size: 16px;
		}
		input[type=submit]:hover {
			background-color: #3e8e41;
		}
	</style>
</head>
<body>
	<h1>Formulario de registro de doctores</h1>
	
	<center><form method="post" >
		<label>Cedula de identidad:</label>
		<input type="text" name="cedula" required>
		<label>Nombre:</label>
		<input type="text" name="nombre" required>
		<label>Apellido:</label>
		<input type="text" name="apellido" required>
		<label>Especialidad:</label>
		<input type="text" name="especialidad" required>
		<label>Direccion:</label>
		<input type="text" name="direccion" required>
		<input type="submit" value="Registrar">
	</form>
</center>
<ul>
<li><a href="menu.html">volver al menu principal</a></li>
</ul>
<?php  
// Parámetros de la conexión a la base de datos
$host = "localhost";
$dbname = "doctor";
$username = "root";
$password = "";

// Crear una conexión a la base de datos utilizando PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Establecer el modo de error de PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error en la conexión a la base de datos: " . $e->getMessage();
}

// Procesar el formulario
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// Obtener los valores del formulario
	$cedula = $_POST["cedula"];
	$nombre = $_POST["nombre"];
	$apellido = $_POST["apellido"];
	$especialidad = $_POST["especialidad"];
	$direccion = $_POST["direccion"];

	// Ejecutar una consulta SQL para insertar los valores en la tabla "doc"
	try {
	    // Preparar una consulta SQL con marcadores de posición
	    $stmt = $conn->prepare("INSERT INTO doc (cedula, nombre, apellido, especialidad, direccion) VALUES (:cedula, :nombre, :apellido, :especialidad, :direccion)");
	    // Vincular los valores de las variables a los marcadores de posición
	    $stmt->bindParam(':cedula', $cedula);
	    $stmt->bindParam(':nombre', $nombre);
	    $stmt->bindParam(':apellido', $apellido);
	    $stmt->bindParam(':especialidad', $especialidad);
	    $stmt->bindParam(':direccion', $direccion);
	    // Ejecutar la consulta
	    $stmt->execute();
	    echo "Registro insertado correctamente";
	} catch(PDOException $e){
	    echo "Error al insertar el registro: " . $e->getMessage();
	}
}

// Cerrar la conexión a la base de datos
$conn = null;
?>
</body>
</html>