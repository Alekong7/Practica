<?php
// filepath: c:\xampp\htdocs\Plantilla\dist\pages\guardar_usuario.php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['usuario'], $data['email'])) {
    $mysqli = new mysqli('localhost', 'root', '', 'login'); // Cambia 'midb' por tu base de datos
    if ($mysqli->connect_errno) {
        echo json_encode(['success' => false, 'error' => 'DB connection error']);
        exit;
    }
    $usuario = $mysqli->real_escape_string($data['usuario']);
    $email = $mysqli->real_escape_string($data['email']);
    $password = isset($data['password']) && $data['password'] ? password_hash($data['password'], PASSWORD_DEFAULT) : '';

    // Antes de insertar, verifica si el correo ya existe
    $check = $mysqli->query("SELECT id FROM usuarios WHERE email='$email' LIMIT 1");
    if ($check && $check->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'El correo ya está registrado']);
        $mysqli->close();
        exit;
    }

    // Verifica si el usuario ya existe
    $checkUser = $mysqli->query("SELECT id FROM usuarios WHERE usuario='$usuario' LIMIT 1");
    if ($checkUser && $checkUser->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'El nombre de usuario ya está en uso']);
        $mysqli->close();
        exit;
    }

    $sql = "INSERT INTO usuarios (usuario, email, password) VALUES ('$usuario', '$email', '$password')";
    if ($mysqli->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'DB insert error']);
    }
    $mysqli->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
}
?>