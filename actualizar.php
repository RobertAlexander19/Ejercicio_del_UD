<!DOCTYPE html>
<html>
<head>
  <style>
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
        background-color: #003366;}
    table {
      border-collapse:collapse;
    }
    th, td {
      border: 1px solid black;
      padding: 5px;
    }
    th {
      background-color: #ccc;
    }
    form {
      display: inline-block;
    }
    label {
      display: block;
      font-weight: bold;
      margin-top: 10px;
    }
    input[type=text] {
      width: 100%;
      padding: 5px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    input[type=submit] {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    input[type=submit]:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <ul>
<li><a href="menu.html">volver al menu principal</a></li>
</ul>
</body>
</html>
<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doctor";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos de la tabla "doc"
$sql = "SELECT * FROM doc";
$result = $conn->query($sql);

// Crear la tabla y los botones de actualizar
if ($result->num_rows > 0) {
  echo "<table>";
  echo "<tr><th>Cédula</th><th>Nombre</th><th>Apellido</th><th>Dirección</th><th>Especialidad</th><th>Actualizar</th></tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row["cedula"]."</td>";
    echo "<td>".$row["nombre"]."</td>";
    echo "<td>".$row["apellido"]."</td>";
    echo "<td>".$row["direccion"]."</td>";
    echo "<td>".$row["especialidad"]."</td>";
    echo "<td><form action='' method='post'>
              <input type='hidden' name='cedula' value='".$row["cedula"]."'>
              <input type='submit' name='update' value='Actualizar'>
          </form></td>";
    echo "</tr>";
  }
  echo "</table>";
} else {
  echo "No se encontraron registros.";
}

// Cerrar la conexión a la base de datos
$conn->close();

// Si se ha pulsado el botón de actualizar, mostrar el formulario
if(isset($_POST['update'])){
  $cedula = $_POST['cedula'];
  $conn = new mysqli($servername, $username, $password, $dbname);
  $sql = "SELECT * FROM doc WHERE cedula='$cedula'";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h2>Actualizar registro</h2>";
    echo "<form action='' method='post'>";
    echo "<label>Cédula:</label><br>";
    echo "<input type='text' name='cedula' value='".$row["cedula"]."'><br>";
    echo "<label>Nombre:</label><br>";
    echo "<input type='text' name='nombre' value='".$row["nombre"]."'><br>";
    echo "<label>Apellido:</label><br>";
    echo "<input type='text' name='apellido' value='".$row["apellido"]."'><br>";
    echo "<label>Dirección:</label><br>";
    echo "<input type='text' name='direccion' value='".$row["direccion"]."'><br>";
    echo "<label>Especialidad:</label><br>";
    echo "<input type='text' name='especialidad' value='".$row["especialidad"]."'><br>";
    echo "<input type='submit' name='submit' value='Actualizar'>";
    echo "</form>";
  }
  $conn->close();
}

// Si se ha enviado el formulario de actualización, actualizar los datos en la base de datos
if(isset($_POST['submit'])){
  $cedula = $_POST['cedula'];
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $direccion = $_POST['direccion'];
  $especialidad = $_POST['especialidad'];
  $conn = new mysqli($servername, $username, $password, $dbname);
  $sql = "UPDATE doc SET nombre='$nombre', apellido='$apellido', direccion='$direccion', especialidad='$especialidad',cedula='$cedula'";
  if ($conn->query($sql) === TRUE) {
    echo "Registro actualizado correctamente.Actualiza la pagina si no se han cambiado los valores";
  } else {
    echo "Error al actualizar el registro: " . $conn->error;
  }
  $conn->close();
}
?>