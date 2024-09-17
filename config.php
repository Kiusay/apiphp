<?php
// Sirve para configurar la base de datos
$host = 'localhost';
$db_name = 'senadb'; // Sirve para definir el nombre de la base de datos
$username = 'root';
$password = '';

// Sirve para crear la conexión
$conn = new mysqli($host, $username, $password, $db_name);

// Sirve para verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
