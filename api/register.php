<?php
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
    $username = trim($_POST['username']);

    // Sirve para validar que el nombre de usuario no tenga espacios y no exceda los 10 caracteres
    if (strlen($username) > 10 || strpos($username, ' ') !== false) {
        echo json_encode(array('status' => 'error', 'message' => 'Nombre de usuario inválido.'));
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (email, password, username) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $email, $password, $username);

    if ($stmt->execute()) {
        echo json_encode(array('status' => 'success', 'message' => 'Registro exitoso.'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error en el registro.'));
    }

    $stmt->close();
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Método no soportado.'));
}
?>
