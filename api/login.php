<?php
// Sirve para mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../config.php');

// Sirve para verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sirve para verificar si se están recibiendo los datos
    var_dump($_POST); // Sirve para mostrar los datos recibidos por el script

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        // Sirve para verificar la conexión a la base de datos
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        } else {
            echo "Conexión exitosa\n"; // Sirve para mostrar mensaje si la conexión es exitosa
        }

        // Sirve para preparar la consulta SQL
        $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        // Sirve para verificar si se encontró el usuario
        if ($stmt->num_rows > 0) {
            echo "Usuario encontrado\n"; // Sirve para indicar que el usuario fue encontrado
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Sirve para verificar si la contraseña es correcta
            echo "Verificando contraseña...\n";
            if (password_verify($password, $hashed_password)) {
                echo "Contraseña verificada\n";
                echo json_encode(array('status' => 'success', 'message' => 'Autenticación satisfactoria.'));
            } else {
                echo "Contraseña incorrecta\n";
                echo json_encode(array('status' => 'error', 'message' => 'Error en la autenticación.'));
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Usuario no encontrado.'));
        }

        $stmt->close();
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Faltan datos.'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Método no soportado.'));
}
?>
